<!-- Stare Header --><?php include($theme_path . 'head-content.php'); ?><!-- End Header -->

<!-- Stare Video -->
<div class="minHeight cf">
    <div class="start">
        <video class="video" autoplay muted loop>
            <source class="source-vid" src="<?php _e($theme_url); ?>video/video.mp4" type="video/mp4"/>
            <source class="source-vid" src="<?php _e($theme_url); ?>video/video.ogv" type="video/ogv"/>
            <source class="source-vid" src="<?php _e($theme_url); ?>video/video.flv" type="video/flv"/>
        </video>
        <div class="homeBanner cf">
            <ul class="slidSowTop cycle-slideshow cf" data-cycle-slides="li" data-cycle-speed="1500" data-cycle-timeout="5000" data-cycle-loader="true">
                <li><img src="images/blanck-sp.png" alt=""/>

                    <div class="bannerDeta">
                        <div class="bannConn">
                            <div class="zIndexOne"><span>Changing</span> the way you <span class="bi">live, play</span> and <span class="bi">work</span></div>
                            <div class="square"></div>
                        </div>
                    </div>
                    <span class="slideNo">01</span></li>
                <li><img src="images/blanck-sp.png" alt=""/>

                    <div class="bannerDeta">
                        <div class="bannConn">
                            <div class="zIndexOne"><span>Changing</span> the</div>
                            <div class="square"></div>
                        </div>
                    </div>
                    <span class="slideNo">02</span></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Video -->

