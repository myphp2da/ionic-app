<?php 
$id=$_POST['id']; 
$data = array('enmDeleted'=>'1', 'idDeletedBy'=>$_SESSION[PF.'USERID'], 'dtiDeleted'=>TODAY_DATETIME);
$product_obj->delete_product($id, $data);

?>