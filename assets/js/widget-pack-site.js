( function( $, elementor ) {

	'use strict';

	var WidgetPack = {

		init: function() {

			var widgets = {
				'avt-advanced-gmap.default' 			   : WidgetPack.widgetAvdGoogleMap,
				'avt-accordion.default' 			   	   : WidgetPack.widgetAccordion,
				'avt-animated-heading.default'  		   : WidgetPack.widgetAnimatedHeading,
				'avt-chart.default' 					   : WidgetPack.widgetChart,
				'avt-carousel.default' 					   : WidgetPack.widgetCarousel,
				'avt-carousel.avt-alice' 				   : WidgetPack.widgetCarousel,
				'avt-carousel.avt-vertical' 			   : WidgetPack.widgetCarousel,
				'avt-custom-carousel.default' 			   : WidgetPack.widgetCustomCarousel,
				'avt-custom-carousel.avt-custom-content'   : WidgetPack.widgetCustomCarousel,
				'avt-panel-slider.default' 				   : WidgetPack.widgetPanelSlider,
				'avt-panel-slider.avt-middle' 		   	   : WidgetPack.widgetPanelSlider,
				'avt-slider.default' 					   : WidgetPack.widgetSlider,
				'avt-circle-menu.default' 				   : WidgetPack.widgetCircleMenu,
				'avt-open-street-map.default' 			   : WidgetPack.widgetOpenStreetMap,
				'avt-contact-form.default' 				   : WidgetPack.widgetSimpleContactForm,
				'avt-cookie-consent.default' 			   : WidgetPack.widgetCookieConsent,
				'avt-event-carousel.default' 			   : WidgetPack.widgetEventCarousel,
				'avt-helpdesk.default' 					   : WidgetPack.widgetHelpDesk,
				'avt-iconnav.default' 					   : WidgetPack.widgetIconNav,
				'avt-iframe.default' 					   : WidgetPack.widgetIframe,
				'avt-instagram.default' 				   : WidgetPack.widgetInstagram,
				'avt-instagram.avt-instagram-carousel'	   : WidgetPack.widgetInstagram,
				'avt-instagram.avt-classic-grid'           : WidgetPack.widgetInstagram,
				'avt-image-compare.default' 			   : WidgetPack.widgetImageCompare,
				'avt-image-magnifier.default' 			   : WidgetPack.widgetImageMagnifier,
				'avt-marker.default' 					   : WidgetPack.widgetMarker,
				'avt-mailchimp.default' 				   : WidgetPack.widgetMailChimp,
				'avt-modal.default' 					   : WidgetPack.widgetModal,
				'avt-news-ticker.default' 				   : WidgetPack.widgetNewsTicker,
				'avt-offcanvas.default' 				   : WidgetPack.widgetOffcanvas,
				'avt-scrollnav.default' 				   : WidgetPack.widgetScrollNav,
				'avt-post-grid-tab.default' 			   : WidgetPack.widgetPostGridTab,
				'avt-price-table.default' 				   : WidgetPack.widgetPriceTable,
				'avt-price-table.avt-partait' 			   : WidgetPack.widgetPriceTable,
				'avt-progress-pie.default' 				   : WidgetPack.widgetProgressPie,
				'avt-comment.default' 					   : WidgetPack.widgetComment,
				'avt-qrcode.default' 					   : WidgetPack.widgetQRCode,
				'avt-table.default' 				  	   : WidgetPack.widgetTable,
				'avt-table-of-content.default' 			   : WidgetPack.widgetTableOfContent,
				'avt-tabs.default' 			   			   : WidgetPack.widgetTabs,
				'avt-timeline.avt-olivier' 				   : WidgetPack.widgetTimeline,
				'avt-testimonial-carousel.default' 		   : WidgetPack.widgetTCarousel,
				'avt-testimonial-carousel.avt-twyla' 	   : WidgetPack.widgetTCarousel,
				'avt-testimonial-carousel.avt-vyxo' 	   : WidgetPack.widgetTCarousel,
				'avt-testimonial-slider.default' 		   : WidgetPack.widgetTSlider,
				'avt-twitter-carousel.default' 		       : WidgetPack.widgetTwitterCarousel,
				'avt-twitter-slider.default' 		       : WidgetPack.widgetTwitterSlider,
				'avt-threesixty-product-viewer.default'    : WidgetPack.widgetTSProductViewer,
				'avt-video-gallery.default' 			   : WidgetPack.widgetVideoGallery,
				'avt-wc-carousel.default' 				   : WidgetPack.widgetWCCarousel,
				'avt-wc-carousel.wc-carousel-hidie'		   : WidgetPack.widgetWCCarousel,
				'avt-wc-products.avt-table' 			   : WidgetPack.widgetWCProductTable
			};

			// Action for widget pack widget scripts
			$.each( widgets, function( widget, callback ) {
				elementor.hooks.addAction( 'frontend/element_ready/' + widget, callback );
			});

			// Action for element section scripts
			elementor.hooks.addAction( 'frontend/element_ready/section', WidgetPack.elementorSection );
		},		
		
		//Animated Heading
		widgetAnimatedHeading: function( $scope ) {
			var $heading = $scope.find( '.avt-heading > *' ),
				$animatedHeading = $heading.find( '.avt-animated-heading' ),
				$settings = $animatedHeading.data('settings');
				
			if ( ! $heading.length ) {
				return;
			}

    		if ( $settings.layout === 'animated' ) {
				$($animatedHeading).Morphext($settings);
			} else if ( $settings.layout === 'typed' ) {
				var animateSelector = $($animatedHeading).attr('id');
				var typed = new Typed('#'+animateSelector, $settings);
			}

	        $($heading).animate({
	        	easing:  'slow',
                opacity: 1
            }, 500 );


		},

		//Advanced Google Map
		widgetAvdGoogleMap: function( $scope ) {

			var $advancedGoogleMap = $scope.find( '.avt-advanced-gmap' ),
				map_settings       = $advancedGoogleMap.data('map_settings'),
				markers            = $advancedGoogleMap.data('map_markers'),
				map_form           = $scope.find('.avt-gmap-search-wrapper > form');				

			if ( ! $advancedGoogleMap.length ) {
				return;
			}
			
			var avdGoogleMap = new GMaps( map_settings );

			for (var i in markers) {
				avdGoogleMap.addMarker(markers[i]);
			}

			if($advancedGoogleMap.data('map_geocode')) {
				$(map_form).submit(function(e){
					e.preventDefault();
					GMaps.geocode({
						address: $(this).find('.avt-search-input').val().trim(),
						callback: function(results, status){
							if( status === 'OK' ){
								var latlng = results[0].geometry.location;
								avdGoogleMap.setCenter(
									latlng.lat(), 
									latlng.lng()
								);
								avdGoogleMap.addMarker({
									lat: latlng.lat(),
									lng: latlng.lng()
								});
							}	
						}
					});
				});
			}

			if($advancedGoogleMap.data('map_style')) {
		        avdGoogleMap.addStyle({
		            styledMapName: 'Custom Map',
		            styles: $advancedGoogleMap.data('map_style'),
		            mapTypeId: 'map_style'
				});
		        avdGoogleMap.setStyle('map_style');
	        }
		},

		//Open Street Map
		widgetOpenStreetMap: function( $scope ) {

			var $openStreetMap = $scope.find( '.avt-open-street-map' ),
				settings       = $openStreetMap.data('settings'),
				markers        = $openStreetMap.data('map_markers');

			if ( ! $openStreetMap.length ) {
				return;
			}

			var avdOSMap = L.map($openStreetMap[0], {
					zoomControl: settings.zoomControl,
					scrollWheelZoom: false
				}).setView([
						settings.lat,
						settings.lng
					], 
				    settings.zoom
				);

			L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + settings.osmAccessToken, {
				maxZoom: 18,
				attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
					'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
					'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
				id: 'mapbox.streets'
			}).addTo(avdOSMap);

			var LeafIcon = L.Icon.extend({
				options: {
					iconSize:     [38, 95],
					iconAnchor:   [22, 94],
					shadowAnchor: [4, 62],
					popupAnchor:  [-3, -76]
				}
			});

			for (var i in markers) {
				var greenIcon = new LeafIcon({iconUrl: markers[i]['iconUrl'] });
				L.marker([markers[i]['lat'], markers[i]['lng']], {icon: greenIcon}).bindPopup(markers[i]['infoWindow']).addTo(avdOSMap);
			}			

		},

		//Chart widget
		widgetChart: function( $scope ) {

			var	$chart    	  = $scope.find( '.avt-chart' ),
				$chart_canvas = $chart.find( '> canvas' ),
				settings      = $chart.data('settings');

			if ( ! $chart.length ) {
				return;
			}

			elementorFrontend.waypoint( $chart_canvas, function() {
				var $this   = $( this ),
					ctx     = $this[0].getContext('2d'),
					myChart = new Chart(ctx, settings);
			}, {
				offset: 'bottom-in-view'
			} );
		},

		//Carousel
		widgetCarousel: function( $scope ) {

			var $carousel 		   = $scope.find( '.avt-carousel' );
				
			if ( ! $carousel.length ) {
				return;
			}

			WidgetPack.swiperSlider($carousel);		    
		},

		//Carousel
		widgetCustomCarousel: function( $scope ) {

			var $carousel = $scope.find( '.avt-custom-carousel' );
				
			if ( ! $carousel.length ) {
				return;
			}

			WidgetPack.swiperSlider($carousel);		    
		},

		//Testimonial Carousel
		widgetTCarousel: function( $scope ) {

			var $tCarousel = $scope.find( '.avt-testimonial-carousel' );
				
			if ( ! $tCarousel.length ) {
				return;
			}

			WidgetPack.swiperSlider($tCarousel);		    
		},

		//Twitter Carousel
		widgetTwitterCarousel: function( $scope ) {

			var $twitterCarousel = $scope.find( '.avt-twitter-carousel' );
				
			if ( ! $twitterCarousel.length ) {
				return;
			}

			//console.log($twitterCarousel);

			WidgetPack.swiperSlider($twitterCarousel);		    
		},

		//Twitter Slider
		widgetTwitterSlider: function( $scope ) {

			var $twitterSlider = $scope.find( '.avt-twitter-slider' );
				
			if ( ! $twitterSlider.length ) {
				return;
			}

			WidgetPack.swiperSlider($twitterSlider);		    
		},

		//WC Carousel
		widgetWCCarousel: function( $scope ) {

			var $wcCarousel = $scope.find( '.avt-wc-carousel' );
				
			if ( ! $wcCarousel.length ) {
				return;
			}

			WidgetPack.swiperSlider($wcCarousel);		    
		},

		//Panel Slider
		widgetPanelSlider: function( $scope ) {

			var $slider = $scope.find( '.avt-panel-slider' );
				
			if ( ! $slider.length ) {
				return;
			}

			WidgetPack.swiperSlider($slider);		    
		},

		//Slider
		widgetSlider: function( $scope ) {

			var $slider = $scope.find( '.avt-slider' );
				
			if ( ! $slider.length ) {
				return;
			}

			WidgetPack.swiperSlider($slider);		    
		},

		swiperSlider: function( $slider ) {

			var $sliderContainer = $slider.find('.swiper-container'),
				$settings 		 = $slider.data('settings');

		    var swiper = new Swiper($sliderContainer, $settings);

		    if ($settings.pauseOnHover) {
			 	$($sliderContainer).hover(function() {
				    (this).swiper.autoplay.stop();
				}, function() {
				    (this).swiper.autoplay.start();
				});
			}
		},

		// Comment widget
		widgetComment: function( $scope ) {

			var $comment = $scope.find( '.avt-comment-container' ),
				$settings = $comment.data('settings');
				
			if ( ! $comment.length ) {
				return;
			}

		    if ($settings.layout === 'disqus') {

			    var disqus_config = function () {
			    this.page.url = $settings.permalink;  // Replace PAGE_URL with your page's canonical URL variable
			    this.page.identifier = $comment; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			    };
			    
			    (function() { // DON'T EDIT BELOW THIS LINE
			    var d = document, s = d.createElement('script');
			    s.src = '//' + $settings.username + '.disqus.com/embed.js';
			    s.setAttribute('data-timestamp', +new Date());
			    (d.head || d.body).appendChild(s);
			    })();

		    } else if ($settings.layout === 'facebook') {
		    	
		    	//var $fb_script = document.getElementById("facebook-jssdk");

		    	//console.log($fb_script);

		    	// if($fb_script){
		    	// 	$($fb_script).remove();
		    	// } else {
		    	// }

				// jQuery.ajax({
				// 	url: 'https://connect.facebook.net/en_US/sdk.js',
				// 	dataType: 'script',
				// 	cache: true,
				// 	success: function() {
				// 		FB.init( {
				// 			appId: config.app_id,
				// 			version: 'v2.10',
				// 			xfbml: false
				// 		} );
				// 		config.isLoaded = true;
				// 		config.isLoading = false;
				// 		jQuery( document ).trigger( 'fb:sdk:loaded' );
				// 	}
				// });
				// 
				// 
				(function(d, s, id){
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = 'https://connect.facebook.net/en_US/sdk.js';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
	    	        

    	        window.fbAsyncInit = function() {
    	           FB.init({
    	             appId            : $settings.app_id,
    	             autoLogAppEvents : true,
    	             xfbml            : true,
    	             version          : 'v3.2'
    	           });
    	        };

		    } 
		},

		// loadSDK: function() {
		// 	// Don't load in parallel
		// 	if ( config.isLoading || config.isLoaded ) {
		// 		return;
		// 	}

		// 	config.isLoading = true;

		// 	jQuery.ajax( {
		// 		url: 'https://connect.facebook.net/en_US/sdk.js',
		// 		dataType: 'script',
		// 		cache: true,
		// 		success: function() {
		// 			FB.init( {
		// 				appId: $settings.app_id,
		// 				version: 'v2.10',
		// 				xfbml: false
		// 			} );
		// 			config.isLoaded = true;
		// 			config.isLoading = false;
		// 			jQuery( document ).trigger( 'fb:sdk:loaded' );
		// 		}
		// 	} );
		// },


		//360 degree product viewer
		widgetTSProductViewer: function( $scope ) {

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

		},

		//Image Compare
		widgetImageCompare: function( $scope ) {

			var $imageCompare         = $scope.find( '.avt-image-compare > .twentytwenty-container' ),
				default_offset_pct    = $imageCompare.data('default_offset_pct'),
				orientation           = $imageCompare.data('orientation'),
				before_label          = $imageCompare.data('before_label'),
				after_label           = $imageCompare.data('after_label'),
				no_overlay            = $imageCompare.data('no_overlay'),
				move_slider_on_hover  = $imageCompare.data('move_slider_on_hover'),
				move_with_handle_only = $imageCompare.data('move_with_handle_only'),
				click_to_move         = $imageCompare.data('click_to_move');

			if ( ! $imageCompare.length ) {
				return;
			}

			$($imageCompare).twentytwenty({
			    default_offset_pct: default_offset_pct,
			    orientation: orientation,
			    before_label: before_label,
			    after_label: after_label,
			    no_overlay: no_overlay,
			    move_slider_on_hover: move_slider_on_hover,
			    move_with_handle_only: move_with_handle_only,
			    click_to_move: click_to_move
		  	});

		},

		// QR Code Object
		widgetQRCode: function($scope) {
			var $qrcode = $scope.find( '.avt-qrcode' ),
				image   = $scope.find( '.avt-qrcode-image' );

			if ( ! $qrcode.length ) {
				return;
			}
			var settings = $qrcode.data('settings');
				settings.image = image[0];

		   $($qrcode).qrcode(settings);
		},

		// Table Code Object
		widgetTable: function($scope) {
			var $tableContainer = $scope.find( '.avt-data-table' ),
				$settings       = $tableContainer.data('settings'),
				$table          = $tableContainer.find('> table');

			if ( ! $tableContainer.length ) {
				return;
			}

			$settings.language = window.WidgetPackConfig.data_table.language;

		    $($table).DataTable($settings);
		},

		//Progress Iframe
		widgetIframe: function( $scope ) {

			var $iframe = $scope.find( '.avt-iframe > iframe' ),
				$autoHeight = $iframe.data('auto_height');

			if ( ! $iframe.length ) {
				return;
			}

			// Auto height only works when cross origin properly set
			if ($autoHeight) {
				$($iframe).load(function() {
				    $(this).height( $(this).contents().find('html').height() );
				});
			}

			WidgetPack.lazyLoader($iframe);
		},

		//Progress Instagram
		widgetInstagram: function( $scope ) {

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

			
		},

		


		lazyLoader:function( $scope ) {
			var $lazyload = $scope;

			$($lazyload).recliner({
				throttle : $lazyload.data('throttle'),
				threshold : $lazyload.data('threshold'),
				live : $lazyload.data('live')
			});
		},

		//Iconnav
		widgetIconNav: function( $scope ) {

			var $iconnav        = $scope.find( 'div.avt-icon-nav' ),
				$iconnavTooltip = $iconnav.find( '.avt-icon-nav' );

			if ( ! $iconnav.length ) {
				return;
			}

			WidgetPack.tippyTooltip($iconnavTooltip, $scope);
		},

		widgetMarker: function( $scope ) {

			var $marker = $scope.find( '.avt-marker-wrapper' );

			if ( ! $marker.length ) {
				return;
			}

			WidgetPack.tippyTooltip($marker, $scope);
		},

		widgetHelpDesk: function( $scope ) {

			var $helpdesk = $scope.find( '.avt-helpdesk' ),
				$helpdeskTooltip = $helpdesk.find('.avt-helpdesk-icons');

			if ( ! $helpdesk.length ) {
				return;
			}

			WidgetPack.tippyTooltip($helpdeskTooltip, $scope);
		},

		widgetModal: function( $scope ) {

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
			

			

		},

		widgetOffcanvas: function( $scope ) {

			var $offcanvas = $scope.find( '.avt-offcanvas' );
			
			if ( ! $offcanvas.length ) {
				return;
			}


			$.each($offcanvas, function(index, val) {
				
				var $this   	= $(this),
					$settings   = $this.data('settings'),
					offcanvasID = $settings.id;
				
				if ( $(offcanvasID).length ) {
					// global custom link for a tag
					$(offcanvasID).on('click', function(event){
						event.preventDefault();       
						avtUIkit.offcanvas( $this ).show();
					});
				}

			});
			

			

		},

		widgetScrollNav: function( $scope ) {

			var $scrollnav = $scope.find( '.avt-dotnav > li' );

			if ( ! $scrollnav.length ) {
				return;
			}

			WidgetPack.tippyTooltip($scrollnav, $scope);
		},

		widgetPriceTable: function( $scope ) {

			var $priceTable = $scope.find( '.avt-price-table' ),
				$featuresList = $priceTable.find( '.avt-price-table-feature-inner' );

			if ( ! $priceTable.length ) {
				return;
			}

			WidgetPack.tippyTooltip($featuresList, $scope);
		},

		tippyTooltip:function( $selector, $appendIn ) {
			var $tooltip = $selector.find('> .avt-tippy-tooltip');
			
			$tooltip.each( function( index ) {
				tippy( this, {
					appendTo: $appendIn[0]
				});				
			});

		},

		// Circle Menu
		widgetCircleMenu: function( $scope ) {
			var $circleMenu = $scope.find('.avt-circle-menu'),
				$settings = $circleMenu.data('settings');

			if ( ! $circleMenu.length ) {
				return;
			}

            $($circleMenu[0]).circleMenu({
				direction           : $settings.direction,
				item_diameter       : $settings.item_diameter,
				circle_radius       : $settings.circle_radius,
				speed               : $settings.speed,
				delay               : $settings.delay,
				step_out            : $settings.step_out,
				step_in             : $settings.step_in,
				trigger             : $settings.trigger,
				transition_function : $settings.transition_function
            });
		},

		// NewsTicker widget
		widgetNewsTicker: function( $scope ) {
			var $newsTicker = $scope.find('.avt-news-ticker'),
				$settings = $newsTicker.data('settings');

			if ( ! $newsTicker.length ) {
				return;
			}

			$($newsTicker).epNewsTicker($settings);
		},

		// Contact Form
		widgetSimpleContactForm: function( $scope ) {
			var $contactForm = $scope.find('.avt-contact-form form');
			
			if ( ! $contactForm.length ) {
				return;
			}

			$contactForm.submit(function(){
				WidgetPack.sendContactForm($contactForm);
				return false;
			});

        	return false;
            
		},

		// Mailchimp newsletter
		widgetMailChimp: function( $scope ) {
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
            
		},

		// cookie consent
		widgetCookieConsent: function( $scope ) {
			var $cookieConsent = $scope.find('.avt-cookie-consent'),
				$settings      = $cookieConsent.data('settings'),
				editMode       = Boolean( elementor.isEditMode() );
			
			if ( ! $cookieConsent.length || editMode ) {
				return;
			}

			window.cookieconsent.initialise($settings);
		},

		// google invisible captcha
		widgetPackGIC: function(token) {   
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
					WidgetPack.sendContactForm($contactForm);
				} else {
					console.log($contactForm);
				}
				
				grecaptcha.reset();

			}); //end promise
		},

		sendContactForm: function($contactForm) {
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
		},

		// Event Carousel
		widgetEventCarousel: function( $scope ) {

			var $eventCarousel = $scope.find( '.avt-event-carousel' );
				
			if ( ! $eventCarousel.length ) {
				return;
			}

			WidgetPack.swiperSlider($eventCarousel);		    
		},


		//Post Grid Tab
		widgetPostGridTab: function( $scope ) {

			var $postGridTab = $scope.find( '.avt-post-grid-tab' ),
			    gridTab      = $postGridTab.find('> .gridtab');

			if ( ! $postGridTab.length ) {
				return;
			}

			$(gridTab).gridtab($postGridTab.data('settings'));
		},

		//Progress pie
		widgetProgressPie: function( $scope ) {

			var $progressPie = $scope.find( '.avt-progress-pie' );

			if ( ! $progressPie.length ) {
				return;
			}

			elementorFrontend.waypoint( $progressPie, function() {
				var $this = $( this );
				
					$this.asPieProgress({
					  namespace: 'pieProgress',
					  classes: {
					      svg     : 'avt-progress-pie-svg',
					      number  : 'avt-progress-pie-number',
					      content : 'avt-progress-pie-content'
					  }
					});
					
					$this.asPieProgress('start');

			}, {
				offset: 'bottom-in-view'
			} );

		},

		//Image Magnifier widget
		widgetImageMagnifier: function( $scope ) {

			var $imageMagnifier = $scope.find( '.avt-image-magnifier' ),
				settings        = $imageMagnifier.data('settings'),
				magnifier       = $imageMagnifier.find('> .avt-image-magnifier-image');

			if ( ! $imageMagnifier.length ) {
				return;
			}

			$(magnifier).ImageZoom(settings);

		},

		//Table Of Content widget
		widgetTableOfContent: function( $scope ) {

			var $tableOfContent = $scope.find( '.avt-table-of-content' );
				
			if ( ! $tableOfContent.length ) {
				return;
			}			

			$($tableOfContent).tocify($tableOfContent.data('settings'));			
		},

		//Tabs widget
		widgetTabs: function( $scope ) {

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
		},

		//Accordion widget
		widgetAccordion: function( $scope ) {

			var $accordion = $scope.find( '.avt-accordion' );
				
			if ( ! $accordion.length ) {
				return;
			}

			var acdID = $(location.hash);

			if (acdID.length > 0 && acdID.hasClass('avt-accordion-title')) {
		        $('html').animate({
		        	easing:  'slow',
	                scrollTop: acdID.offset().top,
	            }, 500, function() {
	                avtUIkit.accordion($accordion).toggle($(acdID).data('accordion-index'), true);
	            });  
		    }
		},

		// Video Gallery
		widgetVideoGallery: function( $scope ) {

			var $video_gallery = $scope.find( '.rvs-container' );
				
			if ( ! $video_gallery.length ) {
				return;
			}

			$($video_gallery).rvslider();			
		},

		// Timeline
		widgetTimeline: function( $scope ) {

			var $timeline = $scope.find( '.avt-timeline-skin-olivier' );
				
			if ( ! $timeline.length ) {
				return;
			}

			$($timeline).timeline({
				visibleItems : $timeline.data('visible_items'),
			});			
		},

		// Timeline
		widgetWCProductTable: function( $scope ) {

			var $productTable = $scope.find( '.avt-wc-products-skin-table' ),
				$settings 	  = $productTable.data('settings'),
				$table        = $productTable.find('> table');
				
			if ( ! $productTable.length ) {
				return;
			}

			$settings.language = window.WidgetPackConfig.data_table.language;

			$($table).DataTable($settings);
		},

		elementorSection: function( $scope ) {
			var $section   = $scope,
				instance   = null,
				sectionID  = $section.data('id'),
				//editMode   = Boolean( elementor.isEditMode() ),
				particleID = 'avt-particle-container-' + sectionID,
				particleSettings = {};

			//sticky fixes for inner section.
			$.each($section, function( index ) {
				var $sticky      = $(this),
					$stickyFound = $sticky.find('.elementor-inner-section.avt-sticky');
					
				if ($stickyFound.length) {
					$($stickyFound).wrap('<div class="avt-sticky-wrapper"></div>');
				}
			});

			instance = new avtWidgetTooltip( $section );
			instance.init();

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
		}
	};

	$( window ).on( 'elementor/frontend/init', WidgetPack.init );
	
	//Contact form recaptcha callback, if needed
	window.widgetPackGICCB = WidgetPack.widgetPackGIC;

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
