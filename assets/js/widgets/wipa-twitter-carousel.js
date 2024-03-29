( function( $, elementor ) {

	'use strict';

	var widgetTwitterCarousel = function( $scope, $ ) {

		var $twitterCarousel = $scope.find( '.avt-twitter-carousel' );
				
        if ( ! $twitterCarousel.length ) {
            return;
        }

        //console.log($twitterCarousel);

		var $twitterCarouselContainer = $twitterCarousel.find('.swiper-container'),
			$settings 		 = $twitterCarousel.data('settings');

		var swiper = new Swiper($twitterCarouselContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($twitterCarouselContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-twitter-carousel.default', widgetTwitterCarousel );
	});

}( jQuery, window.elementorFrontend ) );