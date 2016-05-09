<?php
    /**
     * Core_Utilities
     *
     * Core_Utilities Utilities Class v1.0.0
     *
     * @package     WordPress
     * @subpackage  CustomTheme
     * @since       CustomTheme 1.0
     *
     * We've included a number of helper functions that we use in every theme we produce.
     *
     */

    class Core_Utilities {

        /**
         * Print a pre formatted array to the browser - very useful for debugging
         *
         * @param   array
         * @return  void
         * @author  Jasal Vadgama
         **/
        public static function print_a( $a ) {
            print( '<pre>' );
            print_r( $a );
            print( '</pre>' );
        }

        /**
         * Simple wrapper for native get_template_part()
         * Allows you to pass in an array of parts and output them in your theme
         * e.g. <?php get_template_parts( array( 'part-1', 'part-2' ) ); ?>
         *
         * @param   array
         * @return  void
         * @author  Jasal Vadgama
         **/
        public static function get_template_parts( $parts = array() ) {
            foreach ( $parts as $part ) {
                get_template_part( $part );
            };
        }

        /**
         * Pass in a path and get back the page ID
         * e.g. Core_Utilities::get_page_id_from_path( 'about/terms-and-conditions' );
         *
         * @param   string
         * @return  integer
         * @author  Jasal Vadgama
         **/
        public static function get_page_id_from_path( $path ) {
            $page = get_page_by_path( $path );
            if ( $page ) {
                return $page->ID;
            } else {
                return null;
            };
        }

        /**
         * Get the category id from a category name
         *
         * @param   string
         * @return  string
         * @author  Keir Whitaker
         */
        public static function get_category_id_from_name( $cat_name ){
            $term = get_term_by( 'name', $cat_name, 'category' );
            return $term->term_id;
        }

    }
?>
