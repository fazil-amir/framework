 AOS.init({
 	duration: 800,
 	easing: 'slide'
 });

(function($) {

	"use strict";

	$(window).stellar({
    responsive: true,
    parallaxBackgrounds: true,
    parallaxElements: true,
    horizontalScrolling: false,
    hideDistantElements: false,
    scrollProperty: 'scroll'
  });

	var fullHeight = function() {
		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});
	};
	fullHeight();

	// loader
	var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 1);
	};
	loader();

	// Scrollax
   $.Scrollax();

	var carousel = function() {
		$('.home-slider').owlCarousel({
			autoplayTimeout: 5000,
	    loop:true,
	    items: 1,
	    autoplay: true,
	    animateOut: 'fadeOut',
			animateIn: 'fadeIn',
			autoplayHoverPause: true,
		});
		
		$('.our-client-slider').owlCarousel({
			autoplay: true,
			center: false,
			loop: true,
			items:5,
			margin: 15,
			stagePadding: 0,
			nav: false,
			dots: false,
			responsive:{
				0:{
					items: 1
				},
				620:{
					items: 2
				},
				1000:{
					items: 4
				}
			}
		});

		$('.carousel-testimony').owlCarousel({
			autoplay: true,
			center: false,
			loop: true,
			items:1,
			margin: 30,
			stagePadding: 0,
			nav: false,
			navText: ['<span class="ion-ios-arrow-back">', '<span class="ion-ios-arrow-forward">'],
			responsive:{
				0:{
					items: 1
				},
				600:{
					items: 1
				},
				1000:{
					items: 2
				}
			}
		});

	};
	carousel();

	$('nav .dropdown').hover(function(){
		var $this = $(this);
		// 	 timer;
		// clearTimeout(timer);
		$this.addClass('show');
		$this.find('> a').attr('aria-expanded', true);
		// $this.find('.dropdown-menu').addClass('animated-fast fadeInUp show');
		$this.find('.dropdown-menu').addClass('show');
	}, function(){
		var $this = $(this);
			// timer;
		// timer = setTimeout(function(){
			$this.removeClass('show');
			$this.find('> a').attr('aria-expanded', false);
			// $this.find('.dropdown-menu').removeClass('animated-fast fadeInUp show');
			$this.find('.dropdown-menu').removeClass('show');
		// }, 100);
	});


	$('#dropdown04').on('show.bs.dropdown', function () {
	  //console.log('show');
	});

	// scroll
	var scrollWindow = function() {
		$(window).scroll(function(){
			var $w = $(this),
					st = $w.scrollTop(),
					navbar = $('.ftco_navbar'),
					sd = $('.js-scroll-wrap');

			if (st > 150) {
				if ( !navbar.hasClass('scrolled') ) {
					navbar.addClass('scrolled');	
				}
			} 
			if (st < 150) {
				if ( navbar.hasClass('scrolled') ) {
					navbar.removeClass('scrolled sleep');
				}
			} 
			if ( st > 350 ) {
				if ( !navbar.hasClass('awake') ) {
					navbar.addClass('awake');	
				}
				
				if(sd.length > 0) {
					sd.addClass('sleep');
				}
			}
			if ( st < 350 ) {
				if ( navbar.hasClass('awake') ) {
					navbar.removeClass('awake');
					navbar.addClass('sleep');
				}
				if(sd.length > 0) {
					sd.removeClass('sleep');
				}
			}
		});
	};
	scrollWindow();

	
	var counter = function() {
		
		$('#section-counter').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {

				var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
				$('.number').each(function(){
					var $this = $(this),
						num = $this.data('number');
						//console.log(num);
					$this.animateNumber(
					  {
					    number: num,
					    numberStep: comma_separator_number_step
					  }, 1000
					);
				});
				
			}

		} , { offset: '95%' } );

	}
	counter();

	var contentWayPoint = function() {
		var i = 0;
		$('.ftco-animate').waypoint( function( direction ) {

			if( direction === 'down' && !$(this.element).hasClass('ftco-animated') ) {
				
				i++;

				$(this.element).addClass('item-animate');
				setTimeout(function(){

					$('body .ftco-animate.item-animate').each(function(k){
						var el = $(this);
						setTimeout( function () {
							var effect = el.data('animate-effect');
							if ( effect === 'fadeIn') {
								el.addClass('fadeIn ftco-animated');
							} else if ( effect === 'fadeInLeft') {
								el.addClass('fadeInLeft ftco-animated');
							} else if ( effect === 'fadeInRight') {
								el.addClass('fadeInRight ftco-animated');
							} else {
								el.addClass('fadeInUp ftco-animated');
							}
							el.removeClass('item-animate');
						},  k * 50, 'easeInOutExpo' );
					});
					
				}, 100);
				
			}

		} , { offset: '95%' } );
	};
	contentWayPoint();


	// magnific popup
	$('.image-popup').magnificPopup({
    type: 'image',
    closeOnContentClick: true,
    closeBtnInside: false,
    fixedContentPos: true,
    mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
     gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1] // Will preload 0 - before current, and 1 after the current image
    },
    image: {
      verticalFit: true
    },
    zoom: {
      enabled: true,
      duration: 300 // don't foget to change the duration also in CSS
    }
  });

  $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
    disableOn: 700,
    type: 'iframe',
    mainClass: 'mfp-fade',
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false
  });


	$('#contact-form').on('submit', e => {
		e.preventDefault();
		var fullName = $('#name').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var subject = $('#subject').val() || 'N/A';
		var message = $('#message').val();

		$.ajax({
			type: "POST",
			url: baseURL('bridge/form-submissions/add'),
			data: {
				accessorName: 'CONTACT_US',
				fullName,
				email,
				subject,
				phone,
				pageURL: window.location.href,
				subData: JSON.stringify([
					{
						"caption": "message",
						"type": "DOUBLE",
						"data": message
					}
				])
			},
			success: (res) => {
				if(res.success) {
					$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#success-alert").slideUp(500);
					});
					$('#contact-form')[0].reset();
				} else {
					$("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#success-alert").slideUp(500);
					});
				}
				console.log(res)
			},
		});
	})

	$('#enquiry-form').on('submit', e => {
		e.preventDefault();
		var fullName = $('#name').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var message = $('#message').val();
		
		var subject = 'New Enquiry';
		
		var serviceName = $('#service-name').val();

		$.ajax({
			type: "POST",
			url: baseURL('bridge/form-submissions/add'),
			data: {
				accessorName: 'ENQUIRY',
				fullName,
				email,
				subject,
				phone,
				pageURL: window.location.href,
				subData: JSON.stringify([
					{
						"caption": "message",
						"type": "DOUBLE",
						"data": message
					},
					{
						"caption": "Service Name",
						"type": "SINGLE",
						"data": serviceName
					}
				])
			},
			success: (res) => {
				if(res.success) {
					$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#success-alert").slideUp(500);
					});
					$('#enquiry-form')[0].reset();
				} else {
					$("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
						$("#success-alert").slideUp(500);
					});
				}
			},
		});
	})


})(jQuery);

// $(".navbar-nav").slick({

// 	infinite: true,
//   slidesToShow: 3,
//   slidesToScroll: 3

// });