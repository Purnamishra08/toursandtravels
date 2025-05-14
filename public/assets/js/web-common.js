const popularTourSwiper = new Swiper('.popular-tour-swiper', {
    // Optional parameters
    slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    delay: 3000, 
    disableOnInteraction: false,
  },
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
  
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        
      },
      768: {
        slidesPerView: 2,
        
      },
      1025: {
        slidesPerView: 3,
        
      },
      1366: {
        slidesPerView: 4,
        
      },
    },
  });

  const clientreviewSwiper = new Swiper('.client-review-swiper', {
    // Optional parameters
    slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  // autoplay: {
  //   delay: 3000, 
  //   disableOnInteraction: false,
  // },
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        
      },
      768: {
        slidesPerView: 2,
        
      },
      
    },
  });


  // client review tour listing page
  const clientreviewSwiper2 = new Swiper('#tour-client-review-swiper', {
    // Optional parameters
    slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  // autoplay: {
  //   delay: 3000, 
  //   disableOnInteraction: false,
  // },
    // If we need pagination
    pagination: {
      el: '.swiper-pagination',
    },
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    // And if we need scrollbar
    scrollbar: {
      el: '.swiper-scrollbar',
    },
    breakpoints: {
      640: {
        slidesPerView: 1,
        
      },
      768: {
        slidesPerView: 2,
        
      },
      1366: {
        slidesPerView: 3,
        
      },
      
    },
  });
// --------scrill top start-------
  $(document).ready(function () {
    // Show/hide the back-to-top button based on scroll position
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
          $("#header").addClass("bg-header");
            $("#up").fadeIn();  // Show the button
        } else {
            $("#up").fadeOut(); // Hide the button
            $("#header").removeClass("bg-header");
        }
    });

    // Smooth scroll to top when the button is clicked
    $("#up").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 200); // Scroll to top
        return false;
    });
});

// --------scrill top end-------
// tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})