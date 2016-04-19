
<?php

/*
Template Name: Search Page
*/
get_header(); ?>


    <div id="page_wrap" class="clearfix">


        <!--**********************************************************************
        smoothslides
        **************************************************************************-->


        <section id="smoothslides" class="clearfix">

            <div class="smoothslides" id="myslideshow1">
                <!--<img src="images/1.jpg" alt="" />
                <img src="images/2.jpg" alt=""/>
                <img src="images/3.jpg" alt=""/>
                <img src="images/4.jpg" alt=""/>-->

               <!-- <img src="<?php /*echo get_stylesheet_directory_uri(); */?>/theme_assets/images/slide1.png"/>
                <img src="<?php /*echo get_stylesheet_directory_uri(); */?>/theme_assets/images/slide2.png"/>
                <img src="<?php /*echo get_stylesheet_directory_uri(); */?>/theme_assets/images/slide3.png"/>-->


                <?php echo get_field('slide_images_sp',get_the_ID(),false); ?>

            </div>

        </section>


        <div class="home_page_wrap clearfix">


            <!--**********************************************************************
           FB Like
            **************************************************************************-->


            <section class="fb_icon_sec clearfix">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <!--<a   href="https://business.facebook.com/finderzco-243859435961383/?business_id=976146022423922"><img src="theme_assets/images/fb_icon.png"/></a>-->

                        <!--    <div id="fb-root"></div>
                            <div class="fb-like" data-href="<?php /*the_permalink(); */?>" data-width="230" data-layout="button" data-action="like" data-show-faces="false" data-share="true"></div>
                        -->

                            <iframe class="fb-like" src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button&amp;show_faces=false&amp;
width=450&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:50px; height:20px;">
                            </iframe>

                        </div>



                        <!--col-md-12-->
                    </div>
                    <!--row-->
                </div>
                <!--container-->

            </section>


            <!--**********************************************************************
            actual page content - loop starts
            **************************************************************************-->
            <?php wp_reset_query(); ?>
<?php
            global $wp_query;


            query_posts( 'p='.$wp_query->post->ID.'&post_type=page' );
            while (have_posts()) : the_post();

?>

            <section class="home_content_wrap clearfix">
                <div class="home_logo_tagline clearfix">
                    <div class="clearfix home_logo text-center">
                        <a href="<?php echo get_option('home'); ?>" title="<?php echo get_bloginfo('name');?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/logo.png" alt=""/></a>
                        <h4><?php the_field('before_you_buy_sp',get_the_ID()); ?></h4>
                    </div>
                    <!--clearfix home_logo-->

                </div>
                <!--home_logo_tagline clearfix-->

                <div class="clearfix home_hero_text text-center">
                    <p class="display_desk"><?php echo get_field('the_best_price_desktop_sp',get_the_ID(),false); ?></p>
                    <p class="display_mobile"><?php echo get_field('the_best_price_mobile_sp',get_the_ID(),false); ?></p>
                </div>
                <!--clearfix home_hero_text-->

            </section>


            <section class="search_form_cl clearfix">
                <form action="/" class="search_form row" id='form-keywordSearch'>
                    <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
                    <!-- <span class="typed_span"></span> -->
                    <div class='input_btn_wrap row'>
                        <input type='search' class='search_sf col-xs-12 col-sm-12 col-md-8 col-lg-8' maxlength='120' name='keyword' placeholder='' />
                        <button class="submit_sf col-xs-12 col-sm-12 col-md-4 col-lg-4" style='margin-bottom: 2px; z-index: 200;' type="submit"><i class="fa fa-search"></i> Search</button>
                    </div>

                    <div class="search_trends_cl text-center clearfix row" style='margin-top: 25px;'>
                        <h4><?php echo get_field('trending_searches_sp',get_the_ID(),false); ?></h4>
                    </div>
                    </div>
                </form>
            </section>

<!--             <section class="search_form_cl clearfix">
                <form action="/" class="search_form" id='form-keywordSearch'>
                    <span class="typed_span"></span>
                    <div class='input_btn_wrap row'>
                        <input type='search' class='search_sf' style='margin-left: 2%; width: 90%;' maxlength='120' name='keyword' placeholder='' />
                        <button class="submit_sf" style='position: absolute; top: 0px; right: 0px;z-index: 200;' type="submit"><i class="fa fa-search"></i> Search</button>
                    </div>

                    <div class="search_trends_cl text-center clearfix row">
                        <h4><?php //echo get_field('trending_searches_sp',get_the_ID(),false); ?></h4>
                    </div>
                </form>
            </section>
 -->            <!--search_form_cl clearfix-->




        </div><!--home_page_wrap clearfix-->
        <div class="home_footer_wrap clearfix text-center">


            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <a target="_blank"  href="https://business.facebook.com/finderzco-243859435961383/?business_id=976146022423922"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/fb_footer_icon.png" alt=""/></a>
                    </div>
                    <!--col-md-12-->


                    <div class="footer_menu_col col-md-12">

                        <!--<ul class="footer_menu">

                            <li>
                                <a href="#">About</a>
                            </li>

                            <li>
                                <a href="#">Contact Us</a>
                            </li>

                            <li>
                                <a href="#">Terms</a>
                            </li>
                        </ul>-->


                        <?php

                        wp_nav_menu(array('menu' => 'footer_menu_col','theme_location'=>'footer_menu_col', 'container' => false,
                            'menu_class' =>'footer_menu clearfix'));

                        ?>

                        <p><?php the_field('footer_copyright_sp',get_the_ID()); ?></p>

                    </div>
                    <!--footer_menu col-md-12-->

                </div>
                <!--row-->
            </div>
            <!--container-->


        </div><!--footer_wrap clearfix-->




        <div class="type-wrap" style="display: none">
            <div id="typed-strings">

                <?php

                echo get_field('search_typed_text_sp',get_the_ID(),false);
                ?>

            </div>
            <span id="typed" style="white-space:pre;"></span>
        </div>




        <?php endwhile; ?>
        <?php wp_reset_query(); ?>

<style type='text/css'>
.suggestion_item {
    color: #778192;
    cursor: pointer;
    display: block;
    line-height: 30px;
}

.suggestion_item:hover {
    font-weight: bold;
}

</style>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/index.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    indexActions.init({
        form_search: $("#form-keywordSearch"),
        string_typeCode: $("#typed-strings").html(),
        ajax_getResult: "<?php echo admin_url('searchEngine/searchEngine.php'); ?>"
    });
});
</script>




<?php get_footer(); ?>