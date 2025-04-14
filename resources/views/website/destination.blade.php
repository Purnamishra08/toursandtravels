@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section" style="background-image: url('{{ asset('storage/destination_images/' . $destinationData->destiimg) }}');">
    <div class="container">
        <h1 class="page-name">{{$destinationData->destination_name}} </h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('website.destinationdetails', ['slug' => $destinationData->destination_url])}}" class="breadcrumb-link active">{{$destinationData->destination_name}} </a>
            </li>
        </ul>
    </div>
</div>
<div class="page-area">
    <section>
        <div class="container">

            <div class="row">
                <div class=" col-xxl-3 col-lg-4">
                    <div class="stickey-section">

                        <nav class="navigation " id="mainNav">
                            <a class="navigation__link active" href="#overview">Overview </a>
                            <a class="navigation__link" href="#topPlace">Top Place to Visit </a>
                            <a class="navigation__link" href="#tourPackages">Tour Pakages </a>
                            <a class="navigation__link" href="#chetSheet">Essentials Cheat Sheet </a>
                            <a class="navigation__link" href="#map">Getting There </a>
                            
                        </nav>
                        <div class="card contact-card mt-3">
                            <div class="card-body">
                                <h4 class="text-white">Contact Us</h4>
                            <ul class="contact-wrapper mt-1">
                                <li>
                                    <i class="bi bi-telephone"></i>
                                    <a href="tel:{{isset($parameters) ? $parameters[2]->par_value : ''}}">{{isset($parameters) ? $parameters[2]->par_value : ''}}</a>
                                </li>
                                <li>
                                    <i class="bi bi-envelope"></i>
                                    <a href="mailto:{{isset($parameters) ? $parameters[3]->par_value : ''}}">{{isset($parameters) ? $parameters[3]->par_value : ''}}</a>
                                </li>
                                <li>
                                    <i class="bi bi-geo-alt"></i>
                                    <p>{{isset($parameters) ? $parameters[0]->par_value : ''}}</p></p>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="col-xxl-9 col-lg-8">
                    <div class="page-section hero" id="overview">
                        <h1 class="page-section-heading">{{$destinationData->destination_name}} Overview</h1>
                        @php
                            $aboutFull = trim($destinationData->about_destination);
                            $aboutLimit = Str::limit($aboutFull, 1000, ''); // Limit to 250 characters
                        @endphp
                        <div class="short-text">
                            <p>{!! $aboutLimit !!}...</p>
                        </div>
                        
                        <div class="full-text-content d-none">
                            <p>{!! $aboutFull !!}</p>
                        </div>
                        <div class="d-flex gap-2 align-items-center mt-3 blog-share">
                            <strong>Share :</strong>
                            @php
                                $facebookLink = $parameters->firstWhere('parid', 29)->par_value ?? '';
                                $TwiterLink = $parameters->firstWhere('parid', 30)->par_value ?? '';
                                $LinkedInLink = $parameters->firstWhere('parid', 32)->par_value ?? '';
                            @endphp
                            <ul class="d-flex align-items-center gap-1">
                                <li><a href="{{$facebookLink}}" title="facebook" target="_blank"> <i class="bi bi-facebook"></i></a></li>
                                <li><a href="{{$TwiterLink}}" title="Twitter" target="_blank"> <i class="bi bi-twitter-x"></i></a></li>
                                <li><a href="#" title="Google+" target="_blank"> <i class="bi bi-google"></i></a></li>
                                <li><a href="{{$LinkedInLink}}" title="Linkdin" target="_blank"> <i class="bi bi-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <br>
                        <a class="moreless-button" href="javascript:void(0)"
                        style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500;">
                        Read more <span style="margin-left: 5px;">&#x25BC;</span>
                        </a>


                    </div>
                    <div class="page-section" id="topPlace">
                        <h1 class="page-section-heading">Top Places to Visit </h1>
                        <div class="top-place-wrapper" id="post-data">
                            <!-- Loaded places will appear here -->
                        </div>
                        <div class="ajax-load text-center" style="display: none;">
                            <p>Loading more places...</p>
                        </div>
                        <button id="view-all-btn" class="btn btn-warning w-100 mt-3">View All</button>
                    </div>
                    <div class="page-section" id="tourPackages">
                        <h1 class="page-section-heading">Tour package</h1>
                        <div class="card-wrapper" id="popular-tour"></div>
                        <a href="{{ route('website.allTourPackages') }}" target="_blank" class="btn btn-warning mt-3 w-100">View All</a>

                    </div>
                    <div class="page-section" id="chetSheet">
                        <h1 class="page-section-heading">Essentials Cheat Sheet</h1>
                        <div class="card chet-sheet-card">
                            <div class="card-body">
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/trip-duration.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Ideal Trip Duration</label>
                                        <strong class="">{{$destinationData->trip_duration}}</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/nearby-location.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Nearest City</label>
                                        <strong class="">{{$destinationData->nearest_city}}</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/bestTime-to-visit.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Best Time to Visit</label>
                                        <strong class="">{{$destinationData->visit_time}}</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/peak-season.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Peak Season</label>
                                        <strong class="">{{$destinationData->peak_season}}</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/weather.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Weather Info</label>
                                        <strong class="">{{$destinationData->weather_info}}</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/state.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">State</label>
                                        <strong class="">Karnataka</strong>
                                    </div>
                                </div>
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/internet.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Internet</label>
                                        <strong class="">Good</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/telephone.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">STD Code</label>
                                        <strong class="">0674</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/languages.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Languages</label>
                                        <strong class="">Odia, Hindi and English</strong>
                                    </div>
                                </div>
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/festival.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Festival</label>
                                        <strong class="">Kalinga Mahotsav, Durga Pooja, Konark Dance Festival and Chandan yatra</strong>
                                    </div>
                                </div> -->

                            </div>
                            <!-- <div class="card-footer bg-white">
                                <small class="text-danger"><strong class="me-2">Notes/Tips:</strong>Try to wear white, neutral tones of clothing to stay comfortable in summer. And avoid staying out at night as the city is quite an early sleeper.</small>
                            </div> -->
                        </div>
                    </div>
                    <!-- <div class="page-section" id="neardestination">
                        <h1 class="page-section-heading">Near by Destinations</h1>
                        <div class="near-destination-wrapper">
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Puri</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Konark</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Ramchandi</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Lingaraj</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Dhauli</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Nandankanan</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Khandagiri</h2>
                            
                            </div>
                        </a>
                        </div>
                    </div>
                    <div class="page-section" id="similiardestination">
                        <h1 class="page-section-heading">Similar Destination</h1>
                        <div class="near-destination-wrapper">
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Puri</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Konark</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Ramchandi</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Lingaraj</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Dhauli</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Nandankanan</h2>
                            
                            </div>
                        </a>
                        <a href="#" class="card near-Dcard">
                            <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                            <div class="overlay">
                            <h2>Khandagiri</h2>
                            
                            </div>
                        </a>
                        </div>
                    </div> -->
                    <div class="page-section" id="map">
                        <h1 class="page-section-heading">Getting There </h1>
                        {!! $destinationData->google_map !!}
                    </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light-green">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms; animation-name: fadeInUp;">
                <div>
                    <p class="section-title-small">Feature tours</p>
                    <h2 class="section-title-sm"> Most Popular Tour</h2>
                </div>
            </div>
            <div class="card-wrapper" id="allTour">
            </div>
        </div>
    </section>

