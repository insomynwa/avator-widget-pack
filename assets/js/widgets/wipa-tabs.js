( function( $, elementor ) {

	'use strict';

	var widgetTabs = function( $scope, $ ) {

		var $tabs = $scope.find( '.avt-tabs' ),
            $tab = $tabs.find('.avt-tab');
            
        if ( ! $tabs.length ) {
            return;
        }

        var tabID = $(location.hash);

        if (tabID.length > 0 && tabID.hasClass('avt-tabs-item-title')) {
            $('html').animate({
                easing:  'slow',
                scrollTop: tabID.offset().top,
            }, 500, function() {
                avtUIkit.tab($tab).show($(tabID).data('tab-index'));
            });  
        }

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-tabs.default', widgetTabs );
	});

}( jQuery, window.elementorFrontend ) );