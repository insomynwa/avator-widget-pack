( function( $, elementor ) {

	'use strict';

	var widgetSectionSticky = function( $scope, $ ) {

        var $section   = $scope;

        //sticky fixes for inner section.
        $.each($section, function( index ) {
            var $sticky      = $(this),
                $stickyFound = $sticky.find('.elementor-inner-section.avt-sticky');
                
            if ($stickyFound.length) {
                $($stickyFound).wrap('<div class="avt-sticky-wrapper"></div>');
            }
        });

	};


	jQuery(window).on('elementor/frontend/init', function() {
        elementor.hooks.addAction( 'frontend/element_ready/section', widgetSectionSticky );
	});

}( jQuery, window.elementorFrontend ) );