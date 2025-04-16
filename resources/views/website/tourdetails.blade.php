@include('website.include.webmeta')
@include('website.include.webheader')
@php
// Star rating generation
$fullStars = floor($tours->ratings);
$halfStar = (fmod($tours->ratings, 1) != 0.00) ? 1 : 0;
$emptyStars = 5 - ($fullStars + $halfStar);

$starsHtml = '';
for ($i = 0; $i < $fullStars; $i++)
    {
    $starsHtml .='<i class="fa fa-star text-warning"></i> ' ;
    }
    if ($halfStar) {
    $starsHtml .='<i class="fa fa-star-half-stroke text-warning"></i> ' ;
    }
    for ($i=0; $i < $emptyStars; $i++) {
    $starsHtml.='<i class="fa fa-star text-secondary"></i> ' ;
    }
    @endphp
    <div class="breadcrumb-section"
    style="background-image: url('{{ asset('storage/tourpackages/' . $tours->tpackage_image) }}')">
    <div class="container">
        <h1 class="page-name">{{$tours->tpackage_name}}</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('website.allTourPackages')}}" class="breadcrumb-link ">Tours</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('website.tourDetails', ['slug' => $tours->tpackage_url])}}"
                    class="breadcrumb-link active">{{$tours->tpackage_name}}</a>
            </li>
        </ul>
    </div>


    </div>
    <div class="page-area">
        <section class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 tour-details-box order-last order-lg-first">
                        <img class="destination-img"
                            src="{{ asset('storage/tourpackages/thumbs/' . $tours->tour_thumb) }}" alt="img" />
                        <h1 class="mt-2">{{ $tours->tpackage_name}}</h1>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="text-secondary">{!! $starsHtml !!} Star</span>
                        </div>
                        <div class="border-top tour-info">

                            <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-Itinerary-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Itinerary" type="button" role="tab" aria-controls="pills-Itinerary"
                                        aria-selected="true"><i class="bi bi-geo-alt ms-2"></i>Itinerary</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Inclusions-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Inclusions" type="button" role="tab"
                                        aria-controls="pills-Inclusions" aria-selected="false">Inclusions /
                                        Exclusions</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Hotels-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Hotels" type="button" role="tab"
                                        aria-controls="pills-Hotels" aria-selected="false">Hotels</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Booking-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Booking" type="button" role="tab"
                                        aria-controls="pills-Booking" aria-selected="false">Booking Policy</button>
                                </li>
                                @if($itinerary[0]->itinerary_desc)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-others-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-others" type="button" role="tab"
                                        aria-controls="pills-others" aria-selected="false">Others Details</button>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane no-scroll fade show active" id="pills-Itinerary" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <ul class="timeline">
                                        @foreach($itinerary as $day)
                                        <li>
                                            <div class="item">
                                                <div class="timelineheading">
                                                    <span>Day- {{$loop->iteration}}</span>
                                                    <strong>- {{$day->title}}</strong>
                                                    <ol>
                                                        @php
                                                        $dayPlaceIds = explode(',', $day->place_id);

                                                        $dayPlaces = collect($dayPlaceIds)
                                                        ->map(fn($id) => $places[$id]->place_name ?? null)
                                                        ->filter()
                                                        ->values();

                                                        $dayPlacesUrl = collect($dayPlaceIds)
                                                        ->map(fn($id) => $places[$id]->place_url ?? null)
                                                        ->filter()
                                                        ->values();

                                                        $dayPlacesCombined = $dayPlaces->zip($dayPlacesUrl); // Pairs name + URL
                                                        @endphp

                                                        @if($dayPlacesCombined->isNotEmpty())
                                                        @foreach($dayPlacesCombined as [$placeName, $url])
                                                        <li>
                                                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $placeName }}</a>
                                                        </li>
                                                        @endforeach
                                                        @endif

                                                        @if($day->other_iternary_places)
                                                        @foreach(explode(',', $day->other_iternary_places) as $placeName)
                                                        <li> {{ $placeName }}</li>
                                                        @endforeach
                                                        @endif

                                                    </ol>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-Inclusions" role="tabpanel"
                                    aria-labelledby="pills-profile-tab" tabindex="0">
                                    <div class="booking-policy">
                                        {!!$tours->inclusion_exclusion!!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-Hotels" role="tabpanel"
                                    aria-labelledby="pills-contact-tab" tabindex="0">
                                    @foreach($packageAccomodations as $packageAccomodation)
                                    @php
                                    $noof_hotel = count($packageAccomodations);
                                    $hotel = 1;
                                    $destination = $destinations->firstWhere('destination_id', $packageAccomodation->destination_id);
                                    @endphp
                                    @if($destination)
                                    <strong class="mb-3 d-block">{{$destination->destination_name}} ({{$packageAccomodation->noof_days}}N)</strong>
                                    @endif
                                    <div class="hotel-wrapper mb-1">
                                        @php
                                        $hotels = DB::table('tbl_hotel')
                                        ->where('destination_name',$packageAccomodation->destination_id)
                                        ->where('bit_Deleted_Flag',0)
                                        ->get();
                                        @endphp
                                        @foreach($hotels as $hotel)
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="{{$hotel->trip_advisor_url}}" target="_blank"><i class="bi bi-buildings"></i>{{$hotel->hotel_name}}</a>
                                                @php
                                                $hotelName = $hotelsType->firstWhere('hotel_type_id', $hotel->hotel_type);

                                                // Star rating generation
                                                $full = floor($hotel->star_rating);
                                                $half = (fmod($hotel->star_rating, 1) != 0.00) ? 1 : 0;
                                                $emptyStars = 5 - ($full + $half);

                                                $starsHotelHtml = '';
                                                for ($i = 0; $i < $full; $i++)
                                                    {
                                                    $starsHotelHtml .='<i class="fa fa-star text-warning"></i> ' ;
                                                    }
                                                    if ($half) {
                                                    $starsHotelHtml .='<i class="fa fa-star-half-stroke text-warning"></i> ' ;
                                                    }
                                                    for ($i=0; $i < $emptyStars; $i++) {
                                                    $starsHotelHtml.='<i class="fa fa-star text-secondary"></i> ' ;
                                                    }
                                                    @endphp
                                                    <span class="d-block">{!! $starsHotelHtml !!}</span>
                                                    @if($hotelName)
                                                    <p>{{$hotelName->hotel_type_name}}</p>
                                                    @endif
                                                    <small class="d-block">({{$hotel->room_type}})</small>
                                                    <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                <div class="tab-pane fade" id="pills-Booking" role="tabpanel"
                                    aria-labelledby="pills-disabled-tab" tabindex="0">
                                    <div class="booking-policy">
                                        {!!$bookingPolicys->par_value!!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-others" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <ul class="timeline">
                                        @foreach($itinerary as $day)
                                        <li>
                                            <div class="item">
                                                <div class="timelineheading">
                                                    <span>Day- {{$loop->iteration}}</span>
                                                    <strong>- {{$day->title}}</strong>
                                                    {!!$day->itinerary_desc!!}
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="bg-light p-3">
                                    <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                                        <div>

                                            <h2 class="section-title-sm">Verified Google Reviews</h2>
                                        </div>
                                        <a href="#" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
                                    </div>
                                    <div class="review-wrapper">
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
                        <div class="col-lg-4 order-first order-lg-last">
                            <div class="card calculate-card stickey-section ">
                                <div class="card-body">
                                    <h4 class="mt-3">Calculate your Trip</h4>
                                    <div class="row g-3 mt-3">
                                        <div class="col-12 position-relative">
                                            <label for="guest" class="d-block">Guest</label>
                                            <input type="text" class="form-control form-select " id="guestInput" readonly
                                                value="0 Guests">
                                            <div class="guest-wrapper" id="guestWrapper">
                                                <ul class="">
                                                    <li>
                                                        <div class="label-box">
                                                            <strong class="d-block">Adults</strong>
                                                            <small class="text-muted">12years and above</small>
                                                        </div>
                                                        <div
                                                            class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                            <span class="minus">-</span>
                                                            <!-- <input type="text" class="form-control guest-count" value="0"
                                                                readonly> -->
                                                                <input type="text" class="form-control guest-count"  step="1" max="{{$max_vehicle_capacity}}" value="0" name="quantity_adult" id="quantity_adult" class="quantity-field" readonly>
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="label-box">
                                                            <strong class="d-block">Children</strong>
                                                            <small class="text-muted">Children: 6-12 Yrs</small>
                                                        </div>
                                                        <div
                                                            class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                                            <span class="minus">-</span>
                                                            <!-- <input type="text" class="form-control guest-count" value="0"
                                                                readonly> -->
                                                            <input type="text" class="form-control guest-count" step="1" max="{{$max_vehicle_capacity}}"  value="0" name="quantity_child" id="quantity_child" class="quantity-field" readonly>
                                                            <span class="plus">+</span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="vehicle" class="d-block">Vehicle</label>
                                            <select class="form-select" aria-label="Default select Vehicle" id="vehicle" name="vehicle">
                                                <option value="0">-Select Vehicle-</option>
                                                @if($noof_vehicle)
                                                    @foreach($getVehicleDropDown as $value)
                                                    <option value="{{$value->vehicleid}}">{{$value->vehicle_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="dot" class="d-block">Date of travel</label>
                                            <div class="input-group ">
                                                <input type="text" class="form-control date" id="travel_date" name="travel_date">
                                                <span class="input-group-text" id=""><i class="bi bi-calendar2"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex justifu-content-between">

                                                <label for="dot" class="">Accommodation</label>
                                                <a href="" class="ms-auto text-warning" data-bs-toggle="modal"
                                                    data-bs-target="#hotel-modal">Check hotel</a>
                                            </div>
                                            <select class="form-select" id="accommodation_type" name="accommodation_type" onchange="getAccommodation()">		
                                                <option value=""> - - Select Accommodation - - </option>
                                                @if($hotelsTypeDropDown)
                                                    @foreach($hotelsTypeDropDown as $value)
                                                    <option value="{{$value->hotel_type_id}}">{{$value->hotel_type_name}}</option>
                                                    @endforeach
                                                @endif
                                                
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="d-block">Airport pickup & drop</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="airport_pickup" id="airport_pickup" value="1">
                                                <label class="form-check-label" for="inlineCheckbox1">Pickup</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="airport_drop" id="airport_drop" value="2">
                                                <label class="form-check-label" for="inlineCheckbox2">Drop</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex gap-2 flex-wrap-wrap">
                                                
                                                <input type="hidden" id="hid_packageid" name="hid_packageid" value="{{$tourpackageid}}">
                                                <button class="btn btn-success" onclick="getPackagePrice()">Calculate</button>
                                                <button class="btn btn-outline-warning" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">Inquiry/Customize</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>


                        </div>
                    </div>
                </div>


        </section>
        <section class="bg-light-green">
            <div class="container">
                <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms"
                    style="visibility: visible; animation-delay: 200ms; animation-name: fadeInUp;">
                    <div>
                        <p class="section-title-small">Feature tours</p>
                        <h2 class="section-title-sm"> Most Popular {{$tag_name}}</h2>
                    </div>
                </div>
                <div class="card-wrapper" id="allTour">
                    @foreach ($tour_packages as $values)
                    <div class="card tour-card">
                        <img class="card-img-top"
                            src="{{ asset('storage/tourpackages/thumbs/' . $values->tour_thumb) }}"
                            alt="{{ $values->alttag_thumb }}">

                        @if ($values->pack_type == 15)
                        <span class="badge">Most popular</span>
                        @endif

                        <div class="card-body">
                            <p class="card-lavel">
                                <i class="bi bi-clock"></i>
                                {!! str_replace('/', '&', $values->duration_name) !!}
                                <small class="d-block">Ex- {{ $values->destination_name }}</small>
                            </p>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                                <span class="text-secondary">{{ $values->ratings }} Star</span>
                            </div>

                            <h5 class="card-title">{{ $values->tpackage_name }}</h5>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="p-card-info">
                                    <h6 class="mb-0"><span>₹ </span>{{ $values->price }}</h6>
                                    <strike>₹ {{ $values->fakeprice }}</strike>
                                </div>
                                <a href="{{ route('website.tourDetails', ['slug' => $values->tpackage_url]) }}"
                                    class="btn btn-outline-primary stretched-link">
                                    Explore <i class="ms-2 bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">

                    <div class="col-lg-8">
                    <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                                        <div>

                                            <h2 class="section-title-sm">Frequently Asked Questions</h2>
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
                    <div class="col-lg-4">
                        <div class="card contact-card">
                                <div class="card-body">
                                    <h4 class="text-white">Contact Us</h4>
                                <ul class="contact-wrapper mt-1">
                                    <li>
                                        <i class="bi bi-telephone"></i>
                                        <a href="tel:+926669990000">+ 926669990000</a>
                                    </li>
                                    <li>
                                        <i class="bi bi-envelope"></i>
                                        <a href="mailto:needhelp@company.com">support@myholidayhappiness.com</a>
                                    </li>
                                    <li>
                                        <i class="bi bi-geo-alt"></i>
                                        <p># 66 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar, Bengaluru, Karnataka 560010</p>
                                    </li>
                                </ul>
                                </div>
                            </div>  
                        </div>
                </div>
                    
            </div>

        </section>
    </div>
    <div class="modal fade" tabindex="-1" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enquiry Now</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="dot" class="d-block">First Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="dot" class="d-block">Last Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="dot" class="d-block">Email</label>
                            <input type="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="dot" class="d-block">Mobile No.</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6 position-relative">
                            <label for="guest" class="d-block">Guest</label>
                            <input type="text" class="form-control form-select " id="guestInput" readonly
                                value="0 Guests">
                            <div class="guest-wrapper" id="guestWrapper">
                                <ul class="">
                                    <li>
                                        <div class="label-box">
                                            <strong class="d-block">Adults</strong>
                                            <small class="text-muted">12years and above</small>
                                        </div>
                                        <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                            <span class="minus">-</span>
                                            <input type="text" class="form-control guest-count" value="0" readonly>
                                            <span class="plus">+</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="label-box">
                                            <strong class="d-block">Children</strong>
                                            <small class="text-muted">Children: 6-12 Yrs</small>
                                        </div>
                                        <div class="data-box d-flex justify-content-between  gap-3 align-items-center">
                                            <span class="minus">-</span>
                                            <input type="text" class="form-control guest-count" value="0" readonly>
                                            <span class="plus">+</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dot" class="d-block">Date of travel</label>
                            <div class="input-group ">
                                <input type="text" class="form-control date" aria-label="Username">
                                <span class="input-group-text" id=""><i class="bi bi-calendar2"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dot" class="d-block">Accommodation</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>-Select Accommodation-</option>
                                <option value="1">Three Star</option>
                                <option value="2">Four Star</option>
                                <option value="3">Five Star</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                                    style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Message</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary ">Submit</button>
                            <button class="btn btn-danger " data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculate modal -->
    <div class="modal fade" tabindex="-1" id="calculate-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Calculate Your Trip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 calculate-details">

                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/people.png') }}" alt="adult">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Adult</label>
                                    <strong class="">2</strong>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/children.png') }}" alt="children">

                                </div>
                                <div>
                                    <label class="d-block text-secondary">Childern</label>
                                    <strong class="">4</strong>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/car.png') }}" alt="car">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Vehicle</label>
                                    <strong class="">Sedan - AC (4+1)</strong>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2 ">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/calendar.png') }}" alt="calender">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Date of travel</label>
                                    <strong class="">24-06-2025</strong>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/bed.png') }}" alt="bed">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Accommodation</label>

                                    <strong class="">Three Star Hotel</strong>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/pick-up.png') }}" alt="children">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Pickup</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked type="checkbox" id="inlineCheckbox1"
                                            value="option1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1"><strong>Pickup</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-patch">
                                    <img src="{{ asset('assets/img/web-img/car.png') }}" alt="children">
                                </div>
                                <div>
                                    <label class="d-block text-secondary">Drop</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked type="checkbox" id="inlineCheckbox1"
                                            value="option1">
                                        <label class="form-check-label"
                                            for="inlineCheckbox1"><strong>Drop</strong></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-3 total-price-box text-center">
                        Total Price <span class="ms-2 c">₹ 9999.00 </span>
                    </div>
                    <div class="bookingUser-details mt-3" style="display: none;">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="dot" class="d-block">First Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="dot" class="d-block">Last Name</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="dot" class="d-block">Email</label>
                                <input type="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="dot" class="d-block">Mobile No.</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">Message</label>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <div class="ms-auto">
                        <a href="#" id="backBtn" class="btn btn-secondary" style="display:none">Back</a>
                        <a href="#" class="btn btn-primary " id="bookNowBtn"> Book Now</a>
                        <a href="#" class="btn btn-outline-primary"> Download</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hotel modal -->
    <div class="modal fade" tabindex="-1" id="hotel-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$tours->tpackage_name}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  id="accomodation_result">
                    <div class="col-xl-12 col-lg-12">
                        <h4 style="color:#6583bb; padding-bottom:20px;">Select accommodation first to check hotels.</h4>
                    </div>
                    <div class="text-center mt-3">
                        <input type="button" class="btn btn-info" value="OK" data-bs-dismiss="modal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function () {
        var today = new Date();
        var twoDaysLater = new Date();
        twoDaysLater.setDate(today.getDate() + 2);

        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            startDate: twoDaysLater,
            autoclose: true,
            clearBtn: true
        });
    });
        document.addEventListener('DOMContentLoaded', function () {
            const guestInput = document.getElementById('guestInput');
            const guestWrapper = document.getElementById('guestWrapper');
            const plusButtons = document.querySelectorAll('.plus');
            const minusButtons = document.querySelectorAll('.minus');
            const maxCapacity = parseInt("{{ $max_vehicle_capacity }}");

            // Toggle guest box
            guestInput.addEventListener('click', function (e) {
                e.stopPropagation();
                guestWrapper.style.display = guestWrapper.style.display === 'block' ? 'none' : 'block';
            });

            // Close when clicking outside
            document.addEventListener('click', function (e) {
                if (!guestWrapper.contains(e.target) && e.target !== guestInput) {
                    guestWrapper.style.display = 'none';
                }
            });

        // Update guest count display
        function updateGuestCount() {
            const guestInputs = document.querySelectorAll('.guest-count');
            let total = 0;
            guestInputs.forEach(input => {
                total += parseInt(input.value);
            });
            guestInput.value = `${total} Guest${total !== 1 ? 's' : ''}`;

            var maxcapacity = {{$max_vehicle_capacity}};
            // var adultcount = $("#quantity_adult").val();
            // var childcount = $("#quantity_child").val();
            var totalcount = total;
            $.ajax({
                url: '/getVehicles',
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                data: {
                    totalcount: totalcount,
                    package_id: {{$tourpackageid}} // or destination if no package_id
                },
                success: function (response) {                
                    if (response.options) {
                        $('#vehicle').html(response.options);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopps...',
                            text: 'Error: Invalid response!',
                            confirmButtonColor: '#dd3333',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error loading view form.',
                        confirmButtonColor: '#dd3333',
                    });
                }
            });

        }

        // Add guest with max capacity check
        plusButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const guestInputs = document.querySelectorAll('.guest-count');
                let total = 0;
                guestInputs.forEach(input => {
                    total += parseInt(input.value);
                });

                if (total < maxCapacity) {
                    input.value = parseInt(input.value) + 1;
                    updateGuestCount();
                } else {
                    alert(`Maximum ${maxCapacity} guests allowed.`);
                    let exampleModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    exampleModal.show();
                }
            });
        });

        // Remove guest
        minusButtons.forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.nextElementSibling;
                let value = parseInt(input.value);
                if (value > 0) {
                    input.value = value - 1;
                    updateGuestCount();
                }
            });
        });
    });

    function getAccommodation(){
        let package_id = {{$tourpackageid}};
        var accommodation_type = $('#accommodation_type').val();
        if (accommodation_type !="")
        {
            $("#hotel-modal").modal('show');
            $.ajax({
                url: '/getAccommodationWeb',
                type: 'GET',
                dataType: 'json',  // Ensure JSON response
                data: {
                    accommodation_type: accommodation_type,
                    packageid: package_id
                },
                success: function (response) {
                    if (response.html) {
                        $('#accomodation_result').html(response.html);
                        $('#accommodation').val(accommodation_type);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oopps...',
                            text: 'Error: Invalid response!',
                            confirmButtonColor: '#dd3333',
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oopps...',
                        text: 'Error loading view form.',
                        confirmButtonColor: '#dd3333',
                    });
                }
            });
        } else
        {
            $("#accomodation_result").html('<h4 style="color:#6583bb; padding-bottom:20px;">Select rohan accommodation first to check hotels.</h4>');
        }
    }

    // function getPackagePrice(){
    //     let selectedHotels = [];
    //     // Loop through all radio groups that start with 'hotel_radio_'
    //     $('input[type="radio"]').each(function () {
    //         let name = $(this).attr('name');

    //         // Skip if we've already processed this group
    //         if (selectedHotels[name] !== undefined) return;

    //         let checked = $('input[name="' + name + '"]:checked').val();
    //         if (checked) {
    //             selectedHotels.push({ name: name, value: checked });
    //         }

    //         // Prevent duplicates
    //         selectedHotels[name] = true;
    //     });
    //     // Prepare data for backend
    //     let postData = {
    //         _token: $('meta[name="csrf-token"]').attr('content'),
    //     };

    //     // Add hotel radios dynamically
    //     selectedHotels.forEach(function (hotel) {
    //         postData[hotel.name] = hotel.value;
    //     });

    //     console.log(postData);
        
    //     // let hid_packageid = $('#hid_packageid').val();;
    //     // let quantity_adult = $('#quantity_adult').val();
    //     // let quantity_child = $('#quantity_child').val();
    //     // let travel_date = $('#travel_date').val();
    //     // let vehicle = $('#vehicle').val();
    //     // var accommodation_type = $('#accommodation_type').val();
    //     // var airport_pickup = $('#airport_pickup').val();
    //     // var airport_drop = $('#airport_drop').val();
    //     formData.append('hid_packageid', $("#hid_packageid").val());
    //     formData.append('quantity_adult', $("#quantity_adult").val());
    //     formData.append('quantity_child', $("#quantity_child").val());
    //     formData.append('travel_date', $("#travel_date").val());
    //     formData.append('vehicle', $("#vehicle").val());
    //     formData.append('accommodation_type', $("#accommodation_type").val());
    //     formData.append('airport_pickup', $("#airport_pickup").val());
    //     formData.append('airport_drop', $("#airport_drop").val());

    //     // CSRF token (Laravel Blade)
    //     formData.append('_token', '{{ csrf_token() }}');
    //     if (accommodation_type !="")
    //     {
    //         $.ajax({
    //             url: '/getPackagePrice',
    //             type: 'GET',
    //             dataType: 'json',  // Ensure JSON response
    //             data: {
    //                 hid_packageid : hid_packageid,
    //                 quantity_adult : quantity_adult,
    //                 quantity_child : quantity_child,
    //                 travel_date : travel_date,
    //                 vehicle : vehicle,
    //                 accommodation_type : accommodation_type,
    //                 airport_pickup : airport_pickup,
    //                 airport_drop : airport_drop
    //             },
    //             success: function (response) {
    //                 if (response.html) {
    //                     $("#calculate-modal").modal('show');
    //                     $('#accomodation_result').html(response.html);
    //                     $('#accommodation').val(accommodation_type);
    //                 } else {
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Oopps...',
    //                         text: 'Error: Invalid response!',
    //                         confirmButtonColor: '#dd3333',
    //                     });
    //                 }
    //             },
    //             error: function () {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Oopps...',
    //                     text: 'Error loading view form.',
    //                     confirmButtonColor: '#dd3333',
    //                 });
    //             }
    //         });
    //     } else
    //     {
            
    //     }
    // }
    function getPackagePrice() {
    let selectedHotels = {};
    let params = {};

    // Step 1: Get checked hotel radios
    $('input[type="radio"]').each(function () {
        let name = $(this).attr('name');
        if (!(name in selectedHotels)) {
            let checked = $('input[name="' + name + '"]:checked').val();
            if (checked) {
                selectedHotels[name] = checked;
                params[name] = checked;  // Add to params as a regular object
            }
        }
    });

    // Step 2: Append other parameters
    params['hid_packageid'] = $("#hid_packageid").val();
    params['quantity_adult'] = $("#quantity_adult").val();
    params['quantity_child'] = $("#quantity_child").val();
    params['travel_date'] = $("#travel_date").val();
    params['vehicle'] = $("#vehicle").val();
    params['accommodation_type'] = $("#accommodation_type").val();

     // Step 3: Check for Airport pickup and drop and append if checked
    if ($("#airport_pickup").prop('checked')) {
        params['airport_pickup'] = 1;
    }

    if ($("#airport_drop").prop('checked')) {
        params['airport_drop'] = 1;
    }

    let accommodation_type = $("#accommodation_type").val();

    if (accommodation_type !== "") {
        $.ajax({
            url: '/getPackagePrice',  // Send as query string
            type: 'GET',
            data: params,  // Pass params as a regular object
            dataType: 'json',
            success: function (response) {
                if (response.html) {
                    $("#calculate-modal").modal('show');
                    $('#accomodation_result').html(response.html);
                    $('#accommodation').val(accommodation_type);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error: Invalid response!',
                        confirmButtonColor: '#dd3333',
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error loading view form.',
                    confirmButtonColor: '#dd3333',
                });
            }
        });
    }
}


    </script>
    <script>
        $(document).on('click', '#bookNowBtn', function(e) {
            console.log("clicked");
            e.preventDefault();
            $('#backBtn').show();
            $('.calculate-details').slideUp();
            $('.bookingUser-details').slideDown();
        });
        $(document).on('click', '#backBtn', function(e) {
            console.log("back clicked");
            e.preventDefault();

            $('.bookingUser-details').slideUp(); // Hide booking form
            $('.calculate-details').slideDown(); // Show trip details
            $('#backBtn').hide(); // Optionally hide the back button again
        });
    </script>


    @include('website.include.webfooter')