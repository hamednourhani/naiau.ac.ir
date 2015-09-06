jQuery('document').ready(function($){

	
	

	$('a#menu-toggler').click(function(){
		
		var responsive_container = $('div#responsive-menu');
		var close_button = responsive_container.children('a#close-responsive');
		var body_wrapper = $('.body-wrapper');
		var menu_height = $(window).height();
		responsive_container.css('height',menu_height).addClass('show-menu');
		

		close_button.click(function(event){
			//event.stopPropagination();
			responsive_container.removeClass('show-menu');
		});

		// body_wrapper.click(function(event){
		// 	event.stopPropagination();
		// 	responsive_container.removeClass('show-menu');

		// });
	});

	$('.search-area::before').click(function(){
		$('form#searchform').submit();
	});
})	

