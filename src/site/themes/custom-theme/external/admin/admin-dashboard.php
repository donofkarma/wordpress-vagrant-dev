<?php
    /**
     * Admin dashboard customisations
     *
     * @package     WordPress
     * @subpackage  CustomTheme
     * @since       CustomTheme 1.0
     */

    // Remove unwanted widgets
    function remove_dashboard_widgets() {
        remove_action( 'welcome_panel', 'wp_welcome_panel' ); // Welcome panel
        // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );  // Activity
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Press
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPress blog
    }
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

    // Move the 'Right Now' dashboard widget to the right hand side
    function move_dashboard_widgets() {
        global $wp_meta_boxes;
        $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_activity'] = $widget;
    }
    add_action( 'wp_dashboard_setup', 'move_dashboard_widgets' );

?>
