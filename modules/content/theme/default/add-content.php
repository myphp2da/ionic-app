<?php
    _subModule('content', 'block');
    $block_obj = new block();

    $action = 'add';
    $blocks = $image_blocks = array();
    if (isset($req['parent']) && $req['parent'] == 'edit-content') {
        $action = 'edit';
        $contentDetail = $cont_obj->getContent("id=$_GET[id]");

        $blocks_details = $block_obj->getBlockDetailsByContentID($_GET['id']);

        if($blocks_details != 404) {
            foreach($blocks_details as $block) {
                $block_slug = $block['block_slug'];
                $content_block_id = $block['content_block_id'];
                $blocks[$block_slug]  = $block;
                if($block['block_slug'] == 'image') {
                    $image_blocks[$content_block_id][]  = $block;
                }
            }
        }
    }

    _module('master');
    $master_obj = new master();
    $where = "tinStatus='1' and tinStatus = '2'";
    $category = $master_obj->getMasters($where, 'category');

    $tags = $master_obj->getMasters($where,'tag');
    foreach($tags as $tag) {
        $tag_title[] = "'" . $tag['strTag'] . "'";
    }
    $tag_data = implode(',', $tag_title);
?>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-fileupload/bootstrap-fileupload.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>assets/bootstrap-datepicker/css/datepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php _e($theme_url);?>css/inputosaurus.css" rel="stylesheet" type="text/css" media="all"/>

