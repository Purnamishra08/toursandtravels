<footer>
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <span class="mb-3">
                        <a href="" class="navbar-brand">
                            <img src="{{ asset('assets/img/mhh-logo.webp') }}" alt="logo" width="152" height="60"/>
                        </a>

                    </span>
                    <ul class="contact-wrapper">
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:{{isset($parameters) ? $parameters[2]->par_value : ''}}">{{isset($parameters) ? $parameters[2]->par_value : ''}}</a>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:{{isset($parameters) ? $parameters[3]->par_value : ''}}">{{isset($parameters) ? $parameters[3]->par_value : ''}}</a>
                        </li>
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <p>{{isset($parameters) ? $parameters[0]->par_value : ''}}</p>
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="quick-link-wrapper">
                        @if(isset($footer) && count($footer) > 0)
                        @foreach($footer as $footers)
                            <li><a href="{{ route('website.allTourPackagesFooter', ['slug' => $footers->vch_Footer_URL]) }}"    class="quick-link">{{ $footers->vch_Footer_Name }}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h4 class="footer-title">Best Tours Packages</h4>
                    <ul class="quick-link-wrapper">
                        @if(isset($bestTourPackages) && count($bestTourPackages) > 0)
                        @foreach($bestTourPackages as $bestTourPackage)
                            <li>
                                <a href="{{route('website.tourDetails', ['slug' => $bestTourPackage->tpackage_url])}}" class="quick-link">{{$bestTourPackage->tpackage_name}}</a>
                            </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-lg-2">
                <h4 class="footer-title">Featured In</h4>
                    <ul class="featured_in_wrapper p-0 mb-0 mt-2 ">
                        <li>
                            <a href="https://raindrops-insider.beehiiv.com/p/how-yellosa-khoday-is-providing-one-click-holiday-solutions-with-his-startup-my-holiday-happiness">
                                <img loading="lazy" class="featured-img" src="{{ asset('assets/img/web-img/timesnext-logo.webp') }}" alt="TimesNext" width="200" height="45"/>
                            </a>
                        </li>
                        <li>
                            <a href="https://startup.siliconindia.com/vendor/my-holiday-happiness-innovating-the-future-of-tourism-while-prioritizing-customer-satisfaction-cid-20513.html">
                                <img loading="lazy" class="featured-img" src="{{ asset('assets/img/web-img/startupcity-logo.webp') }}" alt="Silicon india startup cty" width="112" height="45" />
                            </a>
                        </li>
                        <li>
                            <a href="https://corporateconnectglobal.com/category/impact-recognition-indias-highly-trusted-tours-travels-agency-to-watchout-2024/">
                                <img loading="lazy" class="featured-img" src="{{ asset('assets/img/web-img/corporateconnectglobal.webp') }}" alt="Corporate connect"  width="197" height="45"/>
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
        <button type="button" class="back-to-top" id="up" aria-label="Back to top">
            <i class="bi bi-chevron-up"></i>
        </button>

        <a href="https://api.whatsapp.com/send?phone=+919886525253&text=Hi%20there%2E" target="_blank" class="whats-app" aria-label="Chat with us on WhatsApp"><i class="bi bi-whatsapp" aria-hidden="true"></i></a>
        <div class="only-desktop">
            <div class="google-review">
                <div class="wrapper">
                    <span class="review-close-btn"><i class="bi bi-x"></i></span>
                    <a href="https://www.google.com/search?q=myholidayhappiness&oq=myholidayhappiness&aqs=chrome..69i57j35i39j0j69i59j69i60l2j69i61j69i60.4919j0j4&sourceid=chrome&ie=UTF-8#mpd=~11124030801083900310/customers/reviews" target="_blank" style="text-decoration: none; color: inherit;">
                        <img loading="lazy" src="{{ asset('assets/img/web-img/google-logo-png-transparent.webp') }}" alt="logo" width="60" height="60"/>
                        <h4>My Holiday Happiness </h4>
                        @php
                            $rating = 0;

                            if (isset($parameters[8]) && isset($parameters[8]->par_value) && is_numeric($parameters[8]->par_value)) {
                                $rating = (float) $parameters[8]->par_value;
                            }

                            $fullStars = floor($rating);
                            $halfStar = ($rating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                        @endphp

                        {{-- Output the stars --}}
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="bi bi-star-fill text-warning"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="bi bi-star-half text-warning"></i>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="bi bi-star text-warning"></i>
                        @endfor

                        @if($rating > 0)
                            <span>({{ number_format($rating, 1) }})</span>
                        @endif
                        <br>
                        <span>{{isset($parameters) ? $parameters[9]->par_value : ''}} reviews</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 order-last order-lg-2">
                    <ul class="social-link">
                    <li><a href="#" title="Facebook" target="_blank" data-toggle="tooltip" > <i class="bi bi-facebook"></i></a></li>
                                <li><a href="#" title="Twitter" target="_blank" data-toggle="tooltip"> <i class="bi bi-twitter-x"></i></a></li>
                                <li><a href="#" title="Google+" target="_blank"  data-toggle="tooltip"> <i class="bi bi-google"></i></a></li>
                                <li><a href="#" title="LinkedIn" target="_blank" data-toggle="tooltip"> <i class="bi bi-linkedin"></i></a></li>

                        <li>Copyright © {{date('Y')}} Tourism. All Rights Reserved</li>
                    </ul>
                </div>
                <div class="col-lg-6 order-first order-lg-2">
                    <ul class="link-wrapper">

                        <li><a href="{{route('website.about-us')}}"> About Us</a></li>
                        <li><a href="{{route('website.faqs', ['slug' => 'common-faqs'])}}">FAQs</a></li>
                        <li><a href="{{route('website.privacy-policy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('website.term-condition')}}">Terms & Conditions</a></li>
                        <li><a href="{{route('website.booking-policy')}}">Booking Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
    integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{asset('assets/js/web-common.js')}}"></script>
