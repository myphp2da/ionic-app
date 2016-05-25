<?php 
	$_SESSION['previous_product'] = $_SERVER['REQUEST_URI'];
	
    if(!isset($req['product'])){
	  	$pg = 1;
		if(isset($_SESSION['q'])) { 
			unset($_SESSION['q']); 
		}
	} else {
		$pg = $req['product'];
  	}
	if(isset($_SESSION['error'])){ 
	   unset($_SESSION['error']);
	}
?>
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_product.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
<link href="<?php _e($theme_url);?>assets/fancyBox/jquery.fancybox.css" rel="stylesheet" />
<script src="<?php _e($theme_url);?>assets/fancyBox/jquery.fancybox.js" type="text/javascript"></script>
<h3 class="timeline-title"><i class="fa fa-file-text-o"></i> &nbsp; Products <a href="<?php echo _e($module_url);?>/add" class="btn btn-shadow btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div></h3>
<section class="panel">
    <div class="panel-body">
  	<div class="an"></div>
	<ul class="teamActivity cf" id="teamActivity">
    	<li class="loadMore"><a href="javascript:void(0);" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="product/load/all" data-container="#teamActivity" data-action="add">Load More</a></li>
  	</ul></div>
</section> 		  