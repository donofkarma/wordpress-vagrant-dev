<header class="header">
    <?php
        echo '<h1 class="site-title"><a href="/">', bloginfo( 'name' ), '</a></h1>';
        bloginfo( 'description' );
        get_search_form();
    ?>
</header>
