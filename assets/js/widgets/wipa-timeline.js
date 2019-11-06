( function( $, elementor ) {

	'use strict';

	var widgetTimeline = function( $scope, $ ) {

		var $timeline = $scope.find( '.avt-timeline-skin-olivier' );
				
        if ( ! $timeline.length ) {
            return;
        }

        $($timeline).timeline({
            visibleItems : $timeline.data('visible_items'),
        });

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-timeline.avt-olivier', widgetTimeline );
	});

}( jQuery, window.elementorFrontend ) );