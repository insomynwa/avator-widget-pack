( function( $, elementor ) {

	'use strict';

	var widgetScrollNav = function( $scope, $ ) {

		var $scrollnav = $scope.find( '.avt-dotnav > li' );

        if ( ! $scrollnav.length ) {
            return;
        }

		var $tooltip = $scrollnav.find('> .avt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				appendTo: $scope[0]
			});				
		});

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-scrollnav.default', widgetScrollNav );
	});

}( jQuery, window.elementorFrontend ) );