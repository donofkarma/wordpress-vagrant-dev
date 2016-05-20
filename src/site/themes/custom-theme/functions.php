<?php
    /**
     * CustomTheme functions and definitions
     *
     * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
     *
     * @package     WordPress
     * @subpackage  CustomTheme
     * @since       CustomTheme 1.0
     */

    /* ========================================================================================================================

    Set up Timber

    ======================================================================================================================== */

    // Make sure Timber exists
    if ( !class_exists( 'Timber' ) ) {
        add_action( 'admin_notices', function() {
                echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
            } );
        return;
    }

    // Set directories for Twig
    Timber::$dirname = array( 'views' );

    class TwigTemplates extends TimberSite {

        function __construct() {
            add_filter( 'timber_context', array( $this, 'add_to_context' ) );

            parent::__construct();
        }

        // Add data for the templates
        function add_to_context( $context ) {
            // Site metadata
            $context['site'] = $this;

            // page type - for header meta data
            $context['is_home'] = is_home();
            $context['is_front_page'] = is_front_page();
            $context['is_single'] = is_single();

            // Menus
            $context['primaryMenu'] = new TimberMenu( 'primary' );

            return $context;
        }

    }
    new TwigTemplates();

    /* ========================================================================================================================

    Required external files

    ======================================================================================================================== */

    require_once( 'external/core-utilities.php' );

    /* ========================================================================================================================

    Theme specific settings

    Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme

    ======================================================================================================================== */

    add_theme_support( 'html5' );
    add_theme_support( 'menus' );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array( 'primary' => 'Primary Navigation' )
    );

    /* ========================================================================================================================

    Actions and Filters

    ======================================================================================================================== */

    // remove unwanted items from <head>
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // removes emojis js
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );  // removes emojis css

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

    // Admin customisations
    require_once( 'external/admin/admin-dashboard.php' );
    require_once( 'external/admin/admin-theme.php' );

    /* ========================================================================================================================

    Custom Post Types - include custom post types and taxonimies here e.g.

    e.g. require_once( 'custom-post-types/your-custom-post-type.php' );

    ======================================================================================================================== */

?>
