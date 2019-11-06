( function( $, elementor ) {

	'use strict';

	var widgetTableOfContent = function( $scope, $ ) {

		var $tableOfContent = $scope.find( '.avt-table-of-content' );
				
        if ( ! $tableOfContent.length ) {
            return;
        }			

        $($tableOfContent).tocify($tableOfContent.data('settings'));

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-table-of-content.default', widgetTableOfContent );
	});

}( jQuery, window.elementorFrontend ) );