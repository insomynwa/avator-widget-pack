( function( $, elementor ) {

	'use strict';

	// Accordion
	var widgetAccordion = function( $scope, $ ) {

		var $accordion = $scope.find( '.avt-accordion' );
				
        if ( ! $accordion.length ) {
            return;
        }

        var acdID = $(location.hash);

        if (acdID.length > 0 && acdID.hasClass('avt-accordion-title')) {
            $('html').animate({
                easing:  'slow',
                scrollTop: acdID.offset().top,
            }, 500, function() {
                avtUIkit.accordion($accordion).toggle($(acdID).data('accordion-index'), true);
            });  
        }

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-accordion.default', widgetAccordion );
	});

}( jQuery, window.elementorFrontend ) );