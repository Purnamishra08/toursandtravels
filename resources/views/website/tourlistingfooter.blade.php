@include('website.include.webmeta')
<!-- TOURLISTING SCHEMAS -->
@if (!request()->ajax())
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => [
        [
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Home",
            "item" => url('/')
        ],
        [
            "@type" => "ListItem",
            "position" => 2,
            "name" => "Tours",
            "item" => route('website.allTourPackages')
        ],
        [
            "@type" => "ListItem",
            "position" => 3,
            "name" => $footers->vch_Footer_Name,
            "item" => route('website.allTourPackagesFooter', ['slug' => $slug])
        ]
    ]
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>

{{-- Product Schemas (multiple) --}}
@foreach ($productSchemas as $productSchema)
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endforeach
{{-- faq Schema --}}
<script type="application/ld+json">
{!! json_encode($faqSchemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@endif
@include('website.include.webheader')

<div class="breadcrumb-section">
    <img
        src="{{ asset('storage/category_tags_images/BannerImages/' . $tourPageData->menutag_img) }}"
        width="1920"
        height="250"
        fetchpriority="high"
        decoding="async"
       style="object-fit: cover; width: 100%; height: 100%; position: absolute; z-index: -1;"
    >
    <div class="container" style="padding-bottom: 2rem">
        <h1 class="page-name">{{$footers->vch_Footer_Name}}</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('website.allTourPackages')}}" class="breadcrumb-link">Tours</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('website.allTourPackagesFooter', ['slug' => $slug]) }}" class="breadcrumb-link active">{{ $footers->vch_Footer_Name }}</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>
                    <!-- <p class="section-title-small">Feature tours</p> -->
                    <h2 class="section-title"> Most Popular {{$footers->vch_Footer_Name}}</h2>
                </div>
            </div>
            <div class="about-content mb-3 thin-scroll">
                <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                    <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 40px;background: linear-gradient(to bottom, rgb(252 252 252 / 64%), #ffffff);"></div>
                    <div class="description-full">
                        {!! $footers->vch_Footer_Desc !!}
                    </div>
                </div>

            </div>
            <button class="moreless-button mb-3"
                style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500; border:0">
                Read more <span style="margin-left: 5px;">&#x25BC;</span>
            </button>
        </div>
        <div class="tour-filter-section">
            <div class="container">

                <span class="filter-btn btn btn-sm btn-dark"><i class="bi bi-funnel me-2"></i>Filter</span>
            </div>
        </div>
        <div class="container">

            <div class="tour-list-wrapper">
                <div class="filter-overlay"></div>
                <div class="filter-wrapper">
                    <div class="filter-card stickey-section">
                        <div class="filter-card-header ">
                            <h3>Filter</h3>
                            <span class="badge text-bg-warning clear-filter" style="cursor:pointer;">Clear All</span>
                        </div>
                        <div class="filter-card-body">
                            <strong class="mb-2 d-block">Duration</strong>
                            <div class="mb-3">
                                @foreach($durations as $duration)
                                <div class="form-check">
                                    <input class="form-check-input filter-option" type="checkbox" name="duration[]" id="duration_{{$duration->durationid}}" value="{{$duration->durationid}}">
                                    <label class="form-check-label" for="duration_{{$duration->durationid}}">{{$duration->duration_name}}</label>
                                </div>
                                @endforeach
                            </div>
                            <strong class="mb-2 d-block">Starting City</strong>
                            <div class="mb-3">
                                @foreach($destinations as $destination)
                                <div class="form-check">
                                    <input class="form-check-input filter-option" type="checkbox" name="starting_city[]" id="starting_city_{{$destination->destination_id}}" value="{{$destination->destination_id}}">
                                    <label class="form-check-label" for="starting_city_{{$destination->destination_id}}">{{$destination->destination_name}}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div id="allTour">
                </div>
            </div>
        </div>
    </section>


    <section class="bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h4 class="section-title-sm mb-0">Frequently Asked Questions</h4>
                        </div>
                        <form action="{{ route('website.faqs', ['slug' => 'package-faqs']) }}" method="POST" target="_blank" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="2">
                            <input type="hidden" name="tag_id" value="{{$footers->int_footer_id}}">
                            <button type="submit" class="btn btn-primary">
                                View all <i class="ms-2 bi bi-arrow-right-short"></i>
                            </button>
                        </form>
                    </div>
                    @if($tourFaqs->count())
                        <div class="accordion faq-accordion" id="accordionExample">
                            @foreach($tourFaqs as $index => $faq)
                            <div class="accordion-item">
                                <h4 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                       {{ $faq->faq_question }}
                                    </button>
                                </h4>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $faq->faq_answer !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <p>No FAQs available for this tour.</p>
                        @endif
                </div>
                <div class="col-lg-6">
                    <div class=" ">
                        <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                            <div>
                                <h2 class="section-title-sm">Verified Google Reviews</h2>
                            </div>
                            <a href="{{route('website.allreview')}}" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="review-wrapper thin-scroll">
                            @foreach($reviews as $review)
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">{{$review->reviewer_name}}</p>
                                                <div class="rate">
                                                    @php
                                                    // Star rating generation
                                                    $full = floor($review->no_of_star);
                                                    $half = (fmod($review->no_of_star, 1) != 0.00) ? 1 : 0;
                                                    $emptyStars = 5 - ($full + $half);

                                                    $starsreviewHtml = '';
                                                    for ($i = 0; $i < $full; $i++)
                                                        {
                                                        $starsreviewHtml .='<i class="fa fa-star text-warning"></i> ' ;
                                                        }
                                                        if ($half) {
                                                        $starsreviewHtml .='<i class="fa fa-star-half-stroke text-warning"></i> ' ;
                                                        }
                                                        for ($i=0; $i < $emptyStars; $i++) {
                                                        $starsreviewHtml.='<i class="fa fa-star text-secondary"></i> ' ;
                                                        }
                                                        @endphp

                                                        {!! $starsreviewHtml !!}
                                                        </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> {{$review->reviewer_loc}}</p>



                                        </div>
                                        <p class="clent-message"> {{$review->feedback_msg}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 rounded border mt-3 text-center bg-success-subtle text-success-emphasis">
                        <srtong class="d-block mb-2">Still have Questions</strong>
                        <span class="d-block mb-2">Can't find the answar you are looking for?</span>
                        <a class="btn btn-warning" href="{{route('website.contactus')}}">Contact Us</a>

                    </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="section-title-container justify-content-center wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                <div class="d-flex justify-content-center align-items-center flex-wrap gap-2 mb-3">
                    <h2 class="section-title-sm mb-0">What Our Travelers Says</h2>
                </div>
            </div>
            <div id="tour-client-review-swiper" class="swiper  client-review-swiper wow animate__fadeInUp swiper-initialized swiper-horizontal swiper-backface-hidden" data-wow-delay="600ms" style="visibility: visible; animation-delay: 600ms; animation-name: fadeInUp;">
                <div class="swiper-wrapper" id="client-reviews" aria-live="polite">

                    
                </div>
                <div class="position-relative swiper-btn-container">
                    <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="client-reviews">
                        <i class="bi bi-arrow-left-short"></i>
                    </div>
                    <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="client-reviews">
                        <i class="bi bi-arrow-right-short"></i>
                    </div>
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
        </div>
    </section>
    <!-- <section class="bg-light">
        <div class="container">
            <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h2 class="section-title-sm mb-0">About Coorg Tour Package</h2>
                </div>
            </div>
            <div class="about-content mb-3 thin-scroll">
                <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                    <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 40px;background: linear-gradient(to bottom, rgb(252 252 252 / 52%), #f8f8f8)"></div>
                    <div class="description-full">
                        {!! $tourPageData->about_tag !!}
                    </div>
                </div>
            </div>
            <button class="moreless-button-about"
                style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500;border:0">
                Read more <span style="margin-left: 5px;">&#x25BC;</span>
            </button>
        </div>
    </section> -->

</div>
@include('website.include.webfooter')

<script>
    var page = 1;
    var isLoading = false;
    var finished = false;

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

    function loadPopularTour(page) {
        if (finished) return;
        let slug = "{{ $footers->vch_Footer_URL }}";
        let pageUrl = `${slug}?page=${page}`;
        $.ajax({
            url: pageUrl,
            type: "get",
            beforeSend: function() {
                $('.ajax-load').show();
            }
        }).done(function(data) {
            if (data.trim().length == 0) {
                $('.ajax-load').html("<p>No more records found</p>");
                finished = true;
                return;
            }
            $('.ajax-load').hide();
            $('#allTour').append(data);
            isLoading = false;
        }).fail(function() {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    // Initial load
    $(document).ready(function() {
        loadPopularTour(page);
        loadClientReviews(page);
    });

    function applyFilters() {
        let durations = [];
        let startingCities = [];

        // Collect selected durations
        $('input[name="duration[]"]:checked').each(function() {
            durations.push($(this).val());
        });

        // Collect selected starting cities
        $('input[name="starting_city[]"]:checked').each(function() {
            startingCities.push($(this).val());
        });

        let slug = "{{ $footers->vch_Footer_URL }}";
        let pageUrl = `/coorg-packages/tours/${slug}`;
        $.ajax({
            url: slug,
            type: "get",
            data: {
                durations: durations,
                startingCities: startingCities,
            },
            beforeSend: function() {
                $('#allTour').html('<div class="text-center p-4">Loading...</div>');
            },
            success: function(data) {
                $('#allTour').html(data);
            }
        });
    }

    // Re-trigger filtering on change
    $(document).on('change', '.filter-option', function() {
        applyFilters();
    });
    $(document).on('click', '.clear-filter', function() {
        $('.filter-option').prop('checked', false);
        applyFilters(); // re-fetch all
    });
</script>
<script>
    $('.moreless-button-about').click(function () {
        // Get the .about-content above the button
        const preview = $(this).prev('.about-content').find('.description-preview');

        // Toggle expand state
        preview.toggleClass('expanded');
        preview.find('.fade-overlay').toggleClass('d-none');

        // Update styles and button text
        if (preview.hasClass('expanded')) {
            preview.css('max-height', 'none');
            $(this).html('Read less <span style="margin-left: 5px;">&#9650;</span>');
        } else {
            preview.css('max-height', '200px');
            $(this).html('Read more <span style="margin-left: 5px;">&#9660;</span>');
        }
    });

    $('.moreless-button').click(function () {
        const preview = $('.about-content .description-preview'); // access inside content

        preview.toggleClass('expanded');
        preview.find('.fade-overlay').toggleClass('d-none');

        if (preview.hasClass('expanded')) {
            preview.css('max-height', 'none');
            $(this).html('Read less <span style="margin-left: 5px;">&#9650;</span>');
        } else {
            preview.css('max-height', '200px');
            $(this).html('Read more <span style="margin-left: 5px;">&#9660;</span>');
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.filter-btn').on('click', function() {
            $('.filter-wrapper').toggleClass('active');
            $('.filter-overlay').toggleClass('active');
        });

        // Optional: hide filter when clicking outside
        $('.filter-overlay').on('click', function() {
            $(this).removeClass('active');
            $('.filter-wrapper').removeClass('active');
        });
    });
</script>