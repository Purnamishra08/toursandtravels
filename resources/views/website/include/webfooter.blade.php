<footer>
        <div class="top-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4">
                        <h1 class="mb-3">
                            <a href="">
                                <img src="{{ asset('assets/img/web-img/logo.png') }}" alt="logo" />
                            </a>
                                
                        </h1>
                        <!-- <p class="about-company">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Repellat delectus nobis quibusdam sed optio porro. Lorem ipsum,
                            dolor sit amet consectetur adipisicing elit.
                        </p> -->
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
                                <p>{{isset($parameters) ? $parameters[0]->par_value : ''}}</p></p>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="footer-title">Quick Links</h5>
                        <ul class="quick-link-wrapper">
                        @if(isset($footer) && count($footer) > 0)
                            @foreach($footer as $footers)
                                <li>
                                    <a href="{{$footers->vch_Footer_URL}}" class="quick-link">{{$footers->vch_Footer_Name}}</a>
                                </li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="footer-title">Blog Posts</h5>

                        <ul class="blog-spot-wrapper">
                        @if(isset($blogDataFooter) && count($blogDataFooter) > 0)
                            @foreach($blogDataFooter as $key => $values)
                            <li>
                                <img src="{{ asset('storage/blog_images/' . $values->image) }}" alt="blog spot" />
                                <a href="{{ route('website.blogdetails', ['slug' => $values->blog_url]) }}" class="blog-title stretched-link">{{$values->title}}</a>
                            </li>
                            @endforeach
                        @endif
                        </ul>
                    </div>
                </div>
            </div>
            <a href="javascript:void(0)" class="back-to-top" id="up">
                <i class="bi bi-chevron-up"></i>
            </a>
            <a href="https://api.whatsapp.com/send?phone=+919886525253&text=Hi%20there%2E" class="whats-app"><i class="bi bi-whatsapp"></i></a>
            <div class="google-review">
                <div class="wrapper">
                    <span class="review-close-btn"><i class="bi bi-x"></i></span>
                    <img src="{{ asset('assets/img/web-img/google-logo-png-transparent.png') }}" alt="logo" />
                    <h4>My Holiday Happiness </h4>
                    <span>  
                      
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>				
                    </span>
                    <br>
                    <span>1032 reviews</span>
                </div>


            </div>
        </div>
        <div class="bottom-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 order-last order-lg-2">
                        <ul class="social-link">
                            <li>
                                <a href="#"><i class="bi bi-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="bi bi-youtube"></i></a>
                            </li>
                            <li>Copyright © 2025 Tourism. All Rights Reserved</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 order-first order-lg-2">
                        <ul class="link-wrapper">
                            
                            <li><a href="#"> About Us</a></li>
                            <li><a href="../faq">Faq</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Booking Policy</a></li>
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
    integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('assets/js/web-common.js')}}"></script>
    <script>
        new WOW().init();
    </script>
    <script>
        $(document).ready(function(){
        $('.date').datepicker({
            format: 'dd-mm-yyyy',  // ✅ Correct format for Bootstrap Datepicker
            autoclose: true,       // ✅ Close when date is selected
            todayHighlight: true   // ✅ Highlight today's date
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