( function( $, elementor ) {

	'use strict';

	var widgetMarker = function( $scope, $ ) {

		var $marker = $scope.find( '.avt-marker-wrapper' );

        if ( ! $marker.length ) {
            return;
        }

		var $tooltip = $marker.find('> .avt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				appendTo: $scope[0]
			});				
		});

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-marker.default', widgetMarker );
	});

}( jQuery, window.elementorFrontend ) );