<link rel="stylesheet" type="text/css" href="<?php echo $theme_url;?>css/styles.css">
<script type="text/javascript" src="<?php echo $theme_url;?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_url;?>js/jcarousellite_1.0.1.min.js"></script> 
<script type="text/javascript" src="<?php echo $theme_url;?>js/jquery.cycle.all.js" ></script>
<script type="text/javascript" src="<?php echo $theme_url;?>js/general.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.banner').cycle({
        fx: 'fade',
        speed: 1000,
        timeout: 0,
		pager:  '#nav',
        pagerAnchorBuilder: function(idx, slide) { 
        return '#nav li:eq(' + idx + ') a'; }     
    });
});
</script>