<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="content/load/all?sort=latest" data-container="#teamActivity" data-action="add" data-lib="dataTable" style="display:none;"></a>
<?php 
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		$qAdd = "tinStatus = '2'";
		if(isset($_POST['q']) && !empty($_POST['q'])) {
			$qAdd .= " and strTitle like ('%".$_POST['q']."%')";
		}

    /* $array_search = array('enmDeleted' => '0');
	 $page_count = $cont_obj->getContentCount($array_search);*/

$array_search = array(':enmDeleted' => '0');
$cont_obj->setPrepare($array_search);
$page_count = $cont_obj->getContentCount("enmDeleted = :enmDeleted");
	 	 	 
		if($page_count != 0) {			
			$pages = $cont_obj->getContents($qAdd);
	?>
<div class="adv-table">
  <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
    <thead>
      <tr class="headBorder">
        <th width="70">No.</th>
        <th>Title</th>
        <th width="10%">Type</th>
        <th width="10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
 		  	$cnt = 1;
		  	foreach($pages as $page) {
			  	if($page['tinStatus']=='1') {
					$class1="class='fa fa-eye _green ajaxButton'";
					$title1="title='Click to Deactivate'";
				} else {  
					$class="class='fa fa-eye-slash _red ajaxButton'";
					$title="title='Click to Activate'";
				}

				if($page['strContentType']=='n'){
                    $type='News';
				}elseif($page['strContentType']=='p'){
					$type='Product';
				}elseif($page['strContentType']=='e'){
                    $type='Events';
				}elseif($page['strContentType']=='s'){
					$type='Studio';
				}elseif($page['strContentType']=='c'){
					$type='Case-Studies';
				}elseif($page['strContentType']=='r'){
					$type='Research';
				}
		 ?>
      <tr>
        <td><?php echo $cnt++;?></td>
        <td><?php _e($page['strTitle']);?></td>
		<td><?php _e($type);?></td>
        <td><a href="<?php _e($module_url);?>/edit?id=<?php echo $page['id'];?>" class="fa fa-edit" title="Edit Content"></a>
        <span id="activate_<?php echo $page['id'];?>">
        	<a href='javascript:void(0);'  <?php if($page['tinStatus']==1){ echo $class1; echo $title1; } else { echo $class; echo $title; }?> data-url="content/load/change-status?status=<?php echo $page['tinStatus']?>&id=<?php echo $page['id'];?>" data-container="#activate_<?php echo $page['id'];?>" data-action="add"></a>
        </span>
    	<a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-action="delete"
		   data-msg="Are you really want to delete this record?"   data-url="content/load/delete-data?sort=latest&id=<?php echo $page['id'];?>" data-container="#tableListing" title="Delete Content" data-trigger="a#dataLoad"></a>
       </td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
    <tr>
      <td height="50" align="center">No Content available.</td>
    </tr>
  </table>
  <?php } ?>
</div>
<script type="text/javascript">
$().ready(function() {
    $(".fancybox").click(function() {
		$.fancybox.open({
			href : this.href,
			type : 'iframe',
			padding : 5,
			minWidth  : 320,
			minHeight : 480,
			maxWidth  : 320,
			maxHeight : 480	,
			topRatio  :	0,
		    leftRatio :	0
		});
		return false;
	});
});
</script>
