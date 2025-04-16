@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section" style="background-image: url('{{ asset('storage/destination_images/' . $destinationData->destiimg) }}');">
    <div class="container">
        <h1 class="page-name">{{$destinationData->destination_name}} Overview</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('website.destinationdetails', ['slug' => $destinatoinURL->destination_url])}}" class="breadcrumb-link active">{{$destinationData->destination_name}} Overview</a>
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
                                        <p>{{isset($parameters) ? $parameters[0]->par_value : ''}}</p>
                                        </p>
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
                                <li><a href="{{$facebookLink}}" title="facebook" target="_blank" data-toggle="tooltip"> <i class="bi bi-facebook"></i></a></li>
                                <li><a href="{{$TwiterLink}}" title="Twitter" target="_blank" data-toggle="tooltip"> <i class="bi bi-twitter-x"></i></a></li>
                                <li><a href="#" title="Google+" target="_blank" data-toggle="tooltip"> <i class="bi bi-google"></i></a></li>
                                <li><a href="{{$LinkedInLink}}" title="Linkdin" target="_blank" data-toggle="tooltip"> <i class="bi bi-linkedin"></i></a></li>
                            </ul>
                        </div>
                        <a class="moreless-button " href="#">Read more</a>
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
                        <div class="card-wrapper card-wrapper-sm" id="popular-tour"></div>
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
<section>
    <div class="container">
        <div class="row">
           
            <div class="col-lg-6">
                <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                    <div>

                        <h2 class="section-title-sm">frequently Asked Questions</h2>
                    </div>
                </div>
                <div class="accordion faq-accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h6> How to search for tour package</h6>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                To search for tour packages, a customer has to visit to our website - www.myholidayhappiness.com and click on the “Tours” option. This option is available in the upper tab on the website. Then, select “Popular Tour Packages” to know about the tours which are famous and liked by our previous clients. You can easily search for tour packages there, according to your requirements.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h6>How to calculate tour price</h6>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ol>
                                    <li>Update number of travelers along with the kids as per their age</li>
                                    <li>Select vehicle type</li>
                                    <li>mention your travel date</li>
                                    <li>Choose your hotel as per your choice</li>
                                    <li>Select airport pick up and drop as per your plan</li>
                                    <li>Finally, click on "Calculate price"</li>
                                </ol>
                                <p>With the above-said option one can easily know what the prices for a tour that is to be paid to the service provide My Holiday Happiness. </p>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h6>How to Book a Tour on My Holiday website?</h6>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul>
                                    <li> Go to the “Tours” section on the website and click on it. You can see a drop-down menu where different tour packages will show. Click any one of them according to your wish and then a webpage will be redirected. You can select the “Starting City” and the “Trip Duration” in order to know the price for your trip. You will get a lot of options of tour packages which you may select according to your will. </li>
                                    <li>There will be some more options which you need to answer correctly in order to get the final price of your tour.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-light p-3">
                    <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                        <div>

                            <h2 class="section-title-sm">Verified Google Reviews</h2>
                        </div>
                        <a href="#" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="review-wrapper">
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div>
                                            <p class="client-name">Sairam Tatikonda</p>
                                            <div class="rate">

                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com -->
                                            </div>

                                        </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                </div>
                                <p class="clent-message"> Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                            </div>
                        </div>
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div>
                                            <p class="client-name">Mitalee Sinha</p>
                                            <div class="rate">

                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com -->
                                            </div>

                                        </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Chikmagalur</p>



                                </div>
                                <p class="clent-message"> family by booking their package and I have only good things to say about that trip. The service provided by MyHoliday Happiness is commendable, they constantly kept a check on our location to avoid any issues, connected with us on a regular basis during our trip and checked if we were fine and everything was happening according to our liking. Definitely going to try this again and recommend to others as well. - Trip name - Dharmasthala, Udupi and Murudeshwar package from Mangalore</p>
                            </div>
                        </div>
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div>
                                            <p class="client-name">Mitalee Sinha</p>
                                            <div class="rate">

                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com -->
                                            </div>

                                        </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Chikmagalur</p>



                                </div>
                                <p class="clent-message"> family by booking their package and I have only good things to say about that trip. The service provided by MyHoliday Happiness is commendable, they constantly kept a check on our location to avoid any issues, connected with us on a regular basis during our trip and checked if we were fine and everything was happening according to our liking. Definitely going to try this again and recommend to others as well. - Trip name - Dharmasthala, Udupi and Murudeshwar package from Mangalore</p>
                            </div>
                        </div>
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div>
                                            <p class="client-name">Shikha</p>
                                            <div class="rate">

                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com -->
                                            </div>

                                        </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Trip name - Agra 2 days trip</p>



                                </div>
                                <p class="clent-message"> It was nice experience with MHH</p>
                            </div>
                        </div>
                        <div class="card client-review-card h-100">
                            <div class="card-body">
                                <div class="client-details mb-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div>
                                            <p class="client-name">Purna Mishra</p>
                                            <div class="rate">

                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star-half-stroke text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star-half-stroke" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M288 376.4l.1-.1 26.4 14.1 85.2 45.5-16.5-97.6-4.8-28.7 20.7-20.5 70.1-69.3-96.1-14.2-29.3-4.3-12.9-26.6L288.1 86.9l-.1 .3 0 289.2zm175.1 98.3c2 12-3 24.2-12.9 31.3s-23 8-33.8 2.3L288.1 439.8 159.8 508.3C149 514 135.9 513.1 126 506s-14.9-19.3-12.9-31.3L137.8 329 33.6 225.9c-8.6-8.5-11.7-21.2-7.9-32.7s13.7-19.9 25.7-21.7L195 150.3 259.4 18c5.4-11 16.5-18 28.8-18s23.4 7 28.8 18l64.3 132.3 143.6 21.2c12 1.8 22 10.2 25.7 21.7s.7 24.2-7.9 32.7L438.5 329l24.6 145.7z"></path>
                                                </svg><!-- <i class="fa fa-star-half-stroke text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-secondary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-secondary"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-secondary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-secondary"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-secondary" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                </svg><!-- <i class="fa fa-star text-secondary"></i> Font Awesome fontawesome.com -->
                                            </div>

                                        </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Bhubaneswar</p>



                                </div>
                                <p class="clent-message"> Very nice location</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
                <h1 class="mb-3">Planning a Trip to Bhubaneswar ?</h1>
                <a href="" class="btn btn-warning">7 Bhubaneswar Tours from ₹9301.00 </a>
                <a href="" class="d-block mt-3">Explore & Book Online</a>

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
            beforeSend: function() {
                $('.ajax-load').show(); // Show loading spinner
            },
            success: function(data) {
                if (data.trim().length === 0) {
                    finished = true; // Mark as finished if no data
                    $('.ajax-load').html("<p class='text-center'>No more records found</p>");
                    return;
                }

                if (loadAll) {
                    $('#post-data').html(data); // Show all places
                    $('#view-all-btn').hide(); // Hide "View All" button after loading all
                } else {
                    if (page === 1) {
                        $('#post-data').html(data); // Show only the first 3 places
                    } else {
                        $('#post-data').append(data); // Append more places on subsequent pages
                    }
                }

                $('.ajax-load').hide(); // Hide loading spinner
            },
            error: function() {
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
            $('#popular-tour').append(data);
            isLoading = false;
        }).fail(function() {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    function loadPopularTourData(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTourData') }}?page=" + page,
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
        loadPlaces(false);
        loadPopularTour(true);
        loadPopularTourData(true);
    });
    $('#view-all-btn').on('click', function() {
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
        if ($(this).text() == "Read more") {
            $(this).text("Read less");
        } else {
            $(this).text("Read more");
        }
    });
</script>
<script>
    $(document).ready(function() {
        const myModal = new bootstrap.Modal(document.getElementById('page-load-modal'));
        myModal.show();
    });
</script>
@include('website.include.webfooter')