<!DOCTYPE html>
<!--[if lte IE 9]> <html class="lt-ie10 no-js"> <![endif]-->
<!--[if !IE]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>

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

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
