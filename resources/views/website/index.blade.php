@include('website.include.webmeta')
<!-- Organization Schema -->
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "name" => "Coorg Packages",
    "url" => url('/'),
    "logo" => "https://coorgpackages.com/assets/img/mhh-logo.png",
    "email" => $parameters[3]->par_value ?? "support@coorgpackages.com",
    "contactPoint" => [
        "@type" => "ContactPoint",
        "telephone" => $parameters[2]->par_value ?? "+91 9886 52 52 53",
        "contactType" => "Customer Service",
        "areaServed" => "IN",
        "availableLanguage" => ["English", "Hindi", "Kannada"]
    ],
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "#69 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar",
        "addressLocality" => "Bengaluru",
        "addressRegion" => "Karnataka",
        "postalCode" => "560010",
        "addressCountry" => "IN"
    ],
    "sameAs" => array_filter([
        $parameters[14]->par_value ?? null,
        $parameters[15]->par_value ?? null,
        $parameters[16]->par_value ?? null
    ])
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>

<!-- WebPage Schema -->
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "WebPage",
    "name" => $meta_title ?? 'Coorg Packages',
    "url" => url('/'),
    "description" => $meta_description ?? 'Plan your trip to Coorg with affordable tour packages.',
    "keywords" => $meta_keywords ?? "",
    "inLanguage" => "en"
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@include('website.include.webheader')

<!-- banner-section start -->
<div class="banner-section">

    <!-- Video Background -->
    <!-- <video id="heroVideo" autoplay muted loop playsinline class="video-background">
        <source src="{{ asset('assets/img/web-img/banner-video.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
<div class="overlay"></div> -->
<div class="overlay"></div>
    <div class="banner-content wow animate__fadeInUp  " data-wow-delay="200ms">
        <h1>Best Coorg Tour Packages – Explore the Scotland of India</h1>
        <p>Discover misty hills, coffee plantations, waterfalls, and unforgettable experiences in Coorg.</p>
    </div>
</div>
<section>
    <div class="container">
        <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">

            <div>
                <!-- <p class="section-title-small">Feature tours</p> -->
                <h2 class="section-title">Most Popular {{isset($destinationName) ? $destinationName->destination_name : ''}} Tour Packages</h2>
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
                    TOP {{isset($destinationName) ? strtoupper($destinationName->destination_name) : ''}} DESTINATION PLACES
                </h2>
            </div>
        </div>
        <div class="gallery-container wow animate__fadeInUp  " data-wow-delay="600ms" id="top-destination">
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
            <a href="{{route('website.allreview')}}" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
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