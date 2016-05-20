<a href="javascript:void(0);" id="dataLoad" class="ajaxButton loadMore firstLoad" data-url="product/load/all?sort=latest" data-container="#teamActivity" data-action="add" data-lib="dataTable"
   style="display:none;"></a>
<?php

    $pg = isset($_POST['product']) ? $_POST['product'] : 1;

    $qAdd = "p.tinStatus != '2'";
    if(isset($_POST['q']) && !empty($_POST['q'])) {
        $qAdd .= " and p.strProduct like ('%" . $_POST['q'] . "%')";
    }

    $product_count = $product_obj->getProductsCount($qAdd);

    if($product_count != 0) {
    $products = $product_obj->getProducts($qAdd);
?>
<div class="adv-table">
    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="table-info">
        <thead>
        <tr class="headBorder">
            <th>No.</th>
            <th>Product Title</th>
            <th>Price</th>
            <th>Offered Price</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $cnt = 1;
            foreach($products as $product) {
                if($product['tinStatus'] == '1') {
                    $class1 = "class='fa fa-eye _green ajaxButton'";
                    $title1 = "title='Click to Deactivate'";
                } else {
                    $class = "class='fa fa-eye-slash _red ajaxButton'";
                    $title = "title='Click to Activate'";
                }
                ?>
                <tr>
                    <td><?php echo $cnt++; ?></td>
                    <td><?php _e($product['strProduct']) ?></td>
                    <td><?php _e($product['decPrice']) ?></td>
                    <td><?php _e($product['decCurrentPrice']) ?></td>
                    <td><?php _e($product['category_name']) ?></td>
                    <td><a href="<?php _e($module_url); ?>/edit?id=<?php echo $product['id']; ?>" class="fa fa-edit" title="Edit Product"></a>
        <span id="activate_<?php echo $product['id']; ?>">
        	<a href='javascript:void(0);' <?php if($product['tinStatus'] == 1) {
                echo $class1;
                echo $title1;
            } else {
                echo $class;
                echo $title;
            } ?> data-url="product/load/change-status?status=<?php echo $product['tinStatus'] ?>&id=<?php echo $product['id']; ?>" data-container="#activate_<?php echo $product['id']; ?>"
               data-action="add"></a>
        </span>
                        <a href='javascript:void(0);' class="ajaxButton fa fa-trash-o" data-url="product/load/delete-data?sort=latest&id=<?php echo $product['id']; ?>" data-action="delete"
                           data-container="#tableListing" title="Delete Product" data-trigger="a#dataAll" data-msg="Are you really want to delete this record?"></a>
                        <!--<a href="<?php /*_e($module_url);*/ ?>/preview/<?php /*_e($product['strSlug']);*/ ?>" class="fancybox fa fa-list-alt" id="fancybox" title="Preview"></a>--></td>

                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingProduct">
            <tr>
                <td height="50" align="center">No Product Available.</td>
            </tr>
        </table>
    <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function (e) {
        $(".fancybox").click(function () {
            $.fancybox.open({
                href: this.href,
                type: 'iframe',
                padding: 5,
                minWidth: 320,
                minHeight: 480,
                maxWidth: 320,
                maxHeight: 480,
                topRatio: 0,
                leftRatio: 0
            });
            return false;
        });
    });
</script>
