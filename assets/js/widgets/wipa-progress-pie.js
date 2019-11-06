( function( $, elementor ) {

	'use strict';

	var widgetProgressPie = function( $scope, $ ) {

		var $progressPie = $scope.find( '.avt-progress-pie' );

        if ( ! $progressPie.length ) {
            return;
        }

        elementorFrontend.waypoint( $progressPie, function() {
            var $this = $( this );
            
                $this.asPieProgress({
                    namespace: 'pieProgress',
                    classes: {
                        svg     : 'avt-progress-pie-svg',
                        number  : 'avt-progress-pie-number',
                        content : 'avt-progress-pie-content'
                    }
                });
                
                $this.asPieProgress('start');

        }, {
            offset: 'bottom-in-view'
        } );

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-progress-pie.default', widgetProgressPie );
	});

}( jQuery, window.elementorFrontend ) );