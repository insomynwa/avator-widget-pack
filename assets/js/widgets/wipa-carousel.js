( function( $, elementor ) {

	'use strict';

	var widgetCarousel = function( $scope, $ ) {

		var $carousel 		   = $scope.find( '.avt-carousel' );
				
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
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-carousel.default', widgetCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-carousel.avt-alice', widgetCarousel );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-carousel.avt-vertical', widgetCarousel );
	});

}( jQuery, window.elementorFrontend ) );