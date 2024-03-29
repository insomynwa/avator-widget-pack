( function( $, elementor ) {

	'use strict';

	var widgetSlider = function( $scope, $ ) {

		var $slider = $scope.find( '.avt-slider' );
				
        if ( ! $slider.length ) {
            return;
        }

        var $sliderContainer = $slider.find('.swiper-container'),
			$settings 		 = $slider.data('settings');

		var swiper = new Swiper($sliderContainer, $settings);

		if ($settings.pauseOnHover) {
			 $($sliderContainer).hover(function() {
				(this).swiper.autoplay.stop();
			}, function() {
				(this).swiper.autoplay.start();
			});
		}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-slider.default', widgetSlider );
	});

}( jQuery, window.elementorFrontend ) );