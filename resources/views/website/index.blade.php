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
<!-- Popular Tours -->
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">

            <div>
                <!-- <p class="section-title-small">Feature tours</p> -->
                <h2 class="section-title">Most Popular Tour</h2>
            </div>
            <a href="{{route('website.allTourPackages')}}" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
        </div>
        <div class="card-wrapper" id="popular-tour">
        </div>
    </div>
</section>
<!-- Popular Tours -->
<!-- Top Destination Place -->
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
            <div>
                <!-- <p class="section-title-small">Destination Lists</p> -->
                <h2 class="section-title section-title-large">
                    TOP DESTINATION PLACES
                </h2>
            </div>

        </div>
        <div class="gallery-container wow animate__fadeInUp  " data-wow-delay="600ms" id="top-destination">
            
            <!-- <div class="gallery-item">
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
            </div> -->
        </div>
    </div>
</section>
<!-- Top Destination Place -->
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
            <div class="swiper-wrapper" id="client-reviews">
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
            url: "{{ route('website.blogsHome') }}?page=" + page,
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

    function loadPopularTour(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTour') }}?page=" + page,
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
            $('#popular-tour').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    function loadDestinationPlaces(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.destinationPlaces') }}?page=" + page,
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
            $('#top-destination').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    function loadClientReviews(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.clientReviews') }}?page=" + page,
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
            $('#client-reviews').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    // Initial load
    $(document).ready(function () {
        loadPopularTour(page);
        loadDestinationPlaces(page);
        loadClientReviews(page);
        loadMoreData(page);
    });
</script>