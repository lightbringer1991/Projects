
<?php

/*
Template Name: Result Page
*/
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

                    <input type="search" class="search_sf" maxlength="120" placeholder="<?php echo get_field('search_for_a_product_rp',get_the_ID(),false); ?>"/>
                    <button  class="submit_sf" type="submit"><i class="fa fa-search"></i> <span>Search</span></button>





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
                <div class="mv_single clearfix">
                    <div class="mv_single_inner clearfix">
                        <img class="thumb_preview" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/mv1.jpg" alt=""/>


                        <div class="mv_single_meta clearfix">
                            <h3>iPhone 6 Review from an Android User</h3>
                            <h4>45,000 views <span>09:20</span></h4>

                            <img class="play_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/play_icon.png" alt=""/>
                        </div>
                        <!--mv_single_meta clearfix-->
                    </div>
                    <!--mv_single_inner-->
                </div>
                <!--mv_single clearfix-->



                <div class="mv_single clearfix">
                    <div class="mv_single_inner clearfix">
                        <img class="thumb_preview" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/mv2.jpg" alt=""/>

                        <div class="mv_single_meta clearfix">
                            <h3>iPhone 6 Review from an Android User</h3>
                            <h4>107,200 views <span>08:32</span></h4>

                            <img class="play_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/play_icon.png" alt=""/>
                        </div>
                        <!--mv_single_meta clearfix-->
                    </div>
                    <!--mv_single_inner-->
                </div>
                <!--mv_single clearfix-->




                <div class="mv_single clearfix">
                    <div class="mv_single_inner clearfix">
                        <img class="thumb_preview" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/mv2.jpg" alt=""/>

                        <div class="mv_single_meta clearfix">
                            <h3>iPhone 6 Review from an Android User</h3>
                            <h4>107,200 views <span>08:32</span></h4>

                            <img class="play_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/play_icon.png" alt=""/>
                        </div>
                        <!--mv_single_meta clearfix-->
                    </div>
                    <!--mv_single_inner-->
                </div>
                <!--mv_single clearfix-->





                <div class="mv_single clearfix">
                    <div class="mv_single_inner clearfix">
                        <img class="thumb_preview" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/mv2.jpg" alt=""/>

                        <div class="mv_single_meta clearfix">
                            <h3>iPhone 6 Review from an Android User</h3>
                            <h4>107,200 views <span>08:32</span></h4>

                            <img class="play_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/play_icon.png" alt=""/>
                        </div>
                        <!--mv_single_meta clearfix-->
                    </div>
                    <!--mv_single_inner-->
                </div>
                <!--mv_single clearfix-->




                <div class="mv_single clearfix">
                    <div class="mv_single_inner clearfix">
                        <img class="thumb_preview" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/mv2.jpg" alt=""/>

                        <div class="mv_single_meta clearfix">
                            <h3>iPhone 6 Review from an Android User</h3>
                            <h4>107,200 views <span>08:32</span></h4>

                            <img class="play_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/play_icon.png" alt=""/>
                        </div>
                        <!--mv_single_meta clearfix-->
                    </div>
                    <!--mv_single_inner-->
                </div>
                <!--mv_single clearfix-->


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



<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/ebay_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">
                            <h3>Too low<br/> to display</h3>

                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>


                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$18.00</h4>
                            </div>
                            <!--clearfix p_name_top-->

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h3>Too low<br/> to display</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$18.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->







<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/amazon_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">

                            <h4>$80.00</h4>
                            <h3>$72.00</h3>
                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>




                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$15.00</h4>
                            </div>
                            <!--clearfix p_name_top-->


                            <div class="seller_fb pull-left">

                                <h4><?php echo $seller_information_text; ?></h4>
                                <h5><span>99.9%</span> Positive feedback</h5>

                            </div>
                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h4>$80.00</h4>
                    <h3>$72.00</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$15.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <div class="seller_fb pull-left">

                            <h4><?php echo $seller_information_text; ?></h4>
                            <h5><span>99.9%</span> Positive feedback</h5>

                        </div>
                        <!--seller_fb pull-left-->

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->






