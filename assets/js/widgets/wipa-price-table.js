( function( $, elementor ) {

	'use strict';

	var widgetPriceTable = function( $scope, $ ) {

		var $priceTable = $scope.find( '.avt-price-table' ),
            $featuresList = $priceTable.find( '.avt-price-table-feature-inner' );

        if ( ! $priceTable.length ) {
            return;
        }

        var $tooltip = $featuresList.find('> .avt-tippy-tooltip');
		
		$tooltip.each( function( index ) {
			tippy( this, {
				appendTo: $scope[0]
			});				
		});

    };
    

	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-price-table.default', widgetPriceTable );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-price-table.avt-partait', widgetPriceTable );
	});

}( jQuery, window.elementorFrontend ) );