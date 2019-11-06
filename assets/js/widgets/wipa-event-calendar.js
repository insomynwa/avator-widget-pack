( function( $, elementor ) {

	'use strict';

	var widgetEventCarousel = function( $scope, $ ) {

		var $eventCarousel = $scope.find( '.avt-event-calendar' );
            
        if ( ! $eventCarousel.length ) {
            return;
        }

		var $eventCarouselContainer = $eventCarousel.find('.swiper-container'),
			$settings 		 = $eventCarousel.data('settings');

		var swiper = new Swiper($eventCarouselContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($eventCarouselContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-event-carousel.default', widgetEventCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-event-carousel.fable', widgetEventCarousel );
	});

}( jQuery, window.elementorFrontend ) );