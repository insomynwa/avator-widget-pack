( function( $, elementor ) {

	'use strict';

	var widgetTable = function( $scope, $ ) {

		var $tableContainer = $scope.find( '.avt-data-table' ),
            $settings       = $tableContainer.data('settings'),
            $table          = $tableContainer.find('> table');

        if ( ! $tableContainer.length ) {
            return;
        }

        $settings.language = window.WidgetPackConfig.data_table.language;

        $($table).DataTable($settings);

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-table.default', widgetTable );
	});

}( jQuery, window.elementorFrontend ) );