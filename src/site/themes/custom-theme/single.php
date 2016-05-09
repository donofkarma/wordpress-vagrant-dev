<?php
/**
 * The Template for displaying all single posts
 *
 * @package     WordPress
 * @subpackage  CustomTheme
 * @since       CustomTheme 1.0
 */
?>
<?php Core_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<article>

    <h1><?php the_title(); ?></h1>
    <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
    <?php the_content(); ?>

    <?php if ( get_the_author_meta( 'description' ) ) : ?>
    <?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
    <h2>About <?php echo get_the_author() ; ?></h2>
    <?php the_author_meta( 'description' ); ?>
    <?php endif; ?>

    <?php comments_template( '', true ); ?>

</article>
<?php endwhile; ?>

<?php Core_Utilities::get_template_parts( array( 'parts/shared/footer', 'parts/shared/html-footer' ) ); ?>
