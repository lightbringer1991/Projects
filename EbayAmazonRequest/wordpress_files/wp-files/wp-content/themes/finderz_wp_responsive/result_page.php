
<?php

/*
Template Name: Result Page
*/

$query = '';
if (isset($_GET['query'])) {
    $query = urldecode($_GET['query']);
}

get_header();

//setting variables
$user_reviews_text = get_field('user_review_rp',get_the_ID());
$more_details_text  = get_field('more_details_rp',get_the_ID());
$seller_information_text  = get_field('seller_information_rp',get_the_ID());

?>


<div id="page_wrap" class="clearfix">

<div class="result_page_wrap clearfix">





<section class="fb_icon_sec clearfix">

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-right">


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


<section class="result_logo clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo get_option('home'); ?>" title="<?php echo get_bloginfo('name');?>" class="logo_result"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/logo_result.png" alt=""/></a>
                <h3 class="display_mobile mobile_lg_headline"><?php echo get_field('before_you_buy_rp',get_the_ID(),false); ?></h3>
                <h4><?php echo get_field('the_best_price_rp',get_the_ID(),false); ?></h4>
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>
    <!--container-->
</section>

<section class="search_form_cl clearfix">

    <div class="container">
        <div class="row">
            <div class="col-md-12 search_form_col">
                <form action="/" class="search_form">

                    <input type="search" name="keyword" class="search_sf" maxlength="120" placeholder="<?php echo get_field('search_for_a_product_rp',get_the_ID(),false); ?>" value='<?php echo $query; ?>' />
                    <!-- <button  class="submit_sf" type="submit"><i class="fa fa-search"></i> <span>Search</span></button> -->
                    <button  class="submit_sf" type="submit" style='position: absolute; top: 0px; right: 0px;z-index: 200;'><i class="fa fa-search"></i> <span>Search</span></button>





                </form>



                <div class="search_trends_cl text-left clearfix">
                    <h4><?php echo get_field('trending_searches_rp',get_the_ID(),false); ?></h4>
                </div>
                <!--search_trends_cl text-center clearfix-->

                <h3 class="result_compares display_mobile clearfix"><?php echo get_field('compares_ebay_mobile_rp',get_the_ID(),false); ?></h3>


            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>
    <!--container-->

</section>
<!--search_form_cl clearfix-->



<section class="most_viewed clearfix">

    <div class="container">
        <div class="row">
            <div class="col-md-12 mv_top">
                <h3><?php echo get_field('most_viewed_product_rp',get_the_ID(),false); ?></h3>
            </div>
            <!--col-md-12 mv_top-->
        </div>
        <!--row-->
    </div>
    <!--container-->


    <div class="container mv_con">
        <div class="row">
            <div class="mv_listing col-md-12">

            </div>
            <!--mv_listing col-md-12-->
        </div>
        <!--row-->
    </div>
    <!--container mv_con-->

</section>



<section class="results_text clearfix">


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php echo get_field('iphone_6_results_rp',get_the_ID(),false); ?>
            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>
    <!--container-->

</section>



<section class="products_list clearfix">
<div class="pl_top clearfix">

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="clearfix p_name_top">
                    <h3><?php echo get_field('product_details_title_rp',get_the_ID(),false); ?></h3>
                </div>
                <!--clearfix p_name_top-->


                <div class="clearfix p_price_top pull-left">
                    <h3><?php echo get_field('price_title_rp',get_the_ID(),false); ?></h3>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_shipping_top pull-left">
                    <h3><?php echo get_field('shipping_title_rp',get_the_ID(),false); ?></h3>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top pull-left">
                    <h3><?php echo get_field('product_seller_rating_title_rp',get_the_ID(),false); ?></h3>
                </div>
                <!--clearfix p_name_top-->



            </div>
            <!--col-md-12-->
        </div>
        <!--row-->
    </div>
    <!--container-->


</div>
<!--pl_top clearfix-->


<div class="pl_bottom clearfix">
</div>
<!--pl_bottom clearfix-->


</section>




<section class="sponsors clearfix">
    <div class="container">
        <div class="row">

            <div class="col-md-12 display_mobile looking_for">
                <h3>Didn’t find what you are looking for? <br/>
                    Try broader or more specific search.
                </h3>
            </div>
            <!--col-md-12 display_mobile-->


            <div class="col-md-12 text-right padding_no">
                <a href="#" class="sponsored_link">     <?php echo get_field('sponsored_links_text_rp',get_the_ID(),false); ?></a>
            </div>
            <!--col-md-12-->

            <div class="sponsored_code clearfix">
                <!--<img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/sponsored_img.png" class="sponsored_img" alt=""/>-->

                <?php echo get_field('sponsored_links_rp',get_the_ID(),false); ?>

            </div>
            <!--sponsored_code clearfix-->
        </div>
        <!--row-->
    </div>
    <!--container-->
