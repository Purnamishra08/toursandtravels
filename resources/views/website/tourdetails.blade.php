@include('website.include.webmeta')
@include('website.include.webheader')

<!-- print_r($tours); -->
<!-- print_r($itinerary); -->
@php

// Star rating generation
$fullStars = floor($tours->ratings);
$halfStar = (fmod($tours->ratings, 1) != 0.00) ? 1 : 0;
$emptyStars = 5 - ($fullStars + $halfStar);

$starsHtml = '';
for ($i = 0; $i < $fullStars; $i++) { $starsHtml .='<i class="fa fa-star text-warning"></i> ' ; } if ($halfStar) {
    $starsHtml .='<i class="fa fa-star-half text-warning"></i> ' ; } for ($i=0; $i < $emptyStars; $i++) { $starsHtml
    .='<i class="fa fa-star text-secondary"></i> ' ; } @endphp <div class="breadcrumb-section"
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
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true"><i class="bi bi-geo-alt ms-2"></i>Itinerary</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">Inclusions /
                                        Exclusions</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Hotels</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-disabled" type="button" role="tab"
                                        aria-controls="pills-disabled" aria-selected="false">Booking Policy</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane no-scroll fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab" tabindex="0">
                                    <ul class="timeline">
                                        @foreach($itinerary as $val)
                                        <li>
                                            <div class="item">
                                                <div class="timelineheading">
                                                    <span>Day- {{$loop->iteration}}</span>
                                                    <strong>- {{$val->title}}</strong>
                                                    <ol>
                                                        @foreach(explode(',', $val->place_id) as $placeId)
                                                        @php
                                                        $place = $places->firstWhere('placeid', $placeId);
                                                        @endphp
                                                        @if($place)
                                                        <li>{{ $place->place_name }}</li>
                                                        @else
                                                        <li>{{ $placeId }} (Unknown)</li> {{-- fallback in case place is
                                                        not found --}}
                                                        @endif
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab" tabindex="0">
                                    <div class="booking-policy">
                                        {!!$tours->inclusion_exclusion!!}
                                    </div>
                                    <!-- <strong>Inclusions</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Selected AC vehicle for pick up & drop and sightseeing</li>
                                    <li>Complimentary breakfast at selected hotel</li>
                                    <li>Selected category hotel for accommodation (not applicable for 1-day trips)</li>
                                    <li>All the sightseeing will be on a private basis in AC vehicle</li>
                                    <li>Entry tax, Toll, Parking charges, Driver allowance, Interstate tax if applicable</li>
                                    <li>Home pick up & drop - within 7 KM's (From our location - Rajajinagar 6th Block) complimentary home pick up and drop services will be provided. Anything above than this will have extra charges</li>
                                    <li>Total fares include GST</li>
                                </ul>
                                <strong>Exclusions</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Meals other than mentioned (Lunch & Dinner) and any beverages</li>
                                    <li>Local guide, Entrance fees to monuments, sight-seeing, parks and Sanctuaries and Safari charges</li>
                                    <li>Items of personal nature viz. tips, laundry, travel insurance, camera fees, etc.</li>
                                    <li>Early check-in or late checkout charges if applicable</li>
                                    <li>Hotel Gala dinner charges in the event of Christmas and New year eve</li>
                                    <li>Anything not specifically mentioned in the inclusion section</li>
                                </ul>
                                <strong>Optionals (arranged on request at additional cost)</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Any other choice of hotels/Resorts</li>
                                    <li>Local tour guide for selected destinations</li>
                                    <li>Honeymoon decoration - Flower bed decoration, Candlelight dinner, cake (Only at selected destinations) </li>
                                    <li>Visa and Travel insurance</li>

                                </ul> -->
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab" tabindex="0">
                                    <strong class="mb-3 d-block">Puri (1N)</strong>
                                    <div class="hotel-wrapper">
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> Hotel Swimming</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Three Star Hotel</p>
                                                <small class="d-block">(Deluxe room - Sea Facing)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> New Beach Resort</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Four Star Hotel</p>
                                                <small class="d-block">(Executive Sea View room)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> Reba Beach Resort</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Five Star Hotel</p>
                                                <small class="d-block">(Deluxe Room)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> Hotel Swimming</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Three Star Hotel</p>
                                                <small class="d-block">(Deluxe room - Sea Facing)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> New Beach Resort</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Four Star Hotel</p>
                                                <small class="d-block">(Executive Sea View room)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> Reba Beach Resort</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Five Star Hotel</p>
                                                <small class="d-block">(Deluxe Room)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-disabled" role="tabpanel"
                                    aria-labelledby="pills-disabled-tab" tabindex="0">
                                    <div class="booking-policy">
                                        {!!$bookingPolicys->par_value!!}
                                    </div>
                                    <!-- <strong>Booking Policy</strong>
                                <p>Regarding Modification Before the Travel Date</p>
                                <ul class="itenary-ul mb-3">
                                    <li>Must be applied for at least 3 days prior to the final travel date. Hotels will be provided depending upon availability</li>
                                    <li>Rs. 4000 will be charged as a service fee for a change of travel date (package cost less than 40,000 INR). Rs. 8000 will be chargeble if the package cost b/w 40 to 80K INR. Rs. 15000 will be chargeble if the package cost is more than 80K.</li>
                                    <li>The cancellation Policy will take hold if the requested modification doesn’t leave a margin of at least 3 days from the travel date</li>
                                    <li>The itinerary and vehicle are flexible for 3 days prior to the final travel date.</li>

                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                                    <strong class="mb-3 d-block">Puri (1N)</strong>
                                    <div class="hotel-wrapper">
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> Hotel Swimming</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                                </span>
                                                <p>Three Star Hotel</p>
                                                <small class="d-block">(Deluxe room - Sea Facing)</small>
                                                <img src="{{ asset('assets/img/web-img/trip-adviser.png') }}" alt="img">
                                            </div>
                                        </div>
                                        <div class=" hotel-details-card">
                                            <div class="card-body">
                                                <a href="#"><i class="bi bi-buildings"></i> New Beach Resort</a>
                                                <span class="d-block">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>

                                </ul>
                                <strong>Extra charges may apply</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>For any pick-up/drop service apart from the ones mentioned in the itinerary.</li>
                                    <li>For an extra entry or activity fee.</li>
                                    <li>For any special event organized by the hotel (only if you wish to attend).</li>
                                    <li>Xmas and Year-end Gala dinner charges will be applicable if hotel is planning to have one.</li>
                                    <li>For breakfast only if you miss the complimentary hotel breakfast.</li>
                                    <li>Extra One day vehicle charges applicable if the drop timing crosses 12.00 AM midnight. For Sedan 3500, SUV 5000 and Tempo Rs. 6000</li>
                                    <li>Incase of vehicle breakdown new vehicle will be arranged within 4 hours of time</li>
                                </ul> -->
                                </div>
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
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>
                                <div class="card client-review-card h-100">
                                    <div class="card-body">
                                        <div class="client-details mb-2">
                                            <div class="d-flex gap-2 align-items-center">
                                                <i class="bi bi-person-circle"></i>
                                                <div>
                                                    <p class="client-name"> Sairam Tatikonda</p>
                                                    <div class="rate"><svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                                            <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                        </svg><!-- <i class="fa fa-star text-warning"></i> Font Awesome fontawesome.com --> </div>

                                                </div>

                                            </div>
                                            <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                    <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                                </svg><!-- <i class="fa-solid fa-location-dot"></i> Font Awesome fontawesome.com --> Coastal Karnataka</p>



                                        </div>
                                        <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...</p>
                                    </div>
                                </div>

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
                                                        <input type="text" class="form-control guest-count" value="0"
                                                            readonly>
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
                                                        <input type="text" class="form-control guest-count" value="0"
                                                            readonly>
                                                        <span class="plus">+</span>

                                                    </div>

                                                </li>

                                            </ul>

                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                <label for="adult" class="d-block">Adult</label>
                                <div class="input-group ">
                                    <span class="input-group-text" id=""><i class="bi bi-plus"></i></span>
                                    <input type="text" class="form-control" aria-label="Username">
                                    <span class="input-group-text" id=""><i class="bi bi-dash"></i></span>
                                </div>
                                <small class="text-danger">(Adults: 12+ Yrs)</small>
                            </div>
                            <div class="col-md-6">
                                <label for="adult" class="d-block">Children</label>
                                <div class="input-group ">
                                    <span class="input-group-text" id=""><i class="bi bi-plus"></i></span>
                                    <input type="text" class="form-control" aria-label="Username">
                                    <span class="input-group-text" id=""><i class="bi bi-dash"></i></span>
                                </div>
                                <small class="text-danger">(Children: 6-12 Yrs)</small>
                            </div> -->
                                    <div class="col-12">
                                        <label for="vehicle" class="d-block">Vehicle</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>-Select Vehicle-</option>
                                            <option value="1">Sedan - AC (4+1)</option>
                                            <option value="2">SUV - AC (7+1)</option>
                                            <option value="3">Tempo Traveller - AC (12+1)</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="dot" class="d-block">Date of travel</label>
                                        <div class="input-group ">

                                            <input type="text" class="form-control date">
                                            <span class="input-group-text" id=""><i class="bi bi-calendar2"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="dot" class="d-block">Accommodation</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>-Select Accommodation-</option>
                                            <option value="1">Three Star</option>
                                            <option value="2">Four Star</option>
                                            <option value="3">Five Star</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="d-block">Airport pickup & drop</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1">Pickup</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2"
                                                value="option2">
                                            <label class="form-check-label" for="inlineCheckbox2">Drop</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex gap-2 flex-wrap-wrap">
                                            <Button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#calculate-modal">Calculate</Button>
                                            <Button class="btn btn-outline-warning" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">Inquiry/Customize</Button>
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
                        <h2 class="section-title-sm"> Most Popular Tour</h2>
                    </div>
                </div>
                <div class="card-wrapper" id="allTour">

                    <div class="card tour-card">
                        <img class="card-img-top"
                            src="http://localhost:8000/storage/tourpackages/thumbs/ooty-rose-garden.webp"
                            alt="Ooty Rose Garden">
                        <div class="card-body">
                            <p class="card-lavel">
                                <i class="bi bi-clock"></i> 2 Days &amp; 1 Nights
                            </p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="http://localhost:8000/assets/img/web-img/single-star.png" alt="Rating">
                                <span class="text-secondary">5 Star</span>
                            </div>
                            <h5 class="card-title">Relax Coorg tour</h5>
                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <div class="p-card-info">
                                    <span>From</span>
                                    <h6>₹ 6000.00 <span>Per Person</span></h6>
                                </div>
                                <a href="http://localhost:8000/tour/relax-coorg-tour"
                                    class="btn btn-outline-primary">Explore <i
                                        class="ms-2 bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card tour-card">
                        <img class="card-img-top"
                            src="http://localhost:8000/storage/tourpackages/thumbs/mysore-palace.webp"
                            alt="Mysore Palace">
                        <div class="card-body">
                            <p class="card-lavel">
                                <i class="bi bi-clock"></i> 3 daya &amp; 2 Night
                            </p>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="http://localhost:8000/assets/img/web-img/single-star.png" alt="Rating">
                                <span class="text-secondary">5 Star</span>
                            </div>
                            <h5 class="card-title">3 days trip from Mysore | Mysore &amp; Wayanad</h5>
                            <div class="d-flex justify-content-between align-items-center mt-3">

                                <div class="p-card-info">
                                    <span>From</span>
                                    <h6>₹ 8403.00 <span>Per Person</span></h6>
                                </div>
                                <a href="http://localhost:8000/tour/3-days-trip-from-mysore--mysore--wayanad"
                                    class="btn btn-outline-primary">Explore <i
                                        class="ms-2 bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="text-center mt-4">
                <button class="btn btn-primary">Load More</button>

            </div> -->





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
    <div class="modal fade" tabindex="-1" id="calculate-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Calculate Your Trip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">

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
                </div>
                <div class="modal-footer">
                    <div class="ms-auto">
                        <span class="total-price-box">total Price <span class="ms-2 c">₹ 9999.00 </span></span>



                    </div>


                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const guestInput = document.getElementById('guestInput');
            const guestWrapper = document.getElementById('guestWrapper');
            const plusButtons = document.querySelectorAll('.plus');
            const minusButtons = document.querySelectorAll('.minus');

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

            // Update guest count
            function updateGuestCount() {
                const guestInputs = document.querySelectorAll('.guest-count');
                let total = 0;
                guestInputs.forEach(input => {
                    total += parseInt(input.value);
                });
                guestInput.value = `${total} Guest${total !== 1 ? 's' : ''}`;
            }

            // Add guest
            plusButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const input = this.previousElementSibling;
                    input.value = parseInt(input.value) + 1;
                    updateGuestCount();
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
    </script>
    @include('website.include.webfooter')