<!-- Stare Header -->
<?php include($theme_path . 'header.php'); ?>
<!-- End Header -->
<!-- Stare Contant -->
<div class="wrapper">
    <div class="row">
        <div class="col-md-8">
            <!-- Start 1 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-7 animated fadeInUpShort" data-id="1">
                    <div class="bigBlog">
                        <a href="<?php _e(SITE_URL . 'case-study/' . $casestudies[0]['strSlug']); ?>" class="blogLink">
                            <div class="picView"><img src="<?php _e($theme_url); ?>images/case-study.jpg" alt="" class="picW100p"/>

                                <div class="blogName">Case Study</div>
                            </div>
                            <h3><?php _e($casestudies[0]['strTitle']); ?></h3>Read More
                        </a>

                        <div class="otherLink">
                            <?php
                                $rsTag = $content_obj->getContentTag("mst_cnt.id=" . $casestudies[0]['id']);
                                foreach ($rsTag as $value) { ?>
                                    <a href="#"><?php _e($value['strTag']); ?></a>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <a href="<?php _e(SITE_URL . 'research/' . $research[0]['strSlug']); ?>" class="blogLink smallBlog animated fadeInUpShort" data-id="2">
                        <div class="picView">
                            <img src="<?php _e($theme_url); ?>images/research.jpg" alt="" class="picW100p"/>

                            <div class="blogName">Research</div>
                        </div>
                        <h3><?php _e($research[0]['strTitle']); ?></h3> Read More
                    </a>
                    <a href="#" class="picLink animated fadeInUpShort" data-id="3">
                        <img src="<?php _e($theme_url); ?>images/cmmi-3.jpg" alt=""/>
                        <span class="picName">CMMI-3</span>
                        <span class="readMore">Read More</span>
                    </a>
                </div>
            </div>
            <!-- End 1 -->

            <!-- Start 2 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-5">
                    <div class="noteonly note2 cf animated fadeInUpShort" data-id="1">
                        <div class="square"><span class="btnBefore"></span><span class="btnAfter"></span></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/>Technology <span>exists</span> <br>
                            to <span>advance</span> <br>
                            the <span class="bi">human race</span> <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/>
                        </h4>
                    </div>
                    <a href="<?php _e(SITE_URL . 'research/' . $research[1]['strSlug']); ?>" class="blogLink smallBlog animated fadeInUpShort" data-id="2">
                        <div class="picView">
                            <img src="<?php _e($theme_url); ?>images/research-2.jpg" alt="" class="picW100p"/>

                            <div class="blogName">Research</div>
                        </div>
                        <h3><?php _e($research[1]['strTitle']); ?></h3> Read More </a>
                    <div class="otherLink">
                        <?php
                            $rsTag = $content_obj->getContentTag("mst_cnt.id=" . $research[1]['id']);
                            foreach ($rsTag as $value) { ?>
                                <a href="#"><?php _e($value['strTag']); ?></a>
                            <?php } ?>

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bigBlog animated fadeInUpShort" data-id="3">
                        <a href="<?php _e(SITE_URL . 'news/' . $news[0]['strSlug']); ?>" class="blogLink">
                            <div class="picView"><img src="<?php _e($theme_url); ?>images/news.jpg" alt="" class="picW100p"/>

                                <div class="blogName">News</div>
                            </div>
                            <h3><?php _e($news[0]['strTitle']); ?></h3> Read More
                        </a>

                        <div class="otherLink">
                            <?php
                                $rsTag = $content_obj->getContentTag("mst_cnt.id=" . $news[0]['id']);
                                foreach ($rsTag as $value) { ?>
                                    <a href="#"><?php _e($value['strTag']); ?></a>
                                <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <!-- End 2 -->

            <!-- Start 3 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-7">
                    <div class="bigBlog animated fadeInUpShort" data-id="1">
                        <a href="<?php _e(SITE_URL . 'case-study/' . $casestudies[1]['strSlug']); ?>" class="blogLink">
                            <div class="picView">
                                <img src="<?php _e($theme_url); ?>images/case-study-2.jpg" alt="" class="picW100p"/>

                                <div class="blogName">Case Study</div>
                            </div>
                            <h3><?php _e($casestudies[1]['strTitle']); ?></h3>Read More
                        </a>

                        <div class="otherLink">
                            <?php
                                $rsTag = $content_obj->getContentTag("mst_cnt.id=" . $casestudies[1]['id']);
                                foreach ($rsTag as $value) { ?>
                                    <a href="#"><?php _e($value['strTag']); ?></a>
                                <?php } ?>

                        </div>
                    </div>
                    <div class="noteonly note3 cf animated fadeInUpShort" data-id="2">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/><span>Rules</span><br>
                            got <span class="bi">people</span> nowhere <br>
                            <span>fantastic.</span> <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/></h4>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="noteonly cf animated fadeInUpShort" data-id="3">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/>People <span>love</span> <br>
                            <span class="bi">technology</span><br>
                            <span>that</span> loves <span class="bi">people</span>. <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/></h4>
                    </div>
                    <a href="#" class="picLink animated fadeInUpShort" data-id="4">
                        <img src="<?php _e($theme_url); ?>images/join-us.jpg" alt=""/><span class="picName">Join Us</span><span
                            class="readMore">Read More</span></a> <a href="#" class="picLink animated fadeInUpShort" data-id="5"><img src="<?php _e($theme_url); ?>images/our-team.jpg" alt=""/><span
                            class="picName">Our Team</span><span class="readMore">Read More</span></a></div>
            </div>
            <!-- End 3 -->

            <!-- Start 4 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-5"><a href="<?php _e(SITE_URL . 'research/' . $research[2]['strSlug']); ?>" class="blogLink smallBlog animated fadeInUpShort" data-id="1">
                        <div class="picView"><img src="<?php _e($theme_url); ?>images/research-3.jpg" alt="" class="picW100p"/>

                            <div class="blogName">Research</div>
                        </div>
                        <h3><?php _e($research[2]['strTitle']); ?></h3>
                        Read More </a> <a href="<?php _e(SITE_URL . 'news/' . $news[1]['strSlug']); ?>" class="blogLink smallBlog animated fadeInUpShort" data-id="2">
                        <div class="picView"><img src="<?php _e($theme_url); ?>images/news-2.jpg" alt="" class="picW100p"/>

                            <div class="blogName">News</div>
                        </div>
                        <h3><?php _e($news[1]['strTitle']); ?></h3>
                        Read More </a></div>
                <div class="col-md-7">
                    <div class="bigBlog animated fadeInUpShort" data-id="3">
                        <a href="#" class="blogLink">
                            <div class="picView"><img src="<?php _e($theme_url); ?>images/case-study-3.jpg" alt="" class="picW100p"/>

                                <div class="blogName">Case Study</div>
                            </div>
                            <h3><?php _e($casestudies[2]['strTitle']); ?></h3>Read More
                        </a>

                        <div class="otherLink">
                            <?php
                                $rsTag = $content_obj->getContentTag("mst_cnt.id=" . $casestudies[2]['id']);
                                foreach ($rsTag as $value) { ?>
                                    <a href="#"><?php _e($value['strTag']); ?></a>
                                <?php } ?>
                        </div>
                    </div>
                    <div class="noteonly cf animated fadeInUpShort" data-id="4">
                        <div class="square"></div>
                        <h4><img src="<?php _e($theme_url); ?>images/qs.png" alt="" class="qs"/><span>Never</span> stop <br>
                            <span class="bi">until</span> <br>
                            you are <span>never</span> <span class="bi">before</span>
                            <img src="<?php _e($theme_url); ?>images/qe.png" alt="" class="qe"/>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- End 4 -->

            <!-- Start 5 -->
            <div class="row animatedParent" data-sequence="300">
                <div class="col-md-12 photos cf">
                    <a href="#" class="animated fadeInUpShort" data-id="1"><img src="<?php _e($theme_url); ?>images/photo-1.jpg" alt=""/></a>
                    <a href="#" class="mlr animated fadeInUpShort" data-id="2"><img src="<?php _e($theme_url); ?>images/photo-2.jpg" alt=""/></a>
                    <a href="#" class="animated fadeInUpShort" data-id="3"><img src="<?php _e($theme_url); ?>images/photo-3.jpg" alt=""/></a>
                </div>
            </div>
            <!-- End 5 -->
        </div>

        <!-- Start Services & Products -->
        <div class="col-md-4 animatedParent rightSideBar" data-sequence="0">
            <div class="theiaStickySidebar">
                <div class="services cf animated fadeInUpShort" data-id="1">
                    <h2>Services</h2>
                    <?php $i = 0;
                        foreach ($studio as $v) {

                            $i++; ?>
                            <a href="<?php _e(SITE_URL);?>studios/<?php _e($v['strSlug']);?>" class="ser<?php echo $i; ?>"><?php _e($v['strTitle']); ?><span><?php _e("0" . $i); ?></span></a><br>
                        <?php } ?>
                </div>
                <div class="product animated fadeInUpShort" data-id="2">
                    <h2>Products</h2>
                    <ul class="ProductSlider cycle-slideshow cf" data-cycle-fx="scrollHorz" data-cycle-slides="li" data-cycle-speed="1000" data-cycle-timeout="5000" data-cycle-pager="#pager"
                        data-cycle-loader="true">
                        <?php
                            $j = 0;
                            foreach ($products as $v) {
                                ++$j; ?>
                                <li><a href="#"><img src="<?php _e($theme_url); ?>images/product-1.jpg" alt=""></a></li>
                            <?php } ?>
                    </ul>
                    <div class="cycle-pager" id="pager"></div>
                </div>
            </div>
        </div>
        <!-- End Services & Products -->

    </div>
</div>
<!-- End Contant -->

<!-- Stare Footer -->
<?php include($theme_path . 'footer.php'); ?>
<!-- End Footer -->


