( function( $, elementor ) {

	'use strict';

	var widgetIconNav = function( $scope, $ ) {

		var $iconnav        = $scope.find( 'div.avt-icon-nav' ),
            $iconnavTooltip = $iconnav.find( '.avt-icon-nav' );

        if ( ! $iconnav.length ) {
            return;
        }

		var $tooltip = $iconnavTooltip.find('> .avt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				appendTo: $scope[0]
			});				
		});

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-iconnav.default', widgetIconNav );
	});

}( jQuery, window.elementorFrontend ) );