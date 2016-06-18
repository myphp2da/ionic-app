<?php
/** Add any master data by providing master type */

if (!isset($_GET['t']) || empty($_GET['t']) || !in_array(_b64($_GET['t'], 'decode'), array_keys($master_obj->_types))) {
	_error(404);
	exit;
}

$type = _b64($_GET['t'], 'decode');
$name = ucwords(str_replace('-', ' ', $type));

$db_name_field = 'str' . str_replace(' ', '', $name);

$input_name = str_replace('-', '_', $type) . '_name';

if (!$account_obj->checkAccess($type, 'add')) {
	_error('unauthorized');
	exit;
}

$action = 'add';

$where = 1; $childs = 0;
if (strstr($req['parent'], 'edit')) {
	$action = 'edit';
	$master_details = $master_obj->getMaster("id = " . $_GET['id'], $type);

	$childs = $master_obj->getChilds($_GET['id'], $type);

	$where = "id != " . $_GET['id'];
}

if (in_array($type, $master_obj::$_have_parents) && $childs == 0) {
	$categories = $master_obj->getMasters("idParent = 0 and ".$where, 'category');
} else {
	$categories = 404;
}
?>
<?php if (in_array($type, $master_obj::$_have_photo)) { ?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<?php } ?>
<style type="text/css">
	div.element {
		float: left;
		width: 580px;
	}

	label.entry {
		float: left;
		width: 250px;
		padding: 5px;
	}

	label.element-entry {
		padding: 5px;
		float: none;
	}

	div.box {
		border: 1px solid #DDD;
		background: #f4f3ee;
		padding: 10px;
		height: 200px;
		overflow: auto;
		margin: 5px 0;
		-moz-box-shadow: inset 0 0 2px #e2e2e2;
		-webkit-box-shadow: inset 0 0 2px #e2e2e2;
		box-shadow: inset 0 0 2px #e2e2e2;
	}

	textarea.ckeditor {
		visibility: visible !important;
		display: block !important;
		height: 0 !important;
		border: none !important;
		resize: none;
		overflow: hidden;
		padding: 0 !important;
	}

</style>
<h3 class="timeline-title"><i class="fa fa-user"></i>&nbsp; Manage <?php _e($name);?></h3>
<section class="panel">
	<header class="panel-heading"><?php _e(ucwords($action)); ?> <?php _e($name);?></header>
	<div class="panel-body">
		<div class="form">
			<form id="master_form" name="master_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e(SITE_URL); ?>master/manager/do" enctype="multipart/form-data">
				<input type="hidden" name="action" id="action" value="<?php _e($action); ?>">
				<input type="hidden" id="type" name="type" value="<?php _e($_GET['t']); ?>"/>
				<?php if ($action == 'edit') { ?>
					<input type="hidden" id="id" name="ID" value="<?php _e($master_details['id']); ?>"/>
				<?php } ?>


				<div class="form-group"><label for="pname" class="control-label col-lg-2"><?php echo "Content type";//_e($name);?> Name:</label>

					<div class="col-lg-10">
						<input name="<?php _e($input_name); ?>" id="<?php _e($input_name); ?>" type="text" class="form-control required" value="<?php _e(@$master_details[$db_name_field]); ?>"
						       maxlength="50"/>
					</div>
				</div>

				<?php
				if (in_array($type, $master_obj::$_have_parents) && $categories != 404 ) {
					?>
					<div class="form-group">
						<label for="parent" class="control-label col-lg-2">Parent:</label>

						<div class="col-lg-6">
							<select name="parent" id="parent" class="form-control">
								<option value="" selected="selected"> -- Select --</option>
								<?php
								foreach ($categories as $category) {
									?>
									<option
										value="<?php echo $category['id']; ?>"<?php if (@$master_details['idParent'] == $category['id']) { ?> selected="selected"<?php } ?>><?php echo $category['strCategory']; ?></option>
									<?php
								}
								?>
							</select>
						</div>
					</div>
					<?php
				}
				?>
                <?php if (in_array($type, $master_obj::$_have_photo)) { ?>
				<div class="form-group">
					<?php
					$upload_path = UPLOAD_PATH . $type . '/';
					$upload_url = UPLOAD_URL . $type . '/';
					if(isset($master_details['strImageName']) && !empty($master_details['strImageName'])) {
						if (file_exists($upload_path . $master_details['strImageName'])) {
							$imgurl = $upload_url . $master_details['strImageName'];
                            ?>
                            <input type="hidden" id="old_imgurl" name="old_imgurl" value="<?php _e($master_details['strImageName']);?>">
                            <?php
						} else {
							$imgurl = SITE_URL . 'themes/default/img/no-image.gif';
						}
					}
                    ?>
					<label for="content" class="control-label col-lg-2">Cover Photo:</label>
					<div class="col-md-9">
						<div class="fileupload <?php if(isset($master_details['strImageName']) && !empty($master_details['strImageName']) && file_exists($upload_path . $master_details['strImageName'])) { ?>fileupload-exists<?php } else { ?>fileupload-new<?php } ?>" data-provides="fileupload">
							<div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
								<img src="<?php _e($theme_url);?>img/no-image.gif" alt="No image">
							</div>
							<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"><img src="<?php _e(@$imgurl);?>" alt=""></div>
							<div>
                               <span class="btn btn-white btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select image</span>
                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                <input type="file" class="default" id="imgurl" name="imgurl" />
                              </span>
								<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Remove</a>
							</div>
						</div>
					</div>
				</div>
                <?php } ?>

				<div class="form-group"><label for="desc" class="control-label col-lg-2">Description:</label>
					<div class="col-lg-10"><textarea name="description" id="description" type="text" class="form-control ckeditor required"><?php _e(@$master_details['txtDescription']); ?></textarea>
					</div>
				</div>

				<div class="form-group">
					<div class="col-lg-offset-2 col-lg-10">
						<input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
						<input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list?t=<?php _e($_GET['t']); ?>'"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<?php if (in_array($type, $master_obj::$_have_photo)) { ?>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$("#master_form").validate({
			rules: {
				'<?php _e($input_name);?>': {
					required: true
				}, description: {
					required: function () {
						CKEDITOR.instances.description.updateElement();
					}
				}
			},
			messages: {
				'<?php _e($input_name);?>': {
					required: "Content type is required"
				},
				'desc': "Required"
			},
			errorPlacement: function (error, element) {
				if (element.attr("name") == "description") {
					error.insertBefore("textarea#description");
				} else {
					error.insertBefore(element);
				}
			}
		});
	});

</script>