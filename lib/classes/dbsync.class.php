<?php 
	class dbsync extends setting {

        public function getDBStructure() {
            $sql = "Show tables";
            $data = $this->getResults($sql);

            $structure = array();
            if($data != 404) {
                foreach($data as $row) {
                    $table = $row['Tables_in_'.DB_SCHEMA];
                    $structure['tables'][] = $table;

                    $sql = "describe ".$table;
                    $columns = $this->getResults($sql); //pr($columns);

                    if($columns != 404) {
                        foreach($columns as $column) {
                            $structure[$table][] = $column['Field'];
                        }
                    }
                }
            }

            return $structure;
        }

        public function encodeStructure() {
            $structure = $this->getDBStructure();

            $setting_array = array(
                'string' => 'DB_STRUCTURE',
                'value' => serialize($structure)
            );

            return $this->updateSetting($setting_array);
        }

        public function checkStructure() {
            $current_structure = $this->getDBStructure();

            $new_structure = unserialize($this->getSetting("DB_STRUCTURE")); //pr($new_structure['tables']);

            $not_available = array();
            if(isset($new_structure['tables'])) {
                foreach($new_structure['tables'] as $table) {
                    if(!in_array($table, $current_structure['tables'])) {
                        $not_available['tables'][] = $table;
                    }

                    if(isset($new_structure[$table])) {
                        foreach($new_structure[$table] as $column) {
                            if(isset($current_structure[$table]) && !in_array($column, $current_structure[$table])) {
                                $not_available[$table][] = $column;
                            }
                        }
                    }
                }
            }

            $extra_structure = array();
            if(isset($current_structure['tables'])) {
                foreach($current_structure['tables'] as $table) {
                    if(!in_array($table, $new_structure['tables'])) {
                        $extra_structure['tables'][] = $table;
                    }

                    if(isset($current_structure[$table])) {
                        foreach($current_structure[$table] as $column) {
                            if(isset($new_structure[$table]) && !in_array($column, $new_structure[$table])) {
                                $extra_structure[$table][] = $column;
                            }
                        }
                    }
                }
            }

            $not_available['extra'] = $extra_structure;

            return $not_available;
        }
	}