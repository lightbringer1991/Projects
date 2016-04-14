<!doctype html>

<html <?php language_attributes(); ?> class="<?php echo $home_landing; ?> <?php echo $no_fludibox; ?>">

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">



    <!--<title><?php /*is_home() ? bloginfo('description') : wp_title( '' ); */?> <?php /*if(!is_home()){ echo '|';} */?> <?php /*bloginfo('name'); */?></title>-->
    <title><?php is_home() ? wp_title( '' ) : wp_title( '' ); ?> <?php if(!is_home()&& !is_front_page()){ echo '|';} ?> <?php bloginfo('name'); ?></title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">


    <?php wp_head();?>
    <!--**********************************************************************
  smooth slider
  **************************************************************************-->

    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/smoothslides.theme.css">
    <!--     <link rel="stylesheet" href="theme_assets/css/stylesheet.css">
    -->    <!--**********************************************************************
   end smooth slider
    **************************************************************************-->


    <!--stylesheets-->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/normalize.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/fonts/fa/css/font-awesome.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/fonts/fonts.css"/>

    <!--jquery theme for date picker-->
    <!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    -->
<!--    <link rel="stylesheet" href="<?php /*echo get_stylesheet_directory_uri(); */?>/theme_assets/css/jquery.bxslider.css" type="text/css" />
-->
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/responsive_menu.css"/>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/mobile.css"/>

    <!--Respond Js to control HTML5 Elements in IE earlier versions and other compatibility-->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/js/respond.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/css/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/theme_assets/js/typeahead.bundle.min.js"></script>


</head>

<body <?php body_class();?> >


<!--**********************************************************************
FACEBOOK SDK
**************************************************************************-->

<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>








