<?php 
	class CustomError extends db_class {

        protected $_table = 'mst_error_logs';
        protected $error_path = 'errors/error.log';

        public function uniqueErrorLogs() {
            $file_content = file(SITE_PATH.$this->error_path);

            $errors_array = $error_details = array();
            if(sizeof($file_content) > 0) {
                foreach($file_content as $row) {
                    $errors = explode(":  ", $row);

                    if(empty($errors[1])) continue;

                    if(!in_array($errors[1], $error_details)) {
                        $error_details[] = $errors[1];
                        $errors_array[] = $errors;
                    }
                }
            }

            return $errors_array;
        }

        public function clearLogFile() {
            if(is_writable(SITE_PATH.$this->error_path)) {
                file_put_contents(SITE_PATH.$this->error_path, '');
            }
        }

        public function saveErrorLogs() {

            $errors_array = $this->uniqueErrorLogs();

            if(sizeof($errors_array) > 0) {

                foreach($errors_array as $error) {

                    $insert_array = array(
                        'strErrorDate' => $error[0],
                        'txtErrorDetails' => $error[1],
                        'dtiCreated' => TODAY_DATETIME
                    );

                    $this->insertByArray($this->_table, $insert_array);

                }

                $this->clearLogFile();
            }

            return sizeof($errors_array);
        }

        public function checkErrorLog() {

            if(file_exists(SITE_PATH.$this->error_path) && filesize(SITE_PATH.$this->error_path) > (100 * 1024)) {
                $error_count = $this->saveErrorLogs();

                if($error_count > 0) {

                    _class('emailer');
                    $emailer_obj = new emailer();

                    $edata = array(
                        'email'        => DEV_EMAIL,
                        'fullname'     => 'Developer(s)',
                        'errors_count' => $error_count,
                        'subject'      => MAIL_NAME . ' : ' . $error_count . ' error(s) found'
                    );
                    $emailer_obj->sendMail('system-errors', $edata);
                }
            }
        }
	}