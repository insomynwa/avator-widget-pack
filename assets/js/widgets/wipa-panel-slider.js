( function( $, elementor ) {

	'use strict';

	var widgetPanelSlider = function( $scope, $ ) {

		var $slider = $scope.find( '.avt-panel-slider' );
				
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
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-panel-slider.default', widgetPanelSlider );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-panel-slider.avt-middle', widgetPanelSlider );
	});

}( jQuery, window.elementorFrontend ) );