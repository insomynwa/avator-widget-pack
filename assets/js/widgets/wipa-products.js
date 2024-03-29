( function( $, elementor ) {

	'use strict';

	var widgetWCProductTable = function( $scope, $ ) {

		var $productTable = $scope.find( '.avt-wc-products-skin-table' ),
            $settings 	  = $productTable.data('settings'),
            $table        = $productTable.find('> table');
            
        if ( ! $productTable.length ) {
            return;
        }

        $settings.language = window.WidgetPackConfig.data_table.language;

        $($table).DataTable($settings);

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-wc-products.avt-table', widgetWCProductTable );
	});

}( jQuery, window.elementorFrontend ) );