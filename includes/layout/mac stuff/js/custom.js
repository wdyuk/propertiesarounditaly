$(document).ready(function(){
    $('#banner-slider').owlCarousel({
        loop:true,
        nav:false,
        items:1,
        dots:true,
        responsiveClass:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
    });
	
    $('#accreditations-slider').owlCarousel({
        loop:true,
        nav:true,
        dots:false,
        responsiveClass:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1
            },
            767 :{
                items:2
            },
            1024:{
                items:3
            },
            1200 :{
                items:4
            }
        }
    });
	
    $('.project_slider').owlCarousel({
        loop:true,
        nav:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        items:1,
        dots:false,
        responsiveClass:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        autoHeight : true,
    });
    
	$('.news_slider').owlCarousel({
        loop:true,
        nav:true,
		navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        items:1,
        dots:false,
        responsiveClass:true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
		autoHeight : true,
    });
	
    // Add active to menu item
    var url = window.location.pathname, 
    urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); 
    $('ul.navbar-nav li > a').each(function(){
        if(urlRegExp.test(this.href.replace(/\/$/,''))){
            $(this).addClass('active');
        }
    });
	
});