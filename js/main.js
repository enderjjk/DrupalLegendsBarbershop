$(function(){
	
	$("#my-gallery").justifiedGallery({
		rowHeight : 200, 
		rel : 'gallery2',
		margins : 1
	}).on('jg.complete', function () {
		$('#my-gallery a').swipebox();
	});

	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('#scrollToTop').fadeIn();
		} else {
			$('#scrollToTop').fadeOut();
		}
	});
	
	var custom_event = $.support.touch ? "tap" : "click";
	
	$(document).on(custom_event, '#mobile-menu-icon', function(){
		$(this).toggleClass('opened');
		$('#mobile-menu').toggle();
	}).on(custom_event, '#search-top', function(){
		$('#search-area').toggleClass('open');
	}).on(custom_event, '#scrollToTop', function(){
		$('html, body').animate({scrollTop : 0},800);
		return false;
	}).on(custom_event, '#mobile-menu li a', function(){
		$('#mobile-menu').toggle();
	});
	$('.view-id-blog').masonry({
	  // options
	  itemSelector: '.blog-row'
	});

});