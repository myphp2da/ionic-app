<?php 
$id = $_REQUEST['eid'];
$type = $_REQUEST['ttype']; 
$typename = $type.'_name';
$name =$_REQUEST[$typename];  

if($_REQUEST['pgaction']=="add")
{
	if(!empty($name) && !empty($_REQUEST['ttype']) )
	{
		$result =$master_obj->getMasterCount("$typename='$name' and tinStatus = '1'", $type);
		if($result==0) {
			echo "true";
		} else {
			echo "false";
		}
	} else { echo "false"; }
	
} else {
	 
	if(!empty($name) && !empty($_REQUEST['ttype']) )
	{
		$result =$master_obj->getMasterCount("$typename='$name' and tinStatus = '1' and id!='$id' ", $type);
		if($result==0) {
			echo "true";
		} else {
			echo "false";
		}
	
	} else { echo "false";}
}
?>