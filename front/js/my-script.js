// Slider Effect

$(document).ready(function(){
	var slider = $("#slider").carousel({
	aniMethod: 'auto',
	});
});


// Carousel Effect


$('.carousel').carousel({
        interval: 2000 //changes the speed
})


// Animate Header


var cbpAnimatedHeader = (function() {

	var docElem = document.documentElement,
		header = document.querySelector( '.navbar-inverse' ),
		didScroll = false,
		changeHeaderOn = 180;

	function init() {
		window.addEventListener( 'scroll', function( event ) {
			if( !didScroll ) {
				didScroll = true;
				setTimeout( scrollPage, 250 );
			}
		}, false );
	}

	function scrollPage() {
		var sy = scrollY();
		if ( sy >= changeHeaderOn ) {
			classie.add( header, 'navbar-shrink' );
		}
		else {
			classie.remove( header, 'navbar-shrink' );
		}
		didScroll = false;
	}

	function scrollY() {
		return window.pageYOffset || docElem.scrollTop;
	}

	init();

})();


// Owl Slider

$(document).ready(function() {
    $('.owl-carousel').owlCarousel({
    	loop: true,
        margin: 10,
		autoplay:true,
		autoplaySpeed:1000,
        responsiveClass: true,
        responsive: {
		  0: {
			items: 1,
			nav: true
		  },
		  600: {
			items: 3,
			nav: false
		  },
		  1000: {
			items: 4,
			nav: true,
			loop: false,
			margin: 20
        }
    	}
	})
})


// Back to Top

if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
