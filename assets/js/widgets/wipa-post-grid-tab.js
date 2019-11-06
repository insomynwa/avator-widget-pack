( function( $, elementor ) {

	'use strict';

	var widgetPostGridTab = function( $scope, $ ) {

		var $postGridTab = $scope.find( '.avt-post-grid-tab' ),
            gridTab      = $postGridTab.find('> .gridtab');

        if ( ! $postGridTab.length ) {
            return;
        }

        $(gridTab).gridtab($postGridTab.data('settings'));

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-post-grid-tab.default', widgetPostGridTab );
	});

}( jQuery, window.elementorFrontend ) );