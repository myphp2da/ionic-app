<?php

    class DbDate extends db_class
    {
        /** @var string
         * Date log master table name
         */
        protected $_table = 'rel_date_logs';

        /** @var array
         * Type of dates array
         */
        protected $_date_types = array(
            'created', 'modified', 'deleted', 'registered', 'activated', 'ordered'
        );

        protected $_account_types = array(
            'account', 'customer'
        );

        protected $_account_type;
        protected $_account_id;

        public function setAccount($account_type, $account_id) {

            if(!isset($data['account_type']) || empty($data['account_type']) || !in_array($data['account_type'], $this->_account_types)) {
                return false;
            }

            $this->_account_id = $account_id;
            $this->_account_type = $account_type;

            return true;
        }

        /** Save db date for provided data
         * @param array $data: Array of data to be inserted
         * @return array | bool : Returns last insert ID on success for provided data on success,
         *              Otherwise returns false
         */
        public function logDate($data){

            if(!isset($data['date_type']) || empty($data['date_type']) || !in_array($data['date_type'], $this->_date_types)) {
                return false;
            }

            $date_array = array(
                'strType' => $data['type'],
                'idType' => $data['id'],
                'strAccountType' => $this->_account_type,
                'strDateType' => $data['date_type'],
                'idAccount' => $this->_account_id,
                'dtiSystem' => TODAY_DATETIME,
                'strIPAddress' => USERIP,
                'strRemarks' => $data['remarks']
            );

            return $this->insertByArray($this->_table, $date_array);
        }
    }