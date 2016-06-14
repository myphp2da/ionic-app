<link href="<?php _e($theme_url); ?>assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet"/>
<link href="<?php _e($theme_url); ?>assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet"/>

<h3 class="timeline-title">
	<i class="fa fa-user"></i>&nbsp;Manage Customers
</h3>
<section class="panel">
	<div class="panel-body">
		<div class="an"></div>
		<div class="cf" id="customerList">
			<span class="loadMore">
				<a href="javascript:void(0);" class="ajaxButton loadMore firstLoad" data-lib="dataTable" data-url="account/load/customers" data-container="#customerList"
			                          data-action="add">Load More</a>
			</span>
		</div>
</section>