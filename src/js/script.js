/*jslint eqeqeq: true, undef: true */
/*global $, window, console, alert */

var CustomTheme = CustomTheme || {};

CustomTheme.Main = (function() {
    // PRIVATE VARIABLES

    // PRIVATE FUNCTIONS

    // PUBLIC METHODS
    return {
        init: function() {
            // DOM ready
        },
        pageInit: function() {
            // page load
        }
    };
}());

// ON DOM READY
$(function() {
    CustomTheme.Main.init();
});

// ON PAGE LOAD
$(window).load(function() {
    CustomTheme.Main.pageInit();
});
