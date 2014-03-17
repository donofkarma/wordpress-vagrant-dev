<!DOCTYPE html>
<!--[if lt IE 8]><html class="ie lt-ie8 lt-ie9 lt-ie10 lt-ie11"> <![endif]-->
<!--[if IE 8]>   <html class="ie ie8 lt-ie9 lt-ie10 lt-ie11"> <![endif]-->
<!--[if IE 9]>   <html class="ie ie9 lt-ie10 lt-ie11"> <![endif]-->
<!--[if IE 10]>  <html class="ie ie10 lt-ie11"> <![endif]-->
<!--[if IE 11]>  <html class="ie ie11"> <![endif]-->
<!--[if !IE]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); ?></title>

        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico"/>

        <!--[if gte IE 9]><!-->
            <link href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" rel="stylesheet" />
        <!--<![endif]-->
        <!--[if lt IE 9]>
            <link href="<?php bloginfo( 'stylesheet_directory' ); ?>/ie.css" media="screen" rel="stylesheet" />

            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
