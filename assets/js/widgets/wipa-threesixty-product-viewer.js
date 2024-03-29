( function( $, elementor ) {

	'use strict';

	var widgetTSProductViewer = function( $scope, $ ) {

		var $TSPV      	   = $scope.find( '.avt-threesixty-product-viewer' ),
            $settings      = $TSPV.data('settings'),
            $container     = $TSPV.find('> .avt-tspv-container'), 
            $fullScreenBtn = $TSPV.find('> .avt-tspv-fb');  

        if ( ! $TSPV.length ) {
            return;
        }
        

        if ($settings.source_type === 'remote') {
            $settings.source = SpriteSpin.sourceArray( $settings.source, { frame: $settings.frame_limit, digits: $settings.image_digits} );
        }

        elementorFrontend.waypoint( $container, function() {
            var $this = $( this );
            $this.spritespin($settings);

        }, {
            offset: 'bottom-in-view'
        } );

        

        //if ( ! $fullScreenBtn.length ) {
            $($fullScreenBtn).click(function(e) {
                e.preventDefault();
                $($container).spritespin('api').requestFullscreen();
            });
        //}

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-threesixty-product-viewer.default', widgetTSProductViewer );
	});

}( jQuery, window.elementorFrontend ) );