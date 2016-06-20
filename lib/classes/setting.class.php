<?php 
/** Settings class to load all default settings from the database */
	include_once('pdo.class.php');
	
	class setting extends db_class {
		var $_table = 'mst_settings';
		
		function insertSetting($data) {
			$this->insertByArray($this->_table, $data);
		}
		
		function getSettings($where) {
			$sql = "select main.* 
					from ".$this->_table." as main 
					where loadable = '1'".$where;
			return $this->getResults($sql);
		}

        function getSetting($string) {
            $sql = "select main.*
					from ".$this->_table." as main
					where string = '".$string."'";
            $data = $this->getResult($sql);
            return $data['value'];
        }

        function updateSetting($setting) {
            $update_array = array(
                'value' => $setting['value']
            );
            return $this->updateByArray($this->_table, $update_array, "string = '".$setting['string']."'");
        }
		
		function loadConstants() {
			$settings = $this->getSettings(" and constant = '1'");
			if($settings != 404) {
				foreach($settings as $setting) {
					if(!defined($setting['string'])) {
						define($setting['string'], $setting['value']);
					}
				}
			}
		}
		
		function loadVariables() {
			return $this->getSettings(" and constant = '0'");
		}
	}