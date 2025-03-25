@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Tour Details</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link ">Tours</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Tours Details</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 tour-details-box">
                    <img class="destination-img" src="{{ asset('assets/img/web-img/blog-details.jpg') }}" alt="img" />
                    <h3 class="mt-2">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h3>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                        <span class="text-secondary">8.0 Superb</span>
                    </div>
                    <div class="border-top tour-info">

                        <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><i class="bi bi-geo-alt ms-2"></i>Itinerary</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Inclusions / Exclusions</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Hotels</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled" aria-selected="false">Booking Policy</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                <ul class="timeline">
                                    <li>
                                        <div class="item">
                                            <div class="timelineheading">
                                                <span>Day-1</span>
                                                <strong>- Pick up at 8 AM - From Bhubaneswar Drive to Puri & Konark Sightseeing</strong>
                                                <ol>
                                                    <li>Puri Jagannath Temple</li>
                                                    <li>Sudarshan Craft Museum</li>
                                                    <li>Narendra Pushkarini</li>
                                                    <li>Konark sun temple</li>
                                                    <li>Konark beach</li>
                                                    <li>Ramachandi temple</li>
                                                </ol>

                                            </div>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="item">
                                            <div class="timelineheading">
                                                <span>Day-2</span>
                                                <strong>- Start at 8 AM from - Puri to Bhubaneswar, Bhubaneswar Sightseeing & drop</strong>
                                                <ol>
                                                    <li>Udaygiri & Khandagiri Caves</li>
                                                    <li>Iskcon - Bhubaneswar</li>
                                                    <li>Ram Mandir Bhubaneswar</li>
                                                    <li>Odisha State Museum</li>
                                                    <li> Nandan Kanan Zoo</li>
                                                    <li>Lingaraj temple</li>
                                                </ol>

                                            </div>

                                        </div>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                <strong>Inclusions</strong>
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
                            <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab" tabindex="0">
                                <strong>Booking Policy</strong>
                                <p>Regarding Modification Before the Travel Date</p>
                                <ul class="itenary-ul mb-3">
                                    <li>Must be applied for at least 3 days prior to the final travel date. Hotels will be provided depending upon availability</li>
                                    <li>Rs. 4000 will be charged as a service fee for a change of travel date (package cost less than 40,000 INR). Rs. 8000 will be chargeble if the package cost b/w 40 to 80K INR. Rs. 15000 will be chargeble if the package cost is more than 80K.</li>
                                    <li>The cancellation Policy will take hold if the requested modification doesn’t leave a margin of at least 3 days from the travel date</li>
                                    <li>The itinerary and vehicle are flexible for 3 days prior to the final travel date.</li>

                                </ul>
                                <strong>Regarding Hotel Bookings</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>The tour package doesn’t include early check-in or late check-out charges.</li>
                                    <li>Standard hotel rooms will be on a twin-sharing basis.</li>
                                    <li>Extra bedding/mattress shall be provided for the third adult or child as per the booking.</li>
                                    <li>If not mentioned separately, basic rooms shall be provided.</li>
                                    <li>Standard hotel check-in time- 12-2:00 p.m.</li>
                                    <li>Standard hotel check-out time - 10:00 a.m-12 p.m.</li>
                                </ul>
                                <strong>Customer Responsibility</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>Kindly be particular about sightseeing timings as places missed cannot be adjusted (or extended post 7:00 p.m.).</li>
                                    <li>Any extra distance covered for visiting places apart from the decided itinerary must be paid by you directly to the driver.</li>
                                    <li>To avoid any last moment inconveniences, let us know of your marital status beforehand (if you are an unmarried couple</li>
                                    <li>In case of any last minute inconvenience, inform us immediately. No issues would be addressed post the completion of the tou</li>
                                    <li>You must carry valid ID proofs for all the travellers concerned.</li>
                                    <li>Any change in the primary guest name shall lead to the cancellation of the tour along with the applicable cancellation charges.</li>

                                </ul>
                                <strong>Refund Policy</strong>
                                <ul class="itenary-ul mb-2">
                                    <li>Any/every refund shall take about 10 business days to get credited to the original payment method.</li>
                                    <li>100% refund in case of a cab strike.</li>
                                    <li>85% refund in case of natural calamities and any nature disturbances (Corona or any other transmitting deceases) reported 3 days before travel date.</li>
                                    <li>100% refund in the rare case of cancellation by My Holiday Happiness due to any unavoidable/extreme situation.</li>
                                    <li>100% refund in the rare case of last-minute hotel room unavailability (if the alternate hotel provided doesn’t satisfy you)</li>
                                    <li>No refunds for missed sightseeing places.</li>
                                    <li>Refund mode - Your refund will be credited to your original source of payment</li>
                                </ul>
                                <p class="text-danger mb-3">Note - All the refunds will be calculated on the total trip amount.</p>
                                <strong>Our Responsibility</strong>
                                <ul class="itenary-ul mb-3">
                                    <li>We do not take a guarantee for the unavailability of any site due to heavy rains or any temporary reason.</li>
                                    <li>We do not guarantee the familiarity of the driver with any specific language. We shall try our best to arrange one but it purely depends on the availability.</li>
                                    <li>Any concerned vouchers shall be delivered via e-mail within 24 hours of booking.</li>
                                    <li>If the hotel fails at providing the complimentary breakfast, we shall give INR 100, INR 150 or INR 250 for 2-star, 3-star or 4-star hotel respectively for the same.</li>
                                    <li>We shall provide all the details of the car and the driver 24 hours prior to the trip.</li>
                                    <li>In case of any delay by the cab, you may make up for that time at the end of the tour before your return flight.</li>
                                    <li>We shall provide alternate car or accommodation along with complimentary food in case of car breakdown for over 4 hours.</li>
                                </ul>
                                <strong>Cancellation Policy</strong>
                                <p>(The number of days excludes the travel date and all the refunds will be calculated on the total trip amount.)</p>
                                <ul class="itenary-ul mb-3">
                                    <li>Cancellation Fee post 16 days of booking- 25% of tour cost</li>
                                    <li>Cancellation Fee for cancellation done in 8-15 days from the travel date- 50% of tour cost</li>
                                    <li>Cancellation Fee for cancellation done in 3-7 days from the travel date- 75% of tour cost</li>
                                    <li>Sorry, no refund shall be made if you cancel in less than 2 days from the travel date.</li>
                                    <li>5% refund in case of natural calamities and any nature disturbances (Corona or any other transmitting deceases) reported 3 days before travel date.</li>
                                    <li>Partial cancellation - Rs. 1,000 will be refunded per person if there is any partial cancellation. A cancellation request should be submitted 3 days prior to the travel date.</li>

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
                                </ul>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-4">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="mt-3">Calculate your Trip</h4>
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
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
                                </div>
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
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                        <label class="form-check-label" for="inlineCheckbox1">Pickup</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                        <label class="form-check-label" for="inlineCheckbox2">Drop</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 flex-wrap-wrap">
                                        <Button class="btn btn-primary">Calculate</Button>
                                        <Button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Inquiry/Customize</Button>
                                    </div>
                                </div>
                            </div>


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
                    <div class="col-12">
                        <button class="btn btn-primary ">Submit</button>
                        <button class="btn btn-danger ">Cancel</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@include('website.include.webfooter')