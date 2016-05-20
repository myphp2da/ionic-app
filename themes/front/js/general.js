$(document).ready(function() {

$('.smallNav').click(function() {		 
  $('.menuBox').toggleClass('showMenu');
  $(this).toggleClass('closeNav');
});

$('.menuBox a, .logo, .minHeight, .wrapper, .footer').click(function() {		 
  $('.menuBox').removeClass('showMenu');
  $('.smallNav').removeClass('closeNav');
});

$('.backToTop, .homeTop').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
 });
 	
	
});


(function() {
	"use strict";
$(document).scroll(function() {
	if ($(document).scrollTop() >= $('.wrapper').offset().top - $(window).height()  + 600) {
	  $('.smallNav').addClass('menuYellow');
	  $('.logo').addClass('logoNone');
	} else {
	  $('.smallNav').removeClass('menuYellow');
	  $('.logo').removeClass('logoNone');
	}
	});
})(jQuery);