</div>
<!--page-load- modal -->
<div class="modal fade" tabindex="-1" id="page-load-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="mb-3">Planning a Trip to {{$destinationData->destination_name}} ?</h1>
                    <a href="{{ route('website.allTourPackages') }}" target="_blank" class="btn btn-warning">{{!empty($total_packages) ? $countAndPrice->total_packages : ''}} {{$countAndPrice->total_packages}} Tours from {{!empty($countAndPrice) ? $countAndPrice->min_price : ''}} </a>
                    <a href="{{ route('website.allTourPackages') }}" target="_blank" class="d-block mt-3">Explore & Book Online</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
<script>
    let page = 1;
    let isLoading = false;
    let finished = false;
    function loadPlaces(loadAll = false) {
        $.ajax({
            url: "{{ route('website.places') }}",
            type: "POST",
            data: {
                destination_id: '{{ $destinationData->destination_id }}',
                load_all: loadAll,
                page: page,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function () {
                $('.ajax-load').show();  // Show loading spinner
            },
            success: function (data) {
                if (data.trim().length === 0) {
                    finished = true;  // Mark as finished if no data
                    $('.ajax-load').html("<p class='text-center'>No more records found</p>");
                    return;
                }

                if (loadAll) {
                    $('#post-data').html(data);  // Show all places
                    $('#view-all-btn').hide();  // Hide "View All" button after loading all
                } else {
                    if (page === 1) {
                        $('#post-data').html(data);  // Show only the first 3 places
                    } else {
                        $('#post-data').append(data);  // Append more places on subsequent pages
                    }
                }

                $('.ajax-load').hide();  // Hide loading spinner
            },
            error: function () {
                console.log("Error loading places.");
                $('.ajax-load').hide();
            }
        });
    }
    
    function loadPopularTour(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTour') }}?page=" + page,
            type: "get",
            data: {
                fromDestination: 1,
                _token: "{{ csrf_token() }}"
            },
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
    function loadPopularTourData(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTourData') }}?page=" + page,
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
            $('#allTour').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }
    $(document).ready(function () {
        loadPlaces(false);
        loadPopularTour(true);
        loadPopularTourData(true);
    });
    $('#view-all-btn').on('click', function () {
        loadPlaces(true);
    });
</script>
<script>
    $(document).ready(function() {
        $('a[href*=#]').bind('click', function(e) {
            e.preventDefault(); // prevent hard jump, the default behavior

            var target = $(this).attr("href"); // Set the target as variable

            // perform animated scrolling by getting top-position of target-element and set it as scroll target
            $('html, body').stop().animate({
                scrollTop: $(target).offset().top 
            }, 600, function() {
                location.hash = target; //attach the hash (#jumptarget) to the pageurl
            });

            return false;
        });
    });

    $(window).scroll(function() {
        var scrollDistance = $(window).scrollTop();
        // Assign active class to nav links while scolling
        $('.page-section').each(function(i) {
            if ($(this).position().top <= scrollDistance) {
                $('.navigation a.active').removeClass('active');
                $('.navigation a').eq(i).addClass('active');
            }
        });
    }).scroll();

    $('.moreless-button').click(function() {
        // Toggle the visibility of the short and full content
        $('.short-text').toggleClass('d-none'); // Hide/show the short text
        $('.full-text-content').toggleClass('d-none'); // Show/hide the full text content

        // Change the button text accordingly
        if ($(this).text().trim().startsWith("Read more")) {
            $(this).html('Read less <span style="margin-left: 5px;">&#9650;</span>'); // ▲
        } else {
            $(this).html('Read more <span style="margin-left: 5px;">&#9660;</span>'); // ▼
        }
    });
</script>
<script>
$(document).ready(function () {
        const myModal = new bootstrap.Modal(document.getElementById('page-load-modal'));
        myModal.show();
    });
</script>
@include('website.include.webfooter')