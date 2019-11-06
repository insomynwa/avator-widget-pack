( function( $, elementor ) {

	'use strict';

	var widgetSimpleContactForm = function( $scope, $ ) {

		var $contactForm = $scope.find('.avt-contact-form form');
			
        if ( ! $contactForm.length ) {
            return;
        }

        $contactForm.submit(function(){
            sendContactForm($contactForm);
            return false;
        });

        return false;

    };

    function sendContactForm($contactForm) {
        var langStr = window.WidgetPackConfig.contact_form;

        $.ajax({
            url:$contactForm.attr('action'),
            type:'POST',
            data:$contactForm.serialize(),
            beforeSend:function(){
                avtUIkit.notification({message: '<div avt-spinner></div> ' + langStr.sending_msg, timeout: false, status: 'primary'});
            },
            success:function(data){
                avtUIkit.notification.closeAll();
                avtUIkit.notification({message: data});
                //$contactForm[0].reset();
            }
        });
        return false;
    };

    // google invisible captcha
	var widgetPackGIC = function(token) {   
        var langStr = window.WidgetPackConfig.contact_form;

        return new Promise(function(resolve, reject) {  
            if (grecaptcha === undefined) {
                avtUIkit.notification({message: '<div avt-spinner></div> ' + langStr.captcha_nd, timeout: false, status: 'warning'});
                reject();
            }

            var response = grecaptcha.getResponse();

            if (!response) {
                avtUIkit.notification({message: '<div avt-spinner></div> ' + langStr.captcha_nr, timeout: false, status: 'warning'});
                reject();
            }

            var $contactForm=$('textarea.g-recaptcha-response').filter(function () {
                return $(this).val() === response;
                }).closest('form.avt-contact-form-form');
            var contactFormAction = $contactForm.attr('action');
            if(contactFormAction && contactFormAction !== ''){
                sendContactForm($contactForm);
            } else {
                console.log($contactForm);
            }
            
            grecaptcha.reset();

        }); //end promise
    };
    

    //Contact form recaptcha callback, if needed
	window.widgetPackGICCB = widgetPackGIC;

	jQuery(window).on('elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/avt-contact-form.default', widgetSimpleContactForm );
	});

}( jQuery, window.elementorFrontend ) );