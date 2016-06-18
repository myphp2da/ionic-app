<?php 
	class CustomError extends db_class {

        protected $_table = 'mst_error_logs';
        protected $error_path = SITE_PATH.'errors/error.log';

        public function uniqueErrorLogs() {
            $file_content = file($this->error_path);

            $errors_array = array();
            if(sizeof($file_content) > 0) {
                $error_details = array();
                foreach($file_content as $row) {
                    $errors = explode(":  ", $row);

                    if(empty($errors[1])) exit;

                    if(!in_array($errors[1], $error_details)) {
                        $error_details[] = $errors[1];
                        $errors_array[] = $errors;
                    }
                }
            }

            return $errors_array;
        }

        public function clearLogFile() {
            file_put_contents($this->error_path, '');
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

            if(file_exists($this->error_path) && filesize($this->error_path) > (1024*1024)) {
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