<style type="text/css">
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
<div class="col-lg-12">
    <form id="content_form" name="content_form" method="post" class="cmxform form-horizontal tasi-form" action="<?php _e($module_url); ?>/manager/do" enctype="multipart/form-data">
        <input type="hidden" name="action" id="action" value="<?php _e($action);?>-content"/>
        <?php if ($req['parent'] == 'edit') { ?>
        <input type="hidden" name="id" id="id" value="<?php _e($contentDetail['id']);?>"/>
        <?php } ?>
        <section class="panel">
            <header class="panel-heading">Content Details</header>
            <div class="panel-body">
                <div class="form">
                    <div class="form-group">
                        <label for="title" class="control-label col-lg-2">Title:</label>

                        <div class="col-lg-7">
                            <input type="text" name="title" id="title" maxlength="255" value="<?php echo @$contentDetail['strTitle']; ?>" class="form-control required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cont_type" class="control-label col-lg-2">Content Type:</label>
                        <div class="col-lg-2">
                            <select name="cont_type" id="cont_type" class="form-control required">
                                <option value="">Select Type</option>
                                <option <?php if(@$contentDetail['strContentType']=='n'){?> selected="selected" <?php }?> value="n">News</option>
                                <option <?php if(@$contentDetail['strContentType']=='e'){?> selected="selected" <?php }?> value="e">Events</option>
                                <option <?php if(@$contentDetail['strContentType']=='p'){?> selected="selected" <?php }?> value="p">Product</option>
                                <option <?php if(@$contentDetail['strContentType']=='s'){?> selected="selected" <?php }?> value="p">Studio</option>
                                <option <?php if(@$contentDetail['strContentType']=='r'){?> selected="selected" <?php }?> value="p">Research</option>
                                <option <?php if(@$contentDetail['strContentType']=='c'){?> selected="selected" <?php }?> value="p">Case Studies</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-lg-2" for="content_date">Content Date:</label>
                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy"
                             data-date="<?php  if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])){
                                 echo date('d-m-Y',strtotime($contentDetail['dtContent']));}?>"
                             class="col-lg-2 input-append date dpYears">
                            <input type="text" readonly="readonly" value="<?php  if(isset($contentDetail['dtContent']) && !empty($contentDetail['dtContent'])){ echo date('d-m-Y',strtotime($contentDetail['dtContent']));}?>" size="16" name="content_date" id="content_date" class="form-control required" />(dd-mm-yyyy)
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tag" class="control-label col-lg-2">Tag</label>
                        <div class="col-mg-9">
                            <?php
                                if (isset($req['parent']) && $req['parent'] == 'edit') {
                                    $get_tags = $cont_obj->getRelTag($_GET['id']);
                                    if($get_tags != 404){
                                        foreach($get_tags as $get_tag) {
                                            $tag_name_data[] = $get_tag['tag_name'];
                                        }
                                        $edit_tag_name = implode(',', $tag_name_data);
                                    }
                                }
                            ?>
                            <input type="text" class="form-control required" name="tag" id="tag" value="<?php echo @$edit_tag_name; ?>">
                            <input type="hidden" name="final_tag" id="final_tag">

                        </div>
                    </div>
                    <div class="form-group"></div>
                </div>
                <?php
                    $content_blocks = $block_obj->getBlocks();

                    if($content_blocks != 404) {
                        ?>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="col-lg-2">Quick Add</label>
                                <div class="col-lg-8">
                                    <?php
                                        foreach($content_blocks as $block) {
                                            ?>
                                            <a class="content_block btn btn-info btn-xs" href="javascript:void(0);" data-type="<?php _e($block['strSlug']);?>" data-id="<?php _e($block['id']);?>"><i class="fa fa-plus"></i> <?php _e($block['strContentBlock']);?></a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div id="content-blocks">
                                <div class="form-group no-entries"<?php if(sizeof($blocks) > 0) { ?> style="display: none;"<?php } ?>>
                                    <label>Click links at right to add specific content blocks</label>
                                </div>
                                <?php
                                    $cnt = $icnt = 1;
                                    if(sizeof($blocks) > 0) {
                                        foreach($blocks as $slug => $block) {

                                            if($slug == 'text') {
                                                ?>
                                                <div class="form-group" id="block<?php _e($cnt);?>">
                                                    <input type="hidden" name="block[<?php _e($cnt);?>]" id="block_<?php _e($cnt);?>" value="<?php _e($slug);?>"/>
                                                    <input type="hidden" name="block_id[<?php _e($slug);?>]" id="block_id_<?php _e($cnt);?>" value="<?php _e($block['block_id']);?>"/>
                                                    <label for="<?php _e($slug);?>_<?php _e($cnt);?>" class="control-label col-lg-2">Descriptive Text:</label>
                                                    <div class="col-lg-7">
                                                        <textarea name="<?php _e($slug);?>[<?php _e($cnt);?>]" id="<?php _e($slug);?>_<?php _e($cnt);?>" class="form-control ckeditor" rows="15"><?php _e($block['txtContent']);?></textarea>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            if($slug == 'image') {
                                                $content_block_id = $block['content_block_id'];
                                                ?>
                                                <div class="form-group" id="block<?php _e($cnt);?>">
                                                    <input type="hidden" name="block[<?php _e($cnt);?>]" id="block_<?php _e($cnt);?>" value="<?php _e($slug);?>"/>
                                                    <input type="hidden" name="block_id[<?php _e($slug);?>]" id="block_id_<?php _e($cnt);?>" value="<?php _e($block['block_id']);?>"/>
                                                    <label for="<?php _e($slug);?>_<?php _e($cnt);?>" class="control-label col-lg-2">Images: <a href="javascript:void(0);" class="add-more" data-count="<?php _e($cnt);?>" data-type="<?php _e($slug);?>"><i class="fa fa-plus"></i> More</a></label>
                                                    <div class="col-lg-9" id="images<?php _e($cnt);?>">
                                                        <?php
                                                            if(isset($image_blocks[$content_block_id])) {
                                                                foreach($image_blocks[$content_block_id] as $iblock) {
                                                                    ?>
                                                                    <div class="col-lg-10">
                                                                        <img src="<?php _e(UPLOAD_URL); ?>content/medium/<?php _e($iblock['txtContent']); ?>" alt="image<?php _e($cnt); ?>"/>
                                                                    </div>
                                                                    <div class="col-lg-2">Actions</div>
                                                                    <?php
                                                                    $icnt++;
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            $cnt++;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                    } else {
                ?>
                        <div class="form-group">
                            <label>No content block is defined to add</label>
                        </div>
                <?php
                    }
                ?>
            </div>
        </section>
        <div class="col-lg-offset-2 col-lg-10">
            <input class="btn btn-info" type="submit" id="submit" value="Submit" name="submit"/>
            <input name="cancel" class="btn btn-danger" type="button" id="cancel-button" value="Cancel" onClick="window.location='list'"/>
        </div>
    </form>
</div>
<script type="text/javascript" src="<?php _e($theme_url);?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php _e($theme_url);?>js/inputosaurus.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="<?php _e($theme_url); ?>assets/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
    var count = <?php _e($cnt);?>;
    $(document).ready(function () {
        $("#content_form").validate();

        $('#content_date').datepicker({
            format: 'dd-mm-yyyy'
        });

        addMoreImages();

        $('.content_block').click(function(){

            var contents = $('#content-blocks');
            contents.find('.no-entries').hide();

            var dtype = $(this).attr('data-type');
            var did = $(this).attr('data-id');

            var html = '<div class="form-group" id="block'+count+'"><input type="hidden" name="block['+count+']" id="block_'+count+'" value="'+dtype+'" /><input type="hidden" name="block_id['+dtype+']" id="block_id_'+count+'" value="'+did+'" />';

            if(dtype == 'text') {
                html += '<label for="'+dtype+'_'+count+'" class="control-label col-lg-2">Descriptive Text:</label><div class="col-lg-7"><textarea name="'+dtype+'['+count+']" id="'+dtype+'_'+count+'" class="form-control ckeditor" rows="15"></textarea></div>';
            } else if(dtype == 'image') {
                html += '<label for="'+dtype+'_'+count+'" class="control-label col-lg-2">Images: <a href="javascript:void(0);" class="add-more" data-count="'+count+'" data-type="'+dtype+'"><i class="fa fa-plus"></i> More</a> </label><div class="col-lg-9" id="images'+count+'"><div class="col-lg-10"><input type="file" name="'+dtype+'['+count+'][]" id="'+dtype+'_'+count+'_1" value="" class="form-control" /></div><div class="col-lg-2">Actions</div></div>';
            } else if(dtype == 'social') {
                html += '<label for="'+dtype+'_'+count+'" class="control-label col-lg-2">Social Sharing:</label><div class="col-lg-7">Social sharing for this content entry is enabled.</div>';
            } else if(dtype == 'map') {
                html += '<label for="description" class="control-label col-lg-2">Latitude & Longitude:</label><div class="col-lg-3"><input type="text" name="title" id="title" maxlength="10" value="" class="form-control" placeholder="Latitude" /></div><div class="col-lg-3"><input type="text" name="title" id="title" maxlength="10" value="" class="form-control" placeholder="Longitude" /></div></div>';
            }

            html += '</div>'

            contents.append(html);

            if(dtype == 'text') {
                CKEDITOR.replace( dtype + '_' + count );
            } else if(dtype == 'image') {
                addMoreImages();
            }

            count++;
        });

        $('#tag').inputosaurus({
            width : '350px',
            autoCompleteSource : [<?php echo $tag_data; ?>],
            activateFinalResult : true,
            change : function(ev){
                $('#final_tag').val(ev.target.value);
            }
        });
    });

    function addMoreImages() {
        var image_count = <?php _e($icnt);?>;
        $('.add-more').click(function(){
            var count = $(this).attr('data-count');
            var dtype = $(this).attr('data-type');
            var container = $('#images'+count);

            container.append('<div class="col-lg-10"><input type="file" name="'+dtype+'['+count+'][]" id="image_'+count+'_'+image_count+'" value="" class="form-control" /></div><div class="col-lg-2">Actions</div>');
            image_count++;
        });
    }
</script>

