<?php
    /**
     * Starkers functions and definitions
     *
     * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
     *
     * @package     WordPress
     * @subpackage  Starkers
     * @since       Starkers 4.0
     */

    /* ========================================================================================================================
    
    Required external files
    
    ======================================================================================================================== */

    require_once( 'external/starkers-utilities.php' );

    /* ========================================================================================================================
    
    Theme specific settings

    Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme
    
    ======================================================================================================================== */

    add_theme_support( 'post-thumbnails' );
    
    register_nav_menus(
        array( 'primary' => 'Primary Navigation' )
    );

    /* ========================================================================================================================
    
    Actions and Filters
    
    ======================================================================================================================== */

    // remove the Wordpress version number
    remove_action( 'wp_head', 'wp_generator' );

    // add slug to the body class
    add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );

    // make links relative
    function rw_relative_urls() {
        // Don't do anything if:
        // - In feed
        // - In sitemap by WordPress SEO plugin
        if ( is_feed() || get_query_var( 'sitemap' ) )
            return;

        $filters = array(
            'attachment_link',
            'day_link',
            'get_comments_pagenum_link',
            'get_pagenum_link',
            'get_shortlink',
            'month_link',
            'page_link',
            'post_link',
            'post_type_archive_link',
            'post_type_link',
            'search_link',
            'term_link',
            'year_link'
        );

        foreach ( $filters as $filter ) {
            add_filter( $filter, 'wp_make_link_relative' );
        }
    }
    add_action( 'template_redirect', 'rw_relative_urls' );

    /* ========================================================================================================================
    
    Custom Post Types - include custom post types and taxonimies here e.g.

    e.g. require_once( 'custom-post-types/your-custom-post-type.php' );
    
    ======================================================================================================================== */


    /* ========================================================================================================================
    
    Comments
    
    ======================================================================================================================== */

    /**
     * Custom callback for outputting comments 
     *
     * @return void
     * @author Keir Whitaker
     */
    function starkers_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment; 
        ?>
        <?php if ( $comment->comment_approved == '1' ): ?>  
        <li>
            <article id="comment-<?php comment_ID() ?>">
                <?php echo get_avatar( $comment ); ?>
                <h4><?php comment_author_link() ?></h4>
                <time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
                <?php comment_text() ?>
            </article>
        <?php endif;
    }
?>
