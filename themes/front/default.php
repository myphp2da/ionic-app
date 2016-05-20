<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php  _e((isset($page['title']) ? $page['title'] . ' - ' : '').SITE_TITLE); ?></title>
    <?php include_once($theme_path . 'head-content.php'); ?>
</head>
<body>
<?php include_once($theme_path . 'header.php'); ?>
<div class="main-container" id="main-container">
    <?php include_once($template); ?>
</div>
<?php include_once($theme_path . 'footer.php'); ?>
</body>
</html>