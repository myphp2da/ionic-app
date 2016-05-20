<?php
if (isset($req['parent']) && $req['parent'] == 'edit') {
    $pageDetail = $page_obj->getPage("p.id=$_GET[id]");
}

_module('master');
$master_obj = new master();

    _class('file');


?>
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
        <!--<h3 class="timeline-title"><i class="fa fa-file-text-o"></i> &nbsp; Pages <a href="<?php /*echo _e($module_url); */?>/add" class="btn btn-shadow btn-primary ar"><i class="fa fa-plus"></i> Add New</a><div class="clear"></div></h3>-->

        <form id="page_form" name="page_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do">
            <input type="hidden" name="action" id="action" value="<?php if ($req['parent'] == 'add') {
                echo 'add';
            } else if ($req['parent'] == 'edit') {
                echo 'edit';
            } ?>"/>
            <input type="hidden" name="id" id="id" value="<?php if ($req['parent'] == 'edit') {
                echo $pageDetail['id'];
            } ?>"/>

                <section class="panel">
                    <header class="panel-heading">Page Details</header>
                    <div class="panel-body">
                        <div class="form">

                            <div class="form-group">
                                <label for="title" class="control-label col-lg-2">Page Title:</label>

                                <div class="col-lg-10">
                                    <input type="text" name="title" id="title" maxlength="50" value="<?php echo @$pageDetail['strTitle']; ?>" class="form-control required"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content" class="control-label col-lg-2">Content:</label>

                                <div class="col-lg-10">
                                    <textarea type="text" name="content" id="content" class="form-control ckeditor required" rows="15"><?php echo @$pageDetail['txtDescription'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="content" class="control-label col-lg-2">Short Description:</label>

                                <div class="col-lg-10"><textarea name="shortcontent" id="shortcontent" class="form-control" rows="10"><?php echo @$pageDetail['txtShortDescription'];?></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="page_template" class="control-label col-lg-2">Page Template:</label>

                                <div class="col-lg-10">
                                    <?php File::getTemplateDropDown($module_path.'theme/', @$pageDetail['strTemplate']);?>
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
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $("#page_form").validate({
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