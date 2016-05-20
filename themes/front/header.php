<?php
    _module('content');
    $content_obj = new content();

    $cnData = $content_obj->getFrontContent();

    $news = $casestudies = $research = $products = $studio = array();
    foreach ($cnData as $k => $v) {

        if ($v['strContentType'] == "n") {
            $news[] = $v;
        }
        if ($v['strContentType'] == "c") {
            $casestudies[] = $v;
        }
        if ($v['strContentType'] == "r") {
            $research[] = $v;
        }
        if ($v['strContentType'] == "p") {
            $products[] = $v;
        }
        if ($v['strContentType'] == "s") {
            $studio[] = $v;
        } /* here services equals to studio */
    }

    // echo '<pre>'; print_r($casestudies);
?>
<div class="header animatedParent cf">
	<a href="<?php _e(SITE_URL);?>" class="logo animated bounceInDown" title="NASCENT"><img alt="NASCENT" title="NASCENT" src="<?php _e($theme_url);?>images/nascent-logo.png"></a>
	<a href="javascript:void(0);" class="smallNav animated bounceInLeft"><span></span><span></span><span class="lastChild"></span></a>
</div>
<div class="menuBox">
	<div class="circle"></div>
	<ul class="mainNav cf">
		<li><a href="<?php _e(SITE_URL);?>" class="three-d homeTop">Home</a></li>
		<li><a href="<?php _e(SITE_URL);?>about">ABOUT</a>
			<ul class="subMenu cf">
				<li><a href="<?php _e(SITE_URL);?>about#company">The Company</a></li>
				<li><a href="<?php _e(SITE_URL);?>about#mantra">Our mantras</a></li>
                <li><a href="<?php _e(SITE_URL);?>about#team">Team</a></li>
				<li><a href="<?php _e(SITE_URL);?>about#clients">Our Clients</a></li>
			</ul>
		</li>
        <?php
            if(sizeof($studio) > 0) {
                ?>
                <li><a href="<?php _e(SITE_URL); ?>studios">STUDIO</a>
                    <ul class="subMenu cf">
                        <?php
                            foreach($studio as $st) {
                                ?>
                                <li><a href="<?php _e(SITE_URL.'studio/'.$st['strSlug']); ?>"><?php _e($st['strTitle']);?></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </li>
                <?php
            }
        ?>
		<li><a href="<?php _e(SITE_URL); ?>case-studies">CASE STUDIES</a></li>
		<li><a href="<?php _e(SITE_URL); ?>join-us">JOIN US</a></li>
		<li><a href="<?php _e(SITE_URL); ?>collaborate-us">COLLABORATE</a></li>
	</ul>
	<div class="followUs">
		<a href="javascript:void(0);"><i class="fa fa-twitter"></i></a>
		<a href="javascript:void(0);"><i class="fa fa-linkedin"></i></a>
		<a href="javascript:void(0);"><i class="fa fa-google-plus"></i></a>
		<a href="javascript:void(0);"><i class="fa fa-facebook"></i></a>
	</div>
</div>