</section>




</div><!--home_page_wrap clearfix-->



<section class="result_footer clearfix">
    <div class="result_footer_top clearfix">
        <h2><a href="#">finderz</a></h2>


        <p>                <?php echo get_field('the_best_price_footer_rp',get_the_ID(),false); ?>
        </p>
        <a target="_blank" href="https://business.facebook.com/finderzco-243859435961383/?business_id=976146022423922"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/fb_footer_icon.png" alt=""/></a>

    </div>
    <!--result_footer_top clearfix-->


    <div class="result_footer_bottom clearfix">

        <div class="footer_menu_col col-md-12">

            <?php

            wp_nav_menu(array('menu' => 'footer_menu_col','theme_location'=>'footer_menu_col', 'container' => false,
                'menu_class' =>'footer_menu clearfix'));

            ?>

            <p><?php echo get_field('footer_copyright_rp',get_the_ID(),false); ?></p>

        </div>
        <!--footer_menu col-md-12-->
    </div>
    <!--result_footer_bottom clearfix-->
</section>

<style type='text/css'>
.loading {
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
}

.red_star {
    background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)
}

.urating_link {
    cursor: pointer;
}

.modal-nopadding {
    padding: 0;
    padding-left: 70px;
    padding-right: 70px;
}


.modal-xlg {
    width: 70%;
}

/* CSS code for typeahead, will need to be moved to a separate CSS later */
.twitter-typeahead {
    display: inline !important;
    position: absolute !important;
    width: 100%;
    /*right: 2%;*/
    z-index: 200;
}

.tt-query, /* UPDATE: newer versions use tt-input instead of tt-query */
.tt-hint {
    width: 396px;
    height: 30px;
    padding: 8px 12px;
    font-size: 24px;
    line-height: 30px;
    border: 2px solid #ccc;
    border-radius: 8px;
    outline: none;
}

.tt-query { /* UPDATE: newer versions use tt-input instead of tt-query */
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
    color: #999;
    display: none;
}

.tt-menu { /* UPDATE: newer versions use tt-menu instead of tt-dropdown-menu */
    width: inherit;
    position: relative !important;
    margin-top: 37px;
    padding: 8px 0;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
    z-index: -1 !important;
}

.tt-suggestion {
    padding: 3px 20px;
    font-size: 18px;
    line-height: 24px;
}

.tt-suggestion.tt-is-under-cursor { /* UPDATE: newer versions use .tt-suggestion.tt-cursor */
    color: #fff;
    background-color: #0097cf;

}

.tt-suggestion p {
    margin: 0;
}
</style>

<div class='loading'>
    <img src="<?php echo admin_url('searchEngine/images/loading_spinner.gif'); ?>" width='50px' height='50px' /><br />
    Searching ...
</div>

<div class='modal fade' id='modal-youtubeVideo' role='dialog' style='vertical-align: middle;'>
    <div class="modal-dialog modal-xlg">
        <div class="modal-content" style='background-color: black;'>
            <div class='row'>
            <div class="modal-body modal-nopadding" style='border-style: none;'>
                <div class='col-sm-12 col-md-12 col-lg-12 embed-responsive embed-responsive-16by9'>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id='modal-amazonReviews'>
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">What People Say</h4>
    </div>
    <div class="modal-body">
        <iframe class='col-sm-12 col-md-12 col-lg-12' height='600px'></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?php echo get_stylesheet_directory_uri(); ?>/result_page.js"></script>
<script type='text/javascript'>
$(document).ready(function() {
    searchActions.init({
        form_search: $(".search_form"),
        container_youtube_reviews: $(".mv_con"),
        container_youtube_videos: $(".mv_listing"),
        container_result: $(".products_list"),
        container_loading: $(".loading"),
        modal_amazonReviews: $("#modal-amazonReviews"),
        modal_youtubeVideo: $("#modal-youtubeVideo"),

        image_folder: "<?php echo get_stylesheet_directory_uri() . '/theme_assets/images/'; ?>",

        ajax_getResult: "<?php echo admin_url('searchEngine/searchEngine.php'); ?>"
    });
    <?php
    if ($query != '') {
    ?>
        $(".search_form").trigger('submit');
    <?php
    }
    ?>
});

</script>

<?php get_footer(); ?>