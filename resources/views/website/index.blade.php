@include('website.include.webmeta')
@include('website.include.webheader')

<!-- banner-section start -->
<div class="banner-section">
    <div class="banner-content wow animate__fadeInUp  " data-wow-delay="200ms">
        <h1>Travel & Adventures</h1>
        <p>Where Would You Like To Go?</p>
    </div>
</div>
<!-- popular tour start -->
<!-- <section>
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  "  data-wow-delay="200ms">
                <div>
                    <p class="section-title-small">Feature tours</p>
                    <h2 class="section-title">Most Popular Tour</h2>
                </div>
                <a href="#" class=" btn btn-outline-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
            </div>
            <div class="swiper popular-tour-swiper wow animate__fadeInUp  "  data-wow-delay="400ms">
                <div class="swiper-wrapper px-1">
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card popular-tour-card">
                        <img src="{{ asset('assets/img/web-img/card-img-1.png') }}" alt="img" />
                           
                        <div class="tour-details">
                            <small>3 Days</small>
                            <small>12+</small>
                            <small>Los Angeles</small>
                        </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating" />
                                    <span class="text-secondary">8.0 Superb</span>
                                </div>
                                <h5 class="card-title">Forest Adventure</h5>
                                <div class="price d-flex align-items-center gap-1">
                                    <span>$1870 </span> <small>/ Per Person</small>
                                   
                                </div>
                                <a href="#" class=" btn btn-warning d-block">view-Details</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section> -->
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">

            <div>
                <p class="section-title-small">Feature tours</p>
                <h2 class="section-title">Most Popular Tour</h2>
            </div>
            <a href="../tourdetails" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
        </div>
        <div class="card-wrapper">
            <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-2.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
            <div class="card tour-card  wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-21.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
            <div class="card tour-card wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-22.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
            <div class="card tour-card wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-23.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
            <div class="card tour-card wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-24.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
            <div class="card tour-card wow animate__fadeInUp  " data-wow-delay="200ms">

                <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-25.png') }}" alt="img">
                <div class="card-body">
                    <p class="card-lavel">
                        <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                    </p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="p-card-info">
                            <span>From</span>
                            <h6>$91.00 <span>Per Person</span></h6>
                        </div>
                        <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- gallery start -->
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
            <div>
                <p class="section-title-small">Destination lists</p>
                <h2 class="section-title section-title-large">
                    TOP DESTINATION PLACES
                </h2>
            </div>

        </div>
        <div class="gallery-container wow animate__fadeInUp  " data-wow-delay="600ms">
            <div class="gallery-item">
                <img src="{{ asset('assets/img/web-img/destination-1.png.png') }}" alt="Spain" />
                <div class="gallery-text">Spain</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/img/web-img/destination-2.png.png') }}" alt="Thailand" />
                <div class="gallery-text">Thailand</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/img/web-img/destination-3.png.png') }}" alt="Africa" />
                <div class="gallery-text">Africa</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/img/web-img/destination-4.png.png') }}" alt="Australia" />
                <div class="gallery-text">Australia</div>
            </div>
            <div class="gallery-item">
                <img src="{{ asset('assets/img/web-img/destination-5.png.png') }}" alt="Switzerland" />
                <div class="gallery-text">Switzerland</div>
            </div>
        </div>
    </div>
</section>

<!-- client review start -->
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
            <div>
                <p class="section-title-small">CHECKOUT WHAT OUR CLIENT’S SAY</p>
                <h2 class="section-title section-title-large">CLIENT REVIEW</h2>
            </div>
            <a href="#" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
        </div>
        <div class="swiper client-review-swiper wow animate__fadeInUp  " data-wow-delay="600ms">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="card client-review-card">
                        <div class="card-body">
                            <div class="client-details mb-2">
                                <div class="client-img-box">
                                    <img src="{{ asset('assets/img/web-img/client-2.jpg') }}" alt="img" />

                                </div>
                                <div>
                                    <p class="client-name">Rohan Agarwal</p>
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" checked name="rate" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </div>
                            <p class="clent-message">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Totam assumenda deleniti nobis error natus maiores, dolores
                                voluptates quas ducimus veniam necessitatibus quos ea quam
                                velit inventore asperiores aperiam esse, magni voluptatibus
                                odit eos libero. Exercitationem pariatur rerum ea libero
                                optio.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card client-review-card">
                        <div class="card-body">
                            <div class="client-details mb-2">
                                <div class="client-img-box">
                                    <img src="{{ asset('assets/img/web-img/client-2.jpg') }}" alt="img" />
                                </div>
                                <div>
                                    <p class="client-name">Purna Chandra Mishra</p>
                                    <div class="rate">
                                        <input type="radio" id="star5" name="rate" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="text" checked>3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </div>
                            <p class="clent-message">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Totam assumenda deleniti nobis error natus maiores, dolores
                                voluptates quas ducimus veniam necessitatibus quos ea quam
                                velit inventore asperiores aperiam esse, magni voluptatibus
                                odit eos libero. Exercitationem pariatur rerum ea libero
                                optio.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="card client-review-card">
                        <div class="card-body">
                            <div class="client-details mb-2">
                                <div class="client-img-box">
                                    <img src="{{ asset('assets/img/web-img/client-1.webp') }}" alt="img" />
                                </div>
                                <div>
                                    <p class="client-name">Suman Sharma</p>
                                    <div class="rate">
                                        <input type="radio" id="star5" checked name="rate" value="5" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rate" value="4" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rate" value="3" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rate" value="2" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rate" value="1" />
                                        <label for="star1" title="text">1 star</label>
                                    </div>
                                </div>
                            </div>
                            <p class="clent-message">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                Totam assumenda deleniti nobis error natus maiores, dolores
                                voluptates quas ducimus veniam necessitatibus quos ea quam
                                velit inventore asperiores aperiam esse, magni voluptatibus
                                odit eos libero. Exercitationem pariatur rerum ea libero
                                optio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-relative swiper-btn-container">
                <div class="swiper-button-prev">
                    <i class="bi bi-arrow-left-short"></i>
                </div>
                <div class="swiper-button-next">
                    <i class="bi bi-arrow-right-short"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
            <div>
                <p class="section-title-small">FROM OUR BLOG</p>
                <h2 class="section-title section-title-large">OUR RECENT POSTS</h2>
            </div>
            <a href="{{route('website.bloglisting')}}" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>

        </div>
        <div class="recent-post-wrapper" id="post-data">
        </div>
    </div>
</section>
@include('website.include.webfooter')
<script>
    var page = 1;
    var isLoading = false;
    var finished = false;

    function loadMoreData(page) {
        if (finished) return;

        $.ajax({
            url: "{{ route('website.bloglisting') }}?page=" + page,
            type: "get",
            beforeSend: function () {
                $('.ajax-load').show();
            }
        }).done(function (data) {
            if (data.trim().length == 0) {
                $('.ajax-load').html("<p>No more records found</p>");
                finished = true;
                return;
            }
            $('.ajax-load').hide();
            $('#post-data').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    // Initial load
    $(document).ready(function () {
        loadMoreData(page);
    });
</script>