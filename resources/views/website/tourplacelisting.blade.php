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

{{-- Product Schemas (multiple) --}}
@foreach ($productSchemas as $productSchema)
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endforeach
@endif
@include('website.include.webheader')
<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">{{!empty($placesData) ? $placesData->place_name : ''}}</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('website.allTourPackages')}}" class="breadcrumb-link active">Tours</a>
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
                    <h2 class="section-title"> {{!empty($countAndPrice) ? $countAndPrice->total_packages : 0}} {{!empty($placesData) ? $placesData->place_name : ''}} Tour Packages Found.</h2>
                </div>
            </div>
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
                            <strong>Filter</strong>
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

</div>
@include('website.include.webfooter')

<script>
    var page = 1;
    var isLoading = false;
    var finished = false;
    function loadPopularTour(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.allTourPlacePackages', ['slug' => $slug]) }}?page=" + page,
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
    $(document).ready(function() {
        loadPopularTour(page);
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

        $.ajax({
            url: "{{ route('website.allTourPlacePackages', ['slug' => $slug]) }}?page=" + page,
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