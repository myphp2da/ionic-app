<?php
	if(isset($_POST['arr']) && !empty($_POST['arr'])){
		
		$array = $_POST['arr'];
		
		if(isset($_POST[$array])) {
			$c = 1;
			foreach($_POST[$array] as $arr) {
				$updateByArray = array('position' => $c);
				$master_obj->updateMaster($updateByArray, $arr, $array); //echo $projObj->last_query; exit;
				$c++;
			}
		}
		
		die('Order have been successfully changed');
	}
?>