// JavaScript Document

$(document).ready(function() {
    
    
    /***********************************
	** Menu Control
	***********************************/
	var menu_click = $(".menu-click");
	var menu = $("#menu-container");
	menu_click.on("click", function() {
		menu.toggleClass("open");
	});
		
		
		/***********************************
		** 1st Level Child Menu
		***********************************/
		// $(".nav-drawer .main-menu__item--has-child ul.main-menu__child-list-main-container").after("<span class=\"child-click\"><i class=\"fas fa-chevron-right\"></i></span>");
		// $(".nav-drawer .main-menu__item--has-child ul.main-menu__child-list-main-container li.main-menu__child-list-inner-container").before("<li class=\"child-click child-click-back main-menu__child-item\"><i class=\"fas fa-chevron-left\"></i></li>");
		
		var itemSpan = $(".child-click");
		var mobileItem = $(".child-mobile-click");
		var goBack = $(".child-click-back");
		var parentMenu = $("#menu-container .main-menu__list");

		itemSpan.on("click", function() {
			parentMenu.toggleClass("swiped");
			$(this).siblings(".main-menu__child-list-main-container").addClass("active");
		});

		mobileItem.on("click", function() {
			parentMenu.toggleClass("swiped");
			$(this).siblings(".main-menu__child-list-main-container").addClass("active");
		});

		goBack.on("click",function(){
			$(this).parent(".main-menu__child-list-main-container").removeClass("active");
		});
	
	/***********************************
	** Click to scroll to on-page anchor tag
	***********************************/
    var container = 'html, body';
    
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$(container).animate({
					scrollTop: target.offset().top
				}, 500);
				return false;
			}
		}
	});
	
    
	/***********************************
	** Element Slide-In Animations
	***********************************/
	$(function() {
		var $elements = $('.animateBlock.notAnimated'); //contains all elements of nonAnimated class
		var $window = $(window);
		
		$window.on('scroll', function(e) {
			$elements.each(function(i, elem) { //loop through each element
				if ($(this).hasClass('animated')) // check if already animated
				return;
				animateMe($(this));
			});			
		});
	});
	function animateMe(elem) {
		var winTop = $(window).scrollTop(); // calculate distance from top of window
		var winBottom = winTop + $(window).height();
		var elemTop = $(elem).offset().top; // element distance from top of page
		var elemBottom = elemTop + $(elem).height();

		if ((elemBottom <= winBottom) && (elemTop >= winTop)) {
			// exchange classes if element visible
			$(elem).removeClass('notAnimated').addClass('animated');
		}
	}
    
    
	/***********************************
	** Slideshow Control
	***********************************/
    $('.main-slider').slick({
		autoplay: true,
  		autoplaySpeed: 4000,
  		arrows: false,
  		lazyLoad: 'progressive',
  		dots: true
	});

    $('.home-page__hero__slider').slick({
		autoplay: true,
  		autoplaySpeed: 4000,
  		arrows: true,
  		lazyLoad: 'progressive',
  		dots: false
	});

	$('.meet-team__slider').slick({
		autoplay: true,
  		autoplaySpeed: 4000,
  		arrows: true,
  		dots: false,
  		lazyLoad: 'progressive',
	    slidesToShow: 1,
	    mobileFirst: true,
  		responsive: [{
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 3
	      }
	    }]
	});

	$('.testimonials__slider').slick({
		autoplay: true,
  		autoplaySpeed: 4000,
  		arrows: true,
  		dots: false,
  		lazyLoad: 'progressive',
	    slidesToShow: 1,
	    centerMode: true,
  		centerPadding: '50px',
	    slidesToShow: 1,
	    mobileFirst: true,
  		responsive: [{
	      breakpoint: 768,
	      settings: {
	        slidesToShow: 3
	      }
	    }]
	});

	$('.property-listing-page__slider--gallery').slick({
		autoplay: false,
  		autoplaySpeed: 4000,
  		lazyLoad: 'progressive',
  		arrows: true,
  		dots: true,
  		adaptiveHeight: true,
	});

	$('.property-listing-page__slider--floorplans').slick({
		autoplay: false,
  		autoplaySpeed: 4000,
  		lazyLoad: 'progressive',
  		arrows: true,
  		dots: true,
  		adaptiveHeight: true
	});
	
	// fixing the weird issue with slick slider in bootstrap tab content
	$('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
		$('.property-listing__slider').slick('setPosition');
	})
});