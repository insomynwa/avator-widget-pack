( function( $, elementor ) {

	'use strict';

	var widgetTCarousel = function( $scope, $ ) {

		var $tCarousel = $scope.find( '.avt-testimonial-carousel' );
            
        if ( ! $tCarousel.length ) {
            return;
        }

		var $tCarouselContainer = $tCarousel.find('.swiper-container'),
			$settings 		 = $tCarousel.data('settings');

		var swiper = new Swiper($tCarouselContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($tCarouselContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-testimonial-carousel.default', widgetTCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-testimonial-carousel.avt-twyla', widgetTCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-testimonial-carousel.avt-vyxo', widgetTCarousel );
	});

}( jQuery, window.elementorFrontend ) );