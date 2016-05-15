<!DOCTYPE html>
<!--[if lte IE 9]> <html class="lt-ie10 no-js"> <![endif]-->
<!--[if !IE]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <?php
            $title = '';

            if ( !is_front_page() ) {
                $title .= wp_title( '|', false, 'right' );
            }
            $title .= get_bloginfo( 'name' );
            if ( is_front_page() ) {
                $title .= ' - ' . html_entity_decode( get_bloginfo( 'description' ) );
            }
        ?>
        <title><?php echo $title; ?></title>

        <script>
            // set js enabled class - replaces 'no-js' with 'js'
            document.documentElement.className = document.documentElement.className.replace(/(\s|^)no-js(\s|$)/, '$1' + 'js' + '$2');
        </script>

        <!-- browser settings -->
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
            <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php endif; ?>

        <!-- icons -->

        <!-- stylesheets -->
        <link href="<?php echo wp_make_link_relative( get_template_directory_uri() ); ?>/style.css" media="screen" rel="stylesheet" />

        <!-- Facebook Config -->
        <!-- OpenGraph -->
        <meta property="og:url" content="<?php echo site_url() . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?php echo get_the_title(); ?>" />
        <meta property="og:description" content="<?php bloginfo( 'description' ); ?>" />
        <meta property="og:image" content="Enter image here" />
        <meta property="og:site_name" content="<?php bloginfo( 'name' ) ?>" />

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
