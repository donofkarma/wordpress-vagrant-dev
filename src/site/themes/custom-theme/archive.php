<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package     WordPress
 * @subpackage  CustomTheme
 * @since       CustomTheme 1.0
 */
?>
<?php Core_Utilities::get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) { ?>
    <section>

    <?php
    if ( is_day() ) {
        echo '<h1>Archive:', get_the_date( 'D M Y' ), '</h1>';
    } else if ( is_month() ) {
        echo '<h1>Archive:', get_the_date( 'M Y' ), '</h1>';
    } else if ( is_year() ) {
        echo '<h1>Archive:', get_the_date( 'Y' ), '</h1>';
    } else if ( is_author() ) {
        echo '<h1>Author Archives: ', get_the_author(), '</h1>';

        if ( get_the_author_meta( 'description' ) ) {
            echo get_avatar( get_the_author_meta( 'user_email' ) );
            echo '<h3>About ', get_the_author(), '</h3>';
            the_author_meta( 'description' );
        }
    } else if ( is_category() ) {
        echo '<h1>Category Archive: ', single_cat_title( '', false ), '</h1>';
    } else if ( is_tag() ) {
        echo '<h1>Tag Archive: ', single_tag_title( '', false ), '</h1>';
    }

    while ( have_posts() ) : the_post();
        ?>
        <article>
            <h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
            <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time> <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?>
            <?php the_content(); ?>
        </article>
        <?php
    endwhile;
} else { ?>
    <article>
        <h2>No posts to display</h2>
    </article>
<?php } ?>

<?php Core_Utilities::get_template_parts( array( 'parts/shared/footer', 'parts/shared/html-footer' ) ); ?>
