@include('website.include.webmeta')
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
        ]
    ]
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>
@foreach ($productSchemas as $productSchema)
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endforeach
<script type="application/ld+json">
{!! json_encode($faqSchemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "hasPart": [
    @foreach($footer as $index => $values)
      {
        "name": "{{ $values->vch_Footer_Name ?? 'Coorg Packages' }}",
        "url": "{{ route('website.allTourPackagesFooter', ['slug' => $values->vch_Footer_URL]) }}",
        "description": "{{ $values->footer_meta_description ?? 'Plan your trip to Coorg with affordable tour packages.' }}",
        "keywords": "{{ $values->footer_meta_keywords ?? 'coorg packages,coorg tour packages' }}",
        "inLanguage": "en"
      }@if (!$loop->last),@endif
    @endforeach
  ]
}
</script>

@endif
@include('website.include.webheader')
@if($tourPageData->menutag_img)
<link rel="preload" as="image" href="{{ asset('storage/category_tags_images/BannerImages/' . $tourPageData->menutag_img) }}" type="image/webp">
@endif

<div class="breadcrumb-section" style="background-image: url('{{ asset('storage/category_tags_images/BannerImages/' . $tourPageData->menutag_img) }}');">
    <div class="container">
        <h1 class="page-name">{{$tourCount}} {{$tourPageData->tag_name}}</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link" aria-label="Home"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('website.allTourPackages')}}" class="breadcrumb-link active" aria-label="Tours">Tours</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>
                    <h2 class="section-title"> Most Popular {{$tourPageData->tag_name}}</h2>
                </div>
            </div>

            <div class="about-content mb-3 thin-scroll">
                <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                    <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 40px;background: linear-gradient(to bottom, rgb(252 252 252 / 64%), #ffffff);"></div>
                    <div class="description-full">
                        {!! $tourPageData->description_tag !!}
                    </div>
                </div>

            </div>
            <button class="moreless-button mb-3"
                style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500; border:0">
                Read more <span style="margin-left: 5px;">&#x25BC;</span>
            </button>

            <!-- Mobile Filter Button -->
            <div class="tour-filter-section d-block d-lg-none mb-4">
                <button class="filter-btn btn btn-sm btn-dark">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
            </div>
        </div>
        
        <div class="container">
            <div class="row">
                <!-- Filter Column -->
                <div class="col-lg-3 mb-4 mb-lg-0 tour-list-wrapper">
                <div class="filter-wrapper">
                        <div class="filter-card stickey-section">
                        <div class="filter-card-header ">
                            <strong>Filter</strong>
                            <span class="badge text-bg-warning clear-filter" style="cursor:pointer;">Clear All</span>
                                <span class="close-filter d-lg-none"><i class="bi bi-x-lg"></i></span>
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
                </div>
                
                <!-- Tour Listing Column -->
                <div class="col-lg-9">
                    <div id="allTour" class="row"></div>
                    <div class="ajax-load text-center my-4" style="display:none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading more tours...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="bg-light">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h4 class="section-title-sm mb-0">Frequently Asked Questions</h4>
                        </div>
                        <form action="{{ route('website.faqs', ['slug' => 'package-faqs']) }}" method="POST" target="_blank" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="1">
                            <input type="hidden" name="tag_id" value="{{$tourPageData->tagid}}">
                            <button type="submit" class="btn btn-primary">
                                View all <i class="ms-2 bi bi-arrow-right-short"></i>
                            </button>
                        </form>
                    </div>
                    @if($tourFaqs->count())
                        <div class="accordion faq-accordion" id="accordionExample">
                            @foreach($tourFaqs as $index => $faq)
                            <div class="accordion-item">
                                <h5 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                        <h6>{{ $faq->faq_question }}</h6>
                                    </button>
                                </h5>
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
                        <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms">
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
                                                        $starsreviewHtml .='<span class="text-warning">★</span>' ;
                                                        }
                                                        if ($half) {
                                                        $starsreviewHtml .='<span class="text-warning">⯨</span> ' ;
                                                        }
                                                        for ($i=0; $i < $emptyStars; $i++) {
                                                        $starsreviewHtml.='<span class="text-warning">☆</span> ' ;
                                                        }
                                                        @endphp

                                                        {!! $starsreviewHtml !!}
                                                        </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><i class="fa-solid fa-location-dot"></i>  {{$review->reviewer_loc}}</p>



                                        </div>
                                        <p class="clent-message"> {{$review->feedback_msg}}</p>
                                    </div>
                                </div>
                                @endforeach
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
    <section class="bg-light">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h2 class="section-title-sm mb-0">About Coorg Tour Package</h2>
                        </div>
                    </div>
                <div class="about-content mb-3 thin-scroll">
                    <!-- Description Preview with Truncated Content -->
                    <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                        <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 40px;background: linear-gradient(to bottom, rgb(252 252 252 / 52%), #f8f8f8)"></div>
                        <div class="description-full">
                            {!! $tourPageData->about_tag !!}
                        </div>
                    </div>

                    <!-- Toggle Button -->
                </div>
                <button class="moreless-button-about"
                    style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500;border:0">
                    Read more <span style="margin-left: 5px;">&#x25BC;</span>
                </button>
        </div>
    </section>

</div>
@include('website.include.webfooter')
<script>
    $(document).ready(function () {
        let page = 1;

        // Lazy load client reviews
        function loadContent(url, targetSelector, page, finishedFlag) {
            if (finishedFlag.value) return;

            $.ajax({
                url: url + "?page=" + page,
                type: "GET",
                beforeSend: function () {
                    $('.ajax-load').show();
                }
            }).done(function (data) {
                if (data.trim().length === 0) {
                    $('.ajax-load').html("<p>No more records found</p>");
                    finishedFlag.value = true;
                    return;
                }
                $(targetSelector).append(data);
                $('.ajax-load').hide();
            }).fail(function () {
                console.error("Server error");
                $('.ajax-load').hide();
            });
        }

        const finishedTours = { value: false };
        const finishedReviews = { value: false };

        loadContent("{{ route('website.allTourPackages') }}", "#allTour", page, finishedTours);
        loadContent("{{ route('website.clientReviews') }}", "#client-reviews", page, finishedReviews);

        // Filter application with debounce
        let filterTimeout;
        function applyFilters() {
            clearTimeout(filterTimeout);
            filterTimeout = setTimeout(function () {
                const durations = $('input[name="duration[]"]:checked').map(function () {
                    return this.value;
                }).get();

                const startingCities = $('input[name="starting_city[]"]:checked').map(function () {
                    return this.value;
                }).get();

                $.ajax({
                    url: "{{ route('website.allTourPackages') }}",
                    type: "GET",
                    data: {
                        durations: durations,
                        startingCities: startingCities
                    },
                    beforeSend: function () {
                        $('#allTour').html('<div class="text-center p-4">Loading...</div>');
                    },
                    success: function (data) {
                        $('#allTour').html(data);
                        document.querySelector('.tour-list-wrapper').scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }, 300); // 300ms debounce
        }

        $(document).on('change', '.filter-option', applyFilters);

        $(document).on('click', '.clear-filter', function () {
            $('.filter-option').prop('checked', false);
            applyFilters();
        });

        // Expandable about section
        function toggleMoreLess(buttonSelector, containerSelector) {
            $(buttonSelector).on('click', function () {
                const $preview = $(this).prev(containerSelector).find('.description-preview');
                const isExpanded = $preview.hasClass('expanded');

                $preview.toggleClass('expanded').css('max-height', isExpanded ? '200px' : 'none');
                $preview.find('.fade-overlay').toggleClass('d-none', isExpanded);

                $(this).html(isExpanded
                    ? 'Read more <span style="margin-left: 5px;">&#9660;</span>'
                    : 'Read less <span style="margin-left: 5px;">&#9650;</span>');
            });
        }

        toggleMoreLess('.moreless-button', '.about-content');
        toggleMoreLess('.moreless-button-about', '.about-content');

        // Mobile filter sidebar toggle
        $('.filter-btn').on('click', function () {
            $('.filter-wrapper, .filter-overlay').toggleClass('active');
        });

        $('.filter-overlay').on('click', function () {
            $(this).removeClass('active');
            $('.filter-wrapper').removeClass('active');
        });
    });
    $(document).on('click', '.filter-overlay, .close-filter', function() {
        $('.filter-wrapper').removeClass('active');
        $('.filter-overlay').remove();
        $('body').css('overflow', '');
    });
    
</script>