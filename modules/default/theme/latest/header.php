<!-- Start Header -->
<div id="header">
	<a href="<?php _e(SITE_URL);?>" id="logo<?php _e(ENV);?>"></a>
    <?php if(isset($_SESSION[PF.'USERID']) && isset($_SESSION[PF.'MAIN'])) { ?>
    <div class="ar">
     <div class="topBar cf">
     	<div class="userSetting">
        	<a href="#" class="userLink"><img src="<?php echo $theme_url;?>images/login-photo.jpg" alt="namokemp logo" />Idris Hakim</a>
            <ul class="userBox">
            	<li><a href="<?php _e(SITE_URL);?>account/profile">My Profile</a></li>
                <li><a href="<?php _e(SITE_URL);?>account/profile">Setting</a></li>
                <li><a href="<?php _e(SITE_URL);?>account/logout/do">Logout</a></li>
            </ul>
        </div>
        <a href="#" class="bell"><span>5</span></a>
        <a href="#" class="initiative linkUp">Initiative: I’m invited to <span>15</span></a>
        <a href="#" class="tasks linkUp">My pending tasks <span>23</span></a>
     </div>
    	<div class="an"></div>
        <div class="ar">
        <h2 class="headH2">I Volunteer For</h2>
   		<div class="volunSlider cf">
        	<ul class="cf">
            	<li><a href="#"><span class="f"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="tw"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="b"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="dp"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="tc"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="imk"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="rs"></span>Write<br>Post</a></li>
                <li><a href="#"><span class="dc"></span>Write<br>Post</a></li>
            </ul>
        </div>
        <div class="arrows"><a href="#" class="leftA disabled"></a><a href="#" class="rightA"></a></div>
        </div>
     </div>
     <?php } ?>
</div>
<!-- End Header -->