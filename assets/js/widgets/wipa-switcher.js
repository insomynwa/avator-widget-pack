( function( $, elementor ) {

	'use strict';

	var sectionSwitcher = function( $scope, $ ) {
	    var $switcher = $scope.find('.avt-switchers'),
		    $settings = $switcher.data('settings'),
		    editMode  = Boolean( elementor.isEditMode() );


		if ( $settings === undefined || editMode ) {
			return;
		}

		var $switchAContainer = $switcher.find('.avt-switcher > div > div > .avt-switcher-item-a'),
		    $switchBContainer = $switcher.find('.avt-switcher > div > div > .avt-switcher-item-b'),
		    $switcherContentA = $('.elementor').find( '.elementor-section' + '#' + $settings['switch-a-content'] ),
		    $switcherContentB = $('.elementor').find( '.elementor-section' + '#' + $settings['switch-b-content'] );


	    if ( $switchAContainer.length && $switcherContentA.length ) {
    		$( $switcherContentA ).appendTo( $switchAContainer );
	    }

	    if ( $switchBContainer.length && $switcherContentB.length ) {
	    	$( $switcherContentB ).appendTo( $switchBContainer );
	    }

	};

	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-switcher.default', sectionSwitcher );
	});

}( jQuery, window.elementorFrontend ) );