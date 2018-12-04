
// SMOOTH SCROLL FOR YELLOW SEARCH BTN
$(document).ready(function(){
	$('a[href^="#"]').on('click',function (e) {
	    e.preventDefault();

	    var target = this.hash;
	    var $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});

	console.log('worked');
});

// JS Navbar onscroll change bg color

$(function () {
  $(document).scroll(function () {
    var $nav = $(".navbar-fixed-top");
    console.log('triggered')
    $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
  });

});