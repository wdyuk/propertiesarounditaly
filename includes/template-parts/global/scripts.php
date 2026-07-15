<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js?ver=2.2.4"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.2/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
<script type="text/javascript" src="/assets/js/main.js?v1.1"></script>

<script>
  $( function() {
    
    $('.home-page__hero__slider').on('init', function () {
       $('.home-page__hero__slider').fadeIn( "slow" );
    });
    $('.meet-team__slider').on('init', function () {
          $(this).fadeIn( "slow" );
      });
    $('.testimonials__slider').on('init', function () {
          $(this).fadeIn( "slow" );
      });
    $('.property-listing-page__slider--gallery').on('init', function () {
          $(this).fadeIn( "slow" );
      });
    $('.property-listing-page__slider--floorplans').on('init', function () {
          $(this).fadeIn( "slow" );
      });
     $('.home-page__hero .home-page__hero__bg-img.bg-img').show();
     $('.meet-team__member-img.bg-img').show();

  } );
</script>


