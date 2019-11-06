( function( $, elementor ) {

	'use strict';

	var widgetCustomCarousel = function( $scope, $ ) {

		var $carousel = $scope.find( '.avt-custom-carousel' );
				
        if ( ! $carousel.length ) {
            return;
        }

        var $carouselContainer = $carousel.find('.swiper-container'),
			$settings 		 = $carousel.data('settings');

		var swiper = new Swiper($carouselContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($carouselContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-custom-carousel.default', widgetCustomCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-custom-carousel.avt-custom-content', widgetCustomCarousel );
	});

}( jQuery, window.elementorFrontend ) );