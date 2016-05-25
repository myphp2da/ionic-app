<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="page/load/all" data-container="#teamActivity" data-action="add" data-lib="dataTable" style="display:none;"></a>
<?php 
		
		$pg = isset($_POST['page']) ? $_POST['page'] : 1;
		
		$qAdd = "enmStatus = '2'";
		if(isset($_POST['q']) && !empty($_POST['q'])) {
			$qAdd .= " and strTitle like ('%".$_POST['q']."%')";
		}
		
		$page_count = $page_obj->getPagesCount($qAdd);
	 	 	 
		if($page_count != 0) {			
			$pages = $page_obj->getPages($qAdd);
	?>
<div class="adv-table">
  <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
    <thead>
      <tr class="headBorder">
        <th>No.</th>
        <th>Page Title</th>
        <th>URL</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
 		  	$cnt = 1;
		  	foreach($pages as $page) {
			  	if($page['enmStatus']=='1') {
					$class1="class='fa fa-eye _green ajaxButton'";
					$title1="title='Click to Deactivate'";
				} else {  
					$class="class='fa fa-eye-slash _red ajaxButton'";
					$title="title='Click to Activate'";
				}
		 ?>
      <tr>
        <td><?php echo $cnt++;?></td>
        <td><?php _e($page['strTitle'])?></td>
        <td><a href="<?php _e(SITE_URL.$page['strSlug'])?>" target="_blank"><?php _e('{site_url}'.$page['strSlug'])?></a></td>
        <td><a href="<?php _e($module_url);?>/edit?id=<?php echo $page['id'];?>" class="fa fa-edit" title="Edit Page"></a>
        <span id="activate_<?php echo $page['id'];?>">
        	<a href='javascript:void(0);'  <?php if($page['enmStatus']==1){ echo $class1; echo $title1; } else { echo $class; echo $title; }?> data-url="page/load/change-status?status=<?php echo $page['enmStatus']?>&id=<?php echo $page['id'];?>" data-container="#activate_<?php echo $page['id'];?>" data-action="add"></a>
        </span>
        <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-url="page/load/delete-data&id=<?php echo $page['id'];?>" data-action="delete" data-container="#tableListing" title="Delete Page" data-trigger="a#dataAll" data-msg="Are you really want to delete this record?"></a>
        <!--<a href="<?php /*_e($module_url);*/?>/preview/<?php /*_e($page['strSlug']);*/?>" class="fancybox fa fa-list-alt" id="fancybox" title="Preview"></a>--></td>
        
      </tr>
      <?php }?>
    </tbody>
  </table>
  <?php } else { ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingPage">
    <tr>
      <td height="50" align="center">No Page Available.</td>
    </tr>
  </table>
  <?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
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
