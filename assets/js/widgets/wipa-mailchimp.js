( function( $, elementor ) {

	'use strict';

	var widgetMailChimp = function( $scope, $ ) {

		var $mailChimp = $scope.find('.avt-mailchimp');
			
        if ( ! $mailChimp.length ) {
            return;
        }

        var langStr = window.WidgetPackConfig.mailchimp;

        $mailChimp.submit(function(){
            
            var mailchimpform = $(this);
            avtUIkit.notification({message: '<span avt-spinner></span> ' + langStr.subscribing, timeout: false, status: 'primary'});
            $.ajax({
                url:mailchimpform.attr('action'),
                type:'POST',
                data:mailchimpform.serialize(),
                success:function(data){
                    avtUIkit.notification.closeAll();
                    avtUIkit.notification({message: data, status: 'success'});
                }
            });
            return false;

        });

        return false;

	};


	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-mailchimp.default', widgetMailChimp );
	});

}( jQuery, window.elementorFrontend ) );