( function( $, elementor ) {

    'use strict';

    var WidgetPack = {

        init: function() {

            elementor.hooks.addAction( 'frontend/element_ready/section', WidgetPack.elementorSection );
        },

        elementorSection: function( $scope ) {
            var $section = $scope,
                instance = null;

            instance = new avtWidgetTooltip($section);
            instance.init();
        }


    };

    $( window ).on( 'elementor/frontend/init', WidgetPack.init );

    window.avtWidgetTooltip = function ( $selector ) {

        var $tooltip = $selector.find('.elementor-widget.avt-tippy-tooltip');

        this.init = function() {
            if ( ! $tooltip.length ) {
                return;
            }
            $tooltip.each( function( index ) {

                tippy( this, {
                    appendTo: this
                });
            });
        };

    };

}( jQuery, window.elementorFrontend ) );
