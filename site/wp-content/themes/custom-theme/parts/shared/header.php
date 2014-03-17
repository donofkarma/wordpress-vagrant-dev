<header id="header">
    <h1><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>

    <?php
        bloginfo( 'description' );
        get_search_form();
    ?>
</header>
