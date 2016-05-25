<?php
    if (isset($req['parent']) && $req['parent'] == 'edit') {
        $product_details = $product_obj->getProduct("p.id=$_GET[id]");
    }

    _module('master');
    $master_obj = new master();

    $categories = $master_obj->getMasters("idParent != 0", 'category');

    $quantities = $master_obj->getMasters(1, 'quantity');
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<style type="text/css">
    textarea.ckeditor {
        visibility: visible !important;
        display: block !important;
        height: 0 !important;
        border: none !important;
        resize:none;
        overflow: hidden;
        padding: 0 !important;
    }
</style>
<div class="col-lg-12">
        <!--<h3 class="timeline-title"><i class="fa fa-file-text-o"></i> &nbsp; Products <a href="<?php /*echo _e($module_url); */?>/add" class="btn btn-shadow btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div></h3>-->

        <form id="product_form" name="product_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do" enctype="multipart/form-data">
            <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'add') {
                echo 'add';
            } else if ($req['parent'] == 'edit') {
                echo 'edit';
            } ?>"/>
            <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
                echo $product_details['id'];
            } ?>"/>

                <section class="panel">
                    <header class="panel-heading">Product Details</header>
                    <div class="panel-body">
                        <div class="form">

                            <div class="form-group">
                                <label for="product_name" class="control-label col-lg-2">Product Name:</label>

                                <div class="col-lg-10">
                                    <input type="text" name="product_name" id="product_name" maxlength="50" value="<?php echo @$product_details['strProduct']; ?>" class="form-control required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="control-label col-lg-2">Original Price:</label>

                                <div class="col-lg-4">
                                    <input type="text" name="price" id="price" maxlength="50" value="<?php echo @$product_details['decPrice']; ?>" class="form-control required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="current_price" class="control-label col-lg-2">Current Price:</label>

                                <div class="col-lg-4">
                                    <input type="text" name="current_price" id="current_price" maxlength="50" value="<?php echo @$product_details['decCurrentPrice']; ?>" class="form-control required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php
                                    $upload_path = UPLOAD_PATH . 'product/';
                                    $upload_url = UPLOAD_URL . 'product/';
                                    if(isset($product_details['strImageName']) && !empty($product_details['strImageName'])) {
                                        if (file_exists($upload_path . $product_details['strImageName'])) {
                                            $imgurl = $upload_url . $product_details['strImageName'];
                                            ?>
                                            <input type="hidden" id="old_imgurl" name="old_imgurl" value="<?php _e($product_details['strImageName']);?>">
                                            <?php
                                        } else {
                                            $imgurl = SITE_URL . 'themes/default/img/no-image.gif';
                                        }
                                    }
                                ?>
                                <label for="content" class="control-label col-lg-2">Cover Photo:</label>
                                <div class="col-md-9">
                                    <div class="fileupload <?php if(isset($product_details['strImageName']) && !empty($product_details['strImageName']) && file_exists($upload_path . $product_details['strImageName'])) { ?>fileupload-exists<?php } else { ?>fileupload-new<?php } ?>" data-provides="fileupload">
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

                            <div class="form-group">
                                <label for="state" class="control-label col-lg-2">Select Quantity</label>
                                <div class="col-lg-8">
                                    <?php
                                    if($quantities != 404){
                                        foreach($quantities as $quantity) {
                                            ?>
                                            <div class="col-lg-4">
                                                <input type="checkbox" name="quantity[]" id="quantity_<?php _e($quantity['id']);?>" value="<?php _e($quantity['id']);?>"/>
                                                <?php _e($quantity['strQuantity']); ?>
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="text" placeholder="Write Approx quantity" class="form-control" name="quantity_amount[<?php _e($quantity['id']);?>]" id="quantity_amount_<?php _e($quantity['id']);?>" value=""/>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content" class="control-label col-lg-2">Product Description:</label>

                                <div class="col-lg-10">
                                    <textarea type="text" name="content" id="content" class="form-control ckeditor required" rows="15"><?php echo @$product_details['txtDescription'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content" class="control-label col-lg-2">Short Description:</label>

                                <div class="col-lg-10"><input name="shortcontent" id="shortcontent" class="form-control" value="<?php echo @$product_details['strShortDescription'];?>" maxlength="255" />
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="category" class="control-label col-lg-2">Category:</label>

                                <div class="col-lg-6">
                                    <select name="category" id="category" class="form-control required">
                                        <option value="" selected="selected"> -- Select --</option>
                                        <?php
                                            foreach ($categories as $category) {
                                                ?>
                                                <option
                                                    value="<?php echo $category['id']; ?>"<?php if (@$product_details['idCategory'] == $category['id']) { ?> selected="selected"<?php } ?>><?php echo $category['strCategory']; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            <div class="col-lg-offset-2 col-lg-10">
                <input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
                <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'"/>
            </div>
        </form>
</div>
<script type="text/javascript" src="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $("#product_form").validate({
            rules: {
                content: {
                    required: function() {
                        CKEDITOR.instances.content.updateElement();
                    }
                }
            },
            errorPlacement: function(error, element)
            {
                if (element.attr("name") == "content") {
                    error.insertAfter("textarea#content");
                } else {
                    error.insertAfter(element);
                }
            }
        });
});
</script>