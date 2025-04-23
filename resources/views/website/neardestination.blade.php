@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section" style="background-image: url('{{ asset('storage/place_images/' . $placesData->placeimg) }}');">
    <div class="container">
        <h1 class="page-name">{{$placesData->place_name}}</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('website.neardestination', ['slug' => $placesData->place_url])}}" class="breadcrumb-link active">{{$placesData->place_name}}</a>
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
                            <!-- <a class="navigation__link" href="#topPlace">Top Place to Visit </a> -->
                            <a class="navigation__link" href="#tourPackages">{{$placesData->place_name}} Tour Pakages </a>
                            <a class="navigation__link" href="#chetSheet">Essentials Cheat Sheet </a>
                            <!-- <a class="navigation__link" href="#neardestination">Nearby Destinations </a>
                            <a class="navigation__link" href="#similiardestination">Similar Destinations </a> -->
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
                        <h1 class="page-section-heading">{{$placesData->place_name}} Overview</h1>
                        @php
                            $aboutFull = trim($placesData->about_place);
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
                    <!-- <div class="page-section" id="topPlace">
                        <h1 class="page-section-heading">Top Places to Visit </h1>
                        <div class="top-place-wrapper">
                            <div class="card top-place-card">
                                <img src="https://myholidayhappiness.com/uploads/dhauli-2032.jpg" class="card-img-top" alt="img">
                                <div class="card-body">
                                    <h5 class="card-title">Dhauli</h5>
                                    <p class="card-text mb-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class=" stretched-link  fw-bold">View Details <i class=" ms-2 bi bi-arrow-right"></i> </a>
                                </div>
                            </div>
                            <div class="card top-place-card">
                                <img src="https://myholidayhappiness.com/uploads/dhauli-2032.jpg" class="card-img-top" alt="img">
                                <div class="card-body">
                                    <h5 class="card-title">Dhauli</h5>
                                    <p class="card-text mb-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class=" stretched-link  fw-bold">View Details <i class=" ms-2 bi bi-arrow-right"></i> </a>
                                </div>
                            </div>
                            <div class="card top-place-card">
                                <img src="https://myholidayhappiness.com/uploads/dhauli-2032.jpg" class="card-img-top" alt="img">
                                <div class="card-body">
                                    <h5 class="card-title">Dhauli</h5>
                                    <p class="card-text mb-2">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a href="#" class=" stretched-link  fw-bold">View Details <i class=" ms-2 bi bi-arrow-right"></i> </a>
                                </div>
                            </div>

                        </div>
                        <button class="btn btn-warning w-100 mt-3">View All</button>
                    </div> -->
                    <div class="page-section" id="tourPackages">
                        <h1 class="page-section-heading">{{$placesData->place_name}} Tour packages</h1>
                        <div class="card-wrapper" id="popular-tour"> </div>
                        <a href="{{ route('website.allTourPlacePackages', ['slug' => $placesData->place_url]) }}" target="_blank" class="btn btn-warning mt-3 w-100">View All</a>
                    </div>
                    <div class="page-section" id="chetSheet">
                        <h1 class="page-section-heading">Essentials Cheat Sheet</h1>
                        <div class="card chet-sheet-card">
                            <div class="card-body">
                            <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/exploretion-type.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Exploration Type</label>
                                        <strong class="">{{!empty($destinationTypes) ? $destinationTypes->destination_type_names : 'N/A'}}</strong>
                                    </div>
                                </div>
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/timing.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Timings</label>
                                        <strong class="">7:00 AM to 6:00 PM</strong>
                                    </div>
                                </div> -->
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/entryFee.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Entry Fee</label>
                                        <strong class="">Rs. 25 per Person</strong>
                                    </div>
                                </div>   -->
                                <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/distance.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Distance from near by city</label>
                                        <strong class="">{{!empty($placesData->distance_from_nearest_city) ? $placesData->distance_from_nearest_city : 'N/A'}}</strong>
                                    </div>
                                </div>
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/trip-duration.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Trip duration (including travel in hours)</label>
                                        <strong class="">1 - 2 Hours</strong>
                                    </div>
                                </div> -->
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/car.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary">Transportation Options</label>
                                        <strong class="">Sedan - AC (4+1), SUV - AC (7+1), Tempo Traveller - AC (12+1)</strong>
                                    </div>
                                </div> -->
                                <!-- <div class="d-flex  gap-2">
                                    <div class="icon-patch">
                                        <img src="{{ asset('assets/img/web-img/package.png') }}" alt="icon">
                                    </div>
                                    <div>
                                        <label class="d-block text-secondary"><a href="">1 package starts from</a></label>
                                        <strong class="">₹ 9301.00</strong>
                                    </div>
                                </div> -->
                               
                              

                            </div>
                            <div class="card-footer bg-white">
                                <small class="text-danger"><strong class="me-2">Notes/Tips:</strong>{{!empty($placesData->travel_tips) ? $placesData->travel_tips : 'N/A'}}</small>
                            </div>
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
                        {!! $placesData->google_map !!}
                    </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="bg-light">
        <div class="container" id="placesDataAll">
            <!-- <h1 class="page-section-heading">13 places to visit & things to do in Bhubaneswar</h1>
            <div class="near-destination-wrapper" id="placesDataAll">
                <a href="#" class="card near-Dcard">
                    <img src="https://c4.wallpaperflare.com/wallpaper/249/678/415/unesco-world-heritage-site-asia-india-agra-wallpaper-preview.jpg" alt="Card Background">
                    <div class="overlay">
                        <h2>Puri</h2>
                    </div>
                </a>
            </div> -->
        </div>
    </section>
    <section class="bg-light-green">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms; animation-name: fadeInUp;">
                <div>
                    <p class="section-title-small">Feature tours</p>
                    <h2 class="section-title-sm"> Most Popular {{$placesData->destination_name}} Tour Packages</h2>
                </div>
            </div>
            <div class="ajax-load text-center" style="display: none;">
                <p>Loading more packages...</p>
            </div>
            <div class="card-wrapper" id="allTour"></div>
        </div>
    </section>
    <section>
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h2 class="section-title-sm mb-0">Frequently Asked Questions</h2>
                    </div>
                    <a href="{{route('website.faqs', ['slug' => 'common-faqs'])}}" target="_blank" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
                <div class="accordion faq-accordion" id="accordionExample">
                @foreach($faqData as $faqDatas)
                    @php $collapseId = 'collapse' . $loop->index; @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                <h6 class="mb-0">{{ $faqDatas->faq_question }}</h6>
                            </button>
                        </h2>
                        <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                {!! $faqDatas->faq_answer !!}
                            </div>
                        </div>
                    </div>
                @endforeach
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
                    @foreach($reviewsData as $reviews)
                    <div class="card client-review-card h-100">
                        <div class="card-body">
                            <div class="client-details mb-2">
                                <div class="d-flex gap-2 align-items-center">
                                    <i class="bi bi-person-circle"></i>
                                    <div>
                                        <p class="client-name">{{$reviews->reviewer_name}}</p>
                                        @php
                                            $rating = $reviews->no_of_star;
                                            $fullStars = floor($rating);
                                            $halfStar = ($rating - $fullStars) >= 0.5 ? true : false;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp
                                        <div class="rate d-flex">
                                            {{-- Full Stars --}}
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                                </svg>
                                            @endfor

                                            {{-- Half Star --}}
                                            @if ($halfStar)
                                                <svg class="svg-inline--fa fa-star-half-alt text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star-half-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 536 512">
                                                    <path fill="currentColor" d="M288 0c-11.7 0-22.5 6.6-27.6 17.8L194 150.2 47.1 171.5c-26.2 3.8-36.7 36-17.7 54.6l105.7 103-25 145.5c-4.5 26.2 23 46 46.4 33.7L288 439.6V0z"/>
                                                </svg>
                                            @endif

                                            {{-- Empty Stars --}}
                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <svg class="svg-inline--fa fa-star text-muted" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>

                                    </div>
                                    <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                            <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                        </svg>{{$reviews->reviewer_loc}}</p>
                                </div>
                                <p class="clent-message">{{ Str::words($reviews->feedback_msg, 70, '...') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- modal -->
<div class="modal fade" tabindex="-1" id="page-load-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h1 class="my-3">Planning a Trip to {{$placesData->place_name}} ?</h1>
                    <a href="{{ route('website.allTourPlacePackages', ['slug' => $placesData->place_url]) }}" target="_blank" class="btn btn-warning"> {{!empty($total_packages) ? $countAndPrice->total_packages : ''}} {{$countAndPrice->total_packages}} Tours found from Rs.{{ !empty($countAndPrice) ? rtrim(rtrim(number_format($countAndPrice->min_price, 2, '.', ''), '0'), '.') : '' }} </a>
                    <a href="{{ route('website.allTourPlacePackages', ['slug' => $placesData->place_url]) }}" target="_blank" class="d-block mt-3">Explore & Book Online</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
<script>
    let isLoading = false;
    let finished = false;
    function loadPopularTour() {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTourPlaces') }}",
            type: "get",
            data: {
                place_Id: '{{ $placesData->placeid }}',
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
    function loadPopularTourData() {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTourDataPlaces') }}",
            type: "get",
            beforeSend: function () {
                $('.ajax-load').show();
            }
        }).done(function (data) {
            if (data.trim().length == 0) {
                finished = true;
                $('.ajax-load').html("<p class='text-center'>No more records found</p>");
                return;
            }
            $('#allTour').append(data);
            isLoading = false;
            $('.ajax-load').hide();
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }
    function loadPopularPlaceData() {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.allPlacesDataAsPerDestination') }}",
            type: "get",
            data: {
                destination_id: '{{ $placesData->destination_id }}',
                place_Id: '{{ $placesData->placeid }}',
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
            $('#placesDataAll').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }
    $(document).ready(function () {
        loadPopularTour(true);
        loadPopularTourData(true);
        loadPopularPlaceData(true);
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

        // Show/hide menu on scroll
        //if (scrollDistance >= 850) {
        //		$('nav').fadeIn("fast");
        //} else {
        //		$('nav').fadeOut("fast");
        //}

        // Assign active class to nav links while scolling
        $('.page-section').each(function(i) {
            if ($(this).position().top <= scrollDistance) {
                $('.navigation a.active').removeClass('active');
                $('.navigation a').eq(i).addClass('active');
            }
        });
    }).scroll();
</script>
<script>
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