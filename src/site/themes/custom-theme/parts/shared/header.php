<header class="header">
    <?php
        echo '<h1 class="site-title"><a href="/">', bloginfo( 'name' ), '</a></h1>';

        wp_nav_menu( array(
            'container' => 'nav',
            'container_class' => 'navigation--primary',
            'container_id' => 'navigation--primary',
            'menu_class' => 'navigation--primary-list',
            'menu_id' => 'navigation--primary-list',
            'theme_location' => 'primary'
        ) );

        bloginfo( 'description' );

        get_search_form();
    ?>
</header>
