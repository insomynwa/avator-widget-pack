( function( $ ) {

	'use strict';

	var WidgetPackEditor = {

		init: function() {
			elementor.channels.editor.on( 'section:activated', WidgetPackEditor.onAnimatedBoxSectionActivated );

			window.elementor.on( 'preview:loaded', function() {
				elementor.$preview[0].contentWindow.WidgetPackEditor = WidgetPackEditor;

				WidgetPackEditor.onPreviewLoaded();
			});
		},

		onPreviewLoaded: function() {
			var elementorFrontend = $('#elementor-preview-iframe')[0].contentWindow.elementorFrontend;

			elementorFrontend.hooks.addAction( 'frontend/element_ready/widget', function( $scope ){

				$scope.find( '.avt-elementor-template-edit-link' ).on( 'click', function( event ){
					window.open( $( this ).attr( 'href' ) );
				});
			});
		}
	};

	$( window ).on( 'elementor:init', WidgetPackEditor.init );

	window.WidgetPackEditor = WidgetPackEditor;

}( jQuery ) );
