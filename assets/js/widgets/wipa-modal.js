( function( $, elementor ) {

	'use strict';

	var widgetModal = function( $scope, $ ) {

		var $modal = $scope.find( '.avt-modal' );
        
        if ( ! $modal.length ) {
            return;
        }

        $.each($modal, function(index, val) {
            
            var $this   	= $(this),
                $settings   = $this.data('settings'),
                modalShowed = false,
                modalID     = $settings.id;
            
            if (!$settings.dev) {
                modalShowed = localStorage.getItem( modalID );
            }
            
            if(!modalShowed){
                if ('exit' === $settings.layout) {
                    document.addEventListener('mouseleave', function(event){
                        if(event.clientY <= 0 || event.clientX <= 0 || (event.clientX >= window.innerWidth || event.clientY >= window.innerHeight)) {
                            avtUIkit.modal($this).show();
                            localStorage.setItem( modalID , true );      
                        }
                        
                    });
                } else if ('splash' === $settings.layout) {
                    setTimeout(function(){
                        avtUIkit.modal($this).show();      
                        localStorage.setItem( modalID , true );      
                    }, $settings.delayed );
                }	
            }
            
            if ( $(modalID).length ) {
                // global custom link for a tag
                $(modalID).on('click', function(event){
                    event.preventDefault();       
                    avtUIkit.modal( $this ).show();
                });
            }

        });

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-modal.default', widgetModal );
	});

}( jQuery, window.elementorFrontend ) );