<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/amazon_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">
                            <h3>Too low<br/> to display</h3>

                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>


                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$18.00</h4>
                            </div>
                            <!--clearfix p_name_top-->

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h3>Too low<br/> to display</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$15.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <div class="seller_fb pull-left">

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--seller_fb pull-left-->

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->

<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/amazon_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">
                            <h3>Too low<br/> to display</h3>

                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>


                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$18.00</h4>
                            </div>
                            <!--clearfix p_name_top-->

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h3>Too low<br/> to display</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$18.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->







<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/amazon_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">

                            <h4>$80.00</h4>
                            <h3>$72.00</h3>
                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>




                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$15.00</h4>
                            </div>
                            <!--clearfix p_name_top-->


                            <div class="seller_fb pull-left">

                                <h4><?php echo $seller_information_text; ?></h4>
                                <h5><span>99.9%</span> Positive feedback</h5>

                            </div>
                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h4>$80.00</h4>
                    <h3>$72.00</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$15.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <div class="seller_fb pull-left">

                            <h4><?php echo $seller_information_text; ?></h4>
                            <h5><span>99.9%</span> Positive feedback</h5>

                        </div>
                        <!--seller_fb pull-left-->

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->






<div class="clearfix single_pl">
    <div class="container  ">
        <div class="row">
            <div class="col-md-12">


                <div class="clearfix p_name_top p_name_bottom">
                    <div class="image_pn_bottom pull-left clearfix">
                        <div class="inner_image_pn_bottom clearfix">
                            <img class="img_pn_bottom" src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/item1.png" alt=""/>

                            <a href="#" class="product_url" title="Product Tile"></a>
                            <span class="red_star" style="background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/red_star.png)"><strong>30%</strong><br/>OFF</span>

                            <div class="pink_ribon_cl clearfix">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/pink_ribbon.png" alt=""/>
                                <span>100 Sold</span>
                            </div>
                            <!--red_ribbon clearfix-->
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/amazon_btn.png" class="amazon_btn" alt=""/>

                        </div>
                        <!--inner_image_pn_bottom clearfix-->


                        <div class="display_mobile p_price_bottom p_price_top text_bottom pull-left clearfix">
                            <h3>Too low<br/> to display</h3>

                        </div>
                        <!--text_pn_bottom pull-left clearfix-->

                    </div>
                    <!--image_pn_bottom pull-left clearfix-->


                    <div class="text_pn_bottom text_pn_top text_bottom pull-left clearfix">
                        <h2>Apple iPhone 6 - Unlocked (Gold) ,16GB.</h2>
                        <a href="#"><span><?php echo $more_details_text; ?></span> >></a>


                        <div class="clearfix display_mobile mobile_extra_meta">
                            <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""></a>



                            <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                                <h4><span class="show_mobile">Shipping </span>$18.00</h4>
                            </div>
                            <!--clearfix p_name_top-->

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--clearfix display_mobile-->

                    </div>
                    <!--text_pn_bottom pull-left clearfix-->


                </div>
                <!--clearfix p_name_top-->




                <div class="p_price_bottom p_price_top text_bottom pull-left clearfix">
                    <h3>Too low<br/> to display</h3>

                </div>
                <!--text_pn_bottom pull-left clearfix-->



                <div class="clearfix p_shipping_top p_shipping_bottom text_bottom pull-left">
                    <h4>$15.00</h4>
                </div>
                <!--clearfix p_name_top-->



                <div class="clearfix p_rating_top p_rating_bottom pull-left text_bottom padding_0right">
                    <div class="rating_div clearfix">
                        <!--<a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>-->

                        <div class="seller_fb pull-left">

                            <a href="#" class="urating_link"><?php echo $user_reviews_text; ?></a>


                        </div>
                        <!--seller_fb pull-left-->

                        <a href="#" class="v_store"><img src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/images/v_store.png" alt=""/></a>
                    </div>
                    <!--rating_div clearfix-->
                </div>
                <!--clearfix p_name_top-->

            </div>
            <!--clearfix single_pl-->




        </div>
        <!--row-->
    </div>
    <!--container-->
</div>
<!--clearfix single_pl-->



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




<?php get_footer(); ?>