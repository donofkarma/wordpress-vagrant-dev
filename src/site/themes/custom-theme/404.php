<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package 	WordPress
 * @subpackage  CustomTheme
 * @since       CustomTheme 1.0
 */
?>
<?php Core_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<h2>Page not found</h2>

<?php Core_Utilities::get_template_parts( array( 'parts/modules/footer','parts/shared/html-footer' ) ); ?>
