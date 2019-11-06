( function( $, elementor ) {

	'use strict';

	var widgetInstagram = function( $scope, $ ) {

		var $instagram = $scope.find( '.avt-instagram' ),
            $settings  = $instagram.data('settings'),
            $loadMoreBtn = $instagram.find('.avt-load-more');

        if ( ! $instagram.length ) {
            return;
        }
    
        var $currentPage = $settings['current_page'];
        
        callInstagram();

        $($loadMoreBtn).on('click', function(event){
            
            if ($loadMoreBtn.length) {
                $loadMoreBtn.addClass('avt-load-more-loading');
            }

            $currentPage++;

            $settings['current_page'] = $currentPage;

            callInstagram();
        });


        function callInstagram(){
            var $itemHolder = $instagram.find('> .avt-grid');

            jQuery.ajax({
                url: window.WidgetPackConfig.ajaxurl,
                type:'post',
                data: $settings,
                success:function(response){
                    if($currentPage == 1){
                        $itemHolder.html(response);	
                    } else {
                        $itemHolder.append(response);
                    }

                    if ($loadMoreBtn.length) {
                        $loadMoreBtn.removeClass('avt-load-more-loading');
                    }

                }
            });
        }

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-instagram.default', widgetInstagram );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-instagram.avt-instagram-carousel', widgetInstagram );
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-instagram.avt-classic-grid', widgetInstagram );
	});

}( jQuery, window.elementorFrontend ) );