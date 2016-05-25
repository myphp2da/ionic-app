<?php
	$type = _b64($_GET['t'], 'decode');
	$name = ucwords(str_replace('-', ' ', $type));
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title">
	<i class="fa fa-archive"></i>&nbsp;Manage <?php _e($name);?>
	<a href="<?php echo _e($module_url);?>/add?t=<?php _e($_GET['t']);?>" class="btn btn-shadow btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
</h3>
<section class="panel">
    <div class="panel-body">
	  	<ul class="cf" id="teamActivity">
	    	<li class="loadMore"> 
	    	<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="master/load/data?t=<?php _e($_GET['t']);?>" data-container="#teamActivity" data-action="add">Load More</a>
	    	</li>
	  	 </ul> 
  	</div>
</section>