( function( $, elementor ) {

	'use strict';

	var widgetImageMagnifier = function( $scope, $ ) {

		var $imageMagnifier = $scope.find( '.avt-image-magnifier' ),
            settings        = $imageMagnifier.data('settings'),
            magnifier       = $imageMagnifier.find('> .avt-image-magnifier-image');

        if ( ! $imageMagnifier.length ) {
            return;
        }

        $(magnifier).ImageZoom(settings);

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-image-magnifier.default', widgetImageMagnifier );
	});

}( jQuery, window.elementorFrontend ) );