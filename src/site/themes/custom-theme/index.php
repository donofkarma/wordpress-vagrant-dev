<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * @package     WordPress
 * @subpackage  CustomTheme
 * @since       CustomTheme 4.0
 */
?>
<?php

if ( !class_exists( 'Timber' ) ) {
    echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
    return;
}


$templates = array( 'index.twig' );
$context = Timber::get_context();

if ( is_singular() ) {
    $context['post'] = new TimberPost();
} else {
    $context['posts'] = Timber::get_posts();
}

if ( is_home() || is_front_page() ) {
    array_unshift( $templates, 'home.twig' );
} else if ( is_single() ) {
    array_unshift( $templates, 'single-' . $post->post_name . '.twig', 'single.twig' );
} else if ( is_page() ) {
    array_unshift( $templates, 'page-' . $post->post_name . '.twig', 'page.twig' );
} else if ( is_archive() ) {
    // archives

    // add the default archive template
    array_unshift( $templates, 'archive.twig' );

    if ( is_day() ) {
        $context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
    } else if ( is_month() ) {
        $context['title'] = 'Archive: ' . get_the_date( 'M Y' );
    } else if ( is_year() ) {
        $context['title'] = 'Archive: ' . get_the_date( 'Y' );
    } else if ( is_category() ) {
        array_unshift( $templates, 'category-' . get_query_var( 'cat' ) . '.twig', 'category.twig' );

        $context['title'] = 'Category Archive: "' . Core_Utilities::get_term_name_from_id( get_query_var( 'cat' ), 'category' ) . '"';
    } else if ( is_tag() ) {
        array_unshift( $templates, 'tag.twig' );

        $context['title'] = 'Tag Archive: "' . Core_Utilities::get_term_name_from_id( get_query_var( 'tag_id' ), 'post_tag' ) . '"';
    } else if ( is_author() ) {
        array_unshift( $templates, 'author.twig' );

        $context['title'] = 'Author Archives: ' . get_the_author();
    } else if ( is_post_type_archive() ) {
        // custom post types archive
        array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );

        $context['title'] = post_type_archive_title( '', false );
    }
} else if ( is_search() ) {
    array_unshift( $templates, 'search.twig' );

    $context['title'] = 'Search Results for: "' . get_search_query() .'"';
} else if ( is_404() ) {
    array_unshift( $templates, '404.twig' );
}

// var_dump( $templates );

Timber::render( $templates, $context );

?>
