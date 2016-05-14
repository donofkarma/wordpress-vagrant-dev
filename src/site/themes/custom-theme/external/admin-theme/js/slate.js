jQuery(document).ready(function( $ ) {

    var $body = $( 'body' );

    $body.addClass( 'slate-admin-theme' );

    // Move elements inside #post-body-content
    // WordPress Version 4.5
    if ( $body.is( '.branch-4-5' ) ) {
        // Move Messages
        $( '.wrap > h1, #screen-meta-links, #screen-meta' ).prependTo( '#post-body-content' );
    }
    if ( $body.is( '.edit-tags-php.branch-4-5' ) ) {
        // Move elements on Tags/Category pages
        $( '.wrap > h1, .wrap > #ajax-response, .wrap > .search-form, .wrap > br, .wrap > .updated, .wrap > .error' ).prependTo( '#col-right .col-wrap' );
    }

    // Add background divs
    if ($('#poststuff #side-sortables').length != 0 && !$('body').is('.index-php')) {
        $('#side-sortables').before('<div id="side-sortablesback"></div>');
    }
    if ($('.edit-tags-php #col-left').length != 0) {
        $('.edit-tags-php #col-left').before('<div id="col-leftback"></div>');
    }
    if ($('.comment-php #submitdiv').length != 0) {
        $('.comment-php #submitdiv').before('<div id="submitdiv-back"></div>');
    }

    // Move Post State span
    if (($('span.post-state').length != 0) && ($('span.post-state').parent().is('td') == false)) {
        $('span.post-state').each(function() {
            $(this).insertBefore($(this).parent());
        });
    }

});
