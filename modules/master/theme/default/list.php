<?php
	$type = _b64($_GET['t'], 'decode');
	$name = ucwords(str_replace('-', ' ', $type));

	$load_url = in_array($type, $master_obj::$_is_custom) ? 'master/load/'.$type : 'master/load/data?t='.$_GET['t'];
	$add_url = in_array($type, $master_obj::$_is_custom) ? $module_url.'/add-'.$type : $module_url.'/add?t='.$_GET['t'];
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<h3 class="timeline-title">
	<i class="fa fa-archive"></i>&nbsp;Manage <?php _e($name);?>
	<a href="<?php _e($add_url);?>" class="btn btn-shadow btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div>
</h3>
<section class="panel">
    <div class="panel-body">
	  	<ul class="cf" id="teamActivity">
	    	<li class="loadMore"> 
	    	<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="<?php _e($load_url);?>" data-container="#teamActivity" data-action="add">Load More</a>
	    	</li>
	  	 </ul> 
  	</div>
</section>