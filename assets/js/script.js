/*jslint eqeqeq: true, undef: true */
/*global $, window, console, alert */

var LocalCharity = LocalCharity || {};

LocalCharity = (function() {
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
	LocalCharity.init();
});

// ON PAGE LOAD
$(window).load(function() {
	LocalCharity.pageInit();
});