<script>
    new WOW().init();
</script>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
  const swiperEl = document.querySelector('.swiper');
  if (!swiperEl || typeof Swiper === 'undefined') return;

  const initSwiper = () => {
    const slideCount = swiperEl.querySelectorAll('.swiper-slide').length;
    const slidesPerView = 2;
    const shouldLoop = slideCount > slidesPerView;

    new Swiper('.swiper', {
      loop: shouldLoop,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      autoplay: {
        delay: 4000
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
    //   slidesPerView: slidesPerView
    });
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        initSwiper();
        observer.disconnect();
      }
    });
  }, {
    rootMargin: '200px'
  });

  observer.observe(swiperEl);
    });
</script> -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const swiperEl = document.querySelector('.swiper');
  if (!swiperEl) return;

  const loadScript = (src) => {
    return new Promise((resolve, reject) => {
      const script = document.createElement('script');
      script.src = src;
      script.onload = resolve;
      script.onerror = reject;
      document.body.appendChild(script);
    });
  };

  const loadStyle = (href) => {
    return new Promise((resolve, reject) => {
      const link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = href;
      link.onload = resolve;
      link.onerror = reject;
      document.head.appendChild(link);
    });
  };

  const initSwiper = () => {
    const slideCount = swiperEl.querySelectorAll('.swiper-slide').length;
    const slidesPerView = 2;
    const shouldLoop = slideCount > slidesPerView;

    new Swiper('.swiper', {
      loop: shouldLoop,
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      },
      autoplay: {
        delay: 4000
      },
      breakpoints: {
        640: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1025: { slidesPerView: 2 },
        1366: { slidesPerView: 2 },
      }
    });
  };

  const observer = new IntersectionObserver(async (entries, observer) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        await Promise.all([
          loadStyle('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'),
          loadScript('https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js')
        ]);
        initSwiper();
        observer.disconnect();
      }
    }
  }, { rootMargin: '200px' });

  observer.observe(swiperEl);
});
</script>

<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: 'dd-mm-yyyy', // ✅ Correct format for Bootstrap Datepicker
            autoclose: true, // ✅ Close when date is selected
            todayHighlight: true // ✅ Highlight today's date
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Show the review section on page load
        $(".google-review").fadeIn();

        // Hide the review section when close button is clicked
        $(".review-close-btn").click(function() {
            $(".google-review").fadeOut();
        });
    });
</script>
</body>

</html>