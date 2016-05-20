<?php 
	_module('master');
	$master_obj = new master();
	
	$stateid = $_GET['id'];
	$districts = $master_obj->getMasters('state_id = '.$stateid, 'district');
	
	if($districts != 404) {
?>
<option value="" selected="selected">Select District</option>
<?php foreach($districts as $row) { ?>
<option value=<?php echo $row['id'];?>><?php echo $row['district_name'];?></option>
<?php
		}
	}
?>