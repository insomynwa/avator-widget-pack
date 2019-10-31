( function( $, elementor ) {

	'use strict';

	//Audio Player
	//
	var serachTimer;

	var widgetAjaxSearch = function($search) {

		var $searchWidget = $('.avt-ajax-search');
		var $resultHolder = $($searchWidget).find('.avt-search-result');
		
		clearTimeout( serachTimer );

		serachTimer = setTimeout( function() {

			$($searchWidget).addClass('avt-search-loading');

			jQuery.ajax({
				url: window.WidgetPackConfig.ajaxurl,
				type:'post',
				data: {
					action: 'widget_pack_search',
					s: $search,

				},
				success:function(response){
					response=$.parseJSON(response);
					//console.log(response);
					//console.log(response.results);
					if( response.results.length > 0 ){
						var html = '<div class="avt-search-result-inner">';
						html += '<h3 class="avt-search-result-header">SEARCH RESULT</h3>';
						html += '<ul class="avt-list avt-list-divider">';
						for( var i = 0; i < response.results.length; i++ ){
							html += '<li class="avt-search-item" data-url="'+ response.results[i].url + '">\
                                          <a href="' + response.results[i].url + '" target="_blank">\
                                              <div class="avt-search-title">' + response.results[i].title + '</div>\
                                              <div class="avt-search-text">' + response.results[i].text + '</div>\
                                          </a>\
                                      </li>\
                                    ';
						}
						html += '</ul>';
						html += '<a class="avt-search-more">More Results</a>';
						html += '</div>';
						
						$resultHolder.html(html);

						avtUIkit.drop($resultHolder, {
							pos: 'bottom-justify'
						}).show();

						$($searchWidget).removeClass('avt-search-loading');

						$('.avt-search-more').on('click', function(event){
							event.preventDefault();       
							$($searchWidget).submit()
						});

					}


				}
			});

		}, 450 );
		
	};

	window.widgetPackAjaxSearch = widgetAjaxSearch;

}( jQuery, window.elementorFrontend ) );