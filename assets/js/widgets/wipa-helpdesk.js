( function( $, elementor ) {

	'use strict';

	var widgetHelpDesk = function( $scope, $ ) {

		var $helpdesk = $scope.find( '.avt-helpdesk' ),
            $helpdeskTooltip = $helpdesk.find('.avt-helpdesk-icons');

        if ( ! $helpdesk.length ) {
            return;
        }

		
		var $tooltip = $helpdeskTooltip.find('> .avt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				appendTo: $scope[0]
			});				
		});

		

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-helpdesk.default', widgetHelpDesk );
	});

}( jQuery, window.elementorFrontend ) );