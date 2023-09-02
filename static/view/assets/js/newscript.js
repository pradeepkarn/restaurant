$(document).ready(function() {
    var owl_load1 = $('#owl_load-1');
    owl_load1.owlCarousel({
        margin:20,
        loop:true,
        autoplay: true,
        autoplayTimeout:2000,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 1
          },
          1000: {
            items:1
          },
          1200: {
            items:1
          },
          1300: {
            items:1
          }
        }
    });
  });