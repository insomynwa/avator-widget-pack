( function( $, elementor ) {

	'use strict';

	var widgetScrollButton = function( $scope, $ ) {
	    
	    var $scrollButton = $scope.find('.avt-scroll-button'),
	    	$selector = $scrollButton.data('selector'),
	    	$settings =  $scrollButton.data('settings');

	    if ( ! $scrollButton.length ) {
	    	return;
	    }

	    //$($scrollButton).find('.avt-scroll-button').unbind();

	    $($scrollButton).on('click', function(event){
	    	event.preventDefault();
	    	avtUIkit.scroll($scrollButton, $settings ).scrollTo($($selector));
	    });

	};

	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-scroll-button.default', widgetScrollButton );
	});

}( jQuery, window.elementorFrontend ) );