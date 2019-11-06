( function( $, elementor ) {

	'use strict';

	var widgetParticles = function( $scope, $ ) {

        var $section   = $scope,
            sectionID  = $section.data('id'),
            //editMode   = Boolean( elementor.isEditMode() ),
            particleID = 'avt-particle-container-' + sectionID,
            particleSettings = {};


        if (typeof particlesJS === 'undefined') {
            return;
        }

        if ( window.WidgetPackConfig && window.WidgetPackConfig.elements_data.sections.hasOwnProperty( sectionID ) ) {
            particleSettings = window.WidgetPackConfig.elements_data.sections[ sectionID ];
        }
        
        
        $.each($section, function( index ) {
            var $this = $(this);
            if ($this.hasClass('avt-particles-yes')) {
                $section.prepend( '<div id="'+particleID+'" class="avt-particle-container"></div>' );
                particlesJS( particleID, JSON.parse( particleSettings.particles_js ));
            }
        });

	};


	jQuery(window).on('elementor/frontend/init', function() {
        elementor.hooks.addAction( 'frontend/element_ready/section', widgetParticles );
	});

}( jQuery, window.elementorFrontend ) );