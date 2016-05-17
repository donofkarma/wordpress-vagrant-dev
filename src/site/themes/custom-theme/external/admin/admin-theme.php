<?php
    /**
     * Admin area theme
     *
     * Admin Theme is a tweaked version of the Slate Admin Theme by Ryan Sommers (http://sevenbold.com/wordpress/)
     *
     * @package     WordPress
     * @subpackage  CustomTheme
     * @since       CustomTheme 1.0
     */

    function slate_files() {
      wp_enqueue_style( 'slate-admin-theme', get_template_directory_uri() . '/external/admin/css/slate.css', array(), '1.1.6' );
      wp_enqueue_script( 'slate', get_template_directory_uri() . '/external/admin/js/slate.js', array( 'jquery' ), '1.1.6' );
    }
    add_action( 'admin_enqueue_scripts', 'slate_files' );
    add_action( 'login_enqueue_scripts', 'slate_files' );

    function slate_add_editor_styles() {
        add_editor_style( 'css/editor-style.css' );
    }
    add_action( 'after_setup_theme', 'slate_add_editor_styles' );

    add_action( 'admin_head', 'slate_colors' );
    add_action( 'login_head', 'slate_colors' );
    function slate_colors() {
        include( 'css/dynamic.php' );
    }
    function slate_get_user_admin_color(){
        $user_id = get_current_user_id();
        $user_info = get_userdata($user_id);
        if ( !( $user_info instanceof WP_User ) ) {
            return;
        }
        $user_admin_color = $user_info->admin_color;
        return $user_admin_color;
    }

    // Remove the hyphen before the post state
    add_filter( 'display_post_states', 'slate_post_state' );
    function slate_post_state( $post_states ) {
        if ( !empty($post_states) ) {
            $state_count = count($post_states);
            $i = 0;
            foreach ( $post_states as $state ) {
                ++$i;
                ( $i == $state_count ) ? $sep = '' : $sep = '';
                echo "<span class='post-state'>$state$sep</span>";
            }
        }
    }
?>
