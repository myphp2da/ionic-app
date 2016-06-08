<?php
	if(!in_array('area', array_keys($master_obj->_types))) {
		_error(404);
		exit;
	}
	
	if(!$account_obj->checkAccess('area', 'list')) {
		_error('unauthorized');
		exit;
	}
?>
<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="master/load/data?t=<?php _e($_POST['t']);?>" data-container="#teamActivity" data-action="add" style="display:none;"></a>
<?php		
	$qAdd = "tinStatus != '2'";
	if(isset($_POST['q']) && !empty($_POST['q'])) {
		$qAdd = " and strArea like ('%".$_POST['q']."%')";
	}
	
	$master_data_count = $master_obj->getMasterCount($qAdd, 'area');
	if($master_data_count != 0) {
		$master_data = $master_obj->getMasters($qAdd, 'area');
?>
<div class="adv-table">
<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
<thead>
    <tr class="headBorder">
    <th width="5%" style="text-align:center;">No.</th>
    <th>Name</th>
    <th width="10%" style="text-align:center;">Action</th>
    </tr>
</thead>
<tbody>
<?php
$cnt = 1;
foreach($master_data as $data)
{
?>
    <tr class="<?php if($cnt%2!=0) echo 'odd';  else echo 'even';?>" id="recordsArray_<?php echo $data['id'];?>">
        <td style="text-align:center;"><?php echo $cnt++;?></td>
        <td><?php _e($data['strArea']);?></td>
        <td class="icons action" style="text-align:center;"> 
        
        <a href="<?php _e($module_url);?>/edit?t=<?php _e($_POST['t']);?>&id=<?php _e($data['id']);?>" class="fa fa-edit" title="Edit Area"></a>
        <?php
			if($data['tinStatus']=='1') {
                    $class1="class='fa fa-eye _green ajaxButton'";
                    $title1="title='Click to Deactivate'";
            } else {  
                    $class="class='fa fa-eye-slash _red ajaxButton'";
                    $title="title='Click to Activate'";
        	}
		?>
        <span id="activate_<?php echo $data['id'];?>">
           <a href='javascript:void(0);' <?php if($data['tinStatus']=='1'){ echo $class1; echo $title1; } else { echo $class; echo $title; }?>
			  data-url="master/load/change-status&id=<?php echo $data['id'];?>&type=area"  data-container="#activate_<?php echo $data['id'];?>" data-action="add"></a>
        </span>
			<a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-url="master/load/delete-data?type=area&id=<?php echo $data['id'];?>" data-action="delete" data-container="#tableListing" title="Delete"  data-trigger="a#dataLoad" data-msg="Are you really want to delete this record?"></a>
		</td>
    </tr>
<?php }?>
</tbody>
</table> 
<?php } else { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
	<tr><td height="50" align="center">No area available.</td></tr>
</table>
<?php } ?>
</div>
