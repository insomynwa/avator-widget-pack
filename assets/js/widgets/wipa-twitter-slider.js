( function( $, elementor ) {

	'use strict';

	var widgetTwitterSlider = function( $scope, $ ) {

		var $twitterSlider = $scope.find( '.avt-twitter-slider' );
				
        if ( ! $twitterSlider.length ) {
            return;
        }

		var $twitterSliderContainer = $twitterSlider.find('.swiper-container'),
			$settings 		 = $twitterSlider.data('settings');

		var swiper = new Swiper($twitterSliderContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($twitterSliderContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-twitter-slider.default', widgetTwitterSlider );
	});

}( jQuery, window.elementorFrontend ) );