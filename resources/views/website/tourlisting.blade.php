@include('website.include.webmeta')
@include('website.include.webheader')
<div class="breadcrumb-section" style="background-image: url('{{ asset('storage/category_tags_images/BannerImages/' . $tourPageData->menutag_img) }}');">
    <div class="container">
        <h1 class="page-name">{{$tourPageData->tag_name}}</h1>
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
                    <p class="section-title-small">Feature tours</p>
                    <h2 class="section-title"> Most Popular {{$tourPageData->tag_name}}</h2>
                </div>
            </div>

            <div class="about-content mb-3">
                <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                    <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: linear-gradient(transparent, white);"></div>
                    <div class="description-full">
                        {!! $tourPageData->description_tag !!}
                    </div>
                </div>

                <button class="moreless-button"
                    style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500; border:0">
                    Read more <span style="margin-left: 5px;">&#x25BC;</span>
                </button>
            </div>
        </div>
        <div class="tour-filter-section">
            <div class="container">

                <span class="filter-btn btn btn-sm btn-outline-secondary"><i class="bi bi-funnel me-2"></i>Filter</span>
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
                                    <input class="form-check-input filter-option" type="checkbox" name="duration[]" value="{{$duration->durationid}}">
                                    <label class="form-check-label">{{$duration->duration_name}}</label>
                                </div>
                                @endforeach
                            </div>
                            <strong class="mb-2 d-block">Starting City</strong>
                            <div class="mb-3">
                                @foreach($destinations as $destination)
                                <div class="form-check">
                                    <input class="form-check-input filter-option" type="checkbox" name="starting_city[]" value="{{$destination->destination_id}}">
                                    <label class="form-check-label">{{$destination->destination_name}}</label>
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
                            <h2 class="section-title-sm mb-0">Frequently Asked Questions</h2>
                        </div>
                        <a href="http://localhost:8000/Faqs/destination-faqs" target="_blank" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="accordion faq-accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading0">
                                <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0">
                                    <h6 class="mb-0">How to Search for Tour Packages odisha?</h6>
                                </button>
                            </h2>
                            <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>•&nbsp;&nbsp; &nbsp; To search for tour packages, a customer has to visit to our website - www.myholidayhappiness.com and click on the “Tours” option. This option is available in the upper tab on the website. Then, select “Popular Tour Packages” to know about the tours which are famous and liked by our previous clients. You can easily search for tour packages there, according to your requirements.&nbsp;</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <h6 class="mb-0">How do I get Payment Confirmation?</h6>
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse " aria-labelledby="heading1" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>•&nbsp;&nbsp; &nbsp;After the payment is successful the customer/client will find an auto-generated invoice. Apart from that, &nbsp;a confirmation mail and message will be sent to the client’s mail id and number respectively from the assigned tour manager.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-6">
                    <div class=" ">
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
                                                <p class="client-name">Purna Mishra</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>


                                                    <svg class="svg-inline--fa fa-star-half-alt text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star-half-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 536 512">
                                                        <path fill="currentColor" d="M288 0c-11.7 0-22.5 6.6-27.6 17.8L194 150.2 47.1 171.5c-26.2 3.8-36.7 36-17.7 54.6l105.7 103-25 145.5c-4.5 26.2 23 46 46.4 33.7L288 439.6V0z"></path>
                                                    </svg>


                                                    <svg class="svg-inline--fa fa-star text-muted" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-muted" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-muted" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Bhubaneswar</p>
                                    </div>
                                    <p class="clent-message">Very nice location
                                    </p>
                                </div>
                            </div>
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">Mitalee Sinha</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>




                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Trip name - Dharmasthala, Udupi and Murudeshwar package from Bangalore</p>
                                    </div>
                                    <p class="clent-message">Went to Dharmasthala, Udupi and Murudeshwar Trip with my family by booking their package and I have only good things to say about that trip. The service provided by MyHoliday Happiness is commendable, they constantly kept a check on our location to avoid any issues, connected with us on a regular basis during our trip and checked if we were fine and everything was happening according to our liking. Definitely...
                                    </p>
                                </div>
                            </div>
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">Shikha</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>




                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Trip name - Agra 2 days trip</p>
                                    </div>
                                    <p class="clent-message">It was nice experience with MHH
                                    </p>
                                </div>
                            </div>
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">Mitalee Sinha</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>




                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Chikmagalur</p>
                                    </div>
                                    <p class="clent-message">family by booking their package and I have only good things to say about that trip. The service provided by MyHoliday Happiness is commendable, they constantly kept a check on our location to avoid any issues, connected with us on a regular basis during our trip and checked if we were fine and everything was happening according to our liking. Definitely going to try this again and recommend to others...
                                    </p>
                                </div>
                            </div>
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">Mitalee Sinha</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>




                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Chikmagalur</p>
                                    </div>
                                    <p class="clent-message">family by booking their package and I have only good things to say about that trip. The service provided by MyHoliday Happiness is commendable, they constantly kept a check on our location to avoid any issues, connected with us on a regular basis during our trip and checked if we were fine and everything was happening according to our liking. Definitely going to try this again and recommend to others...
                                    </p>
                                </div>
                            </div>
                            <div class="card client-review-card h-100">
                                <div class="card-body">
                                    <div class="client-details mb-2">
                                        <div class="d-flex gap-2 align-items-center">
                                            <i class="bi bi-person-circle"></i>
                                            <div>
                                                <p class="client-name">Sairam Tatikonda</p>
                                                <div class="rate d-flex">

                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>
                                                    <svg class="svg-inline--fa fa-star text-warning" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="star" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <path fill="currentColor" d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                                    </svg>




                                                </div>
                                            </div>

                                        </div>
                                        <p class="client-location text-secondary"><svg class="svg-inline--fa fa-location-dot" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="location-dot" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"></path>
                                            </svg>Coastal Karnataka</p>
                                    </div>
                                    <p class="clent-message">Distance between Shimoga to Chikmagalur by Road is, 97 Kms. Distance between Shimoga to Chikmagalur by Flight is, 71 Kms. Travel Time from Shimoga to ...
                                    </p>
                                </div>
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
    <section class="bg-light">
        <div class="container">
        <div class="section-title-container wowanimate__fadeInUp" data-wow-delay="200ms" style="visibility:visible;      animation-delay: 200ms; animation-name: fadeInUp;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h2 class="section-title-sm mb-0">About Coorg Tour Package</h2>
                        </div>
                    </div>
                <div class="about-content mb-3">
                    <!-- Description Preview with Truncated Content -->
                    <div class="description-preview" style="max-height: 200px; overflow: hidden; position: relative;">
                        <div class="fade-overlay" style="position: absolute; bottom: 0; left: 0; right: 0; height: 50px; background: linear-gradient(transparent, white);"></div>
                        <div class="description-full">
                            {!! $tourPageData->about_tag !!}
                        </div>
                    </div>

                    <!-- Toggle Button -->
                    <button class="moreless-button-about"
                        style="display: inline-block; background-color: #007bff; color: #fff; font-size: 0.95rem; text-decoration: none; padding: 6px 12px; border-radius: 20px; transition: all 0.3s ease; font-weight: 500;border:0">
                        Read more <span style="margin-left: 5px;">&#x25BC;</span>
                    </button>
                </div>
        </div>
    </section>

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
        $.ajax({
            url: "{{ route('website.allTourPackages') }}?page=" + page,
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

        $.ajax({
            url: "{{ route('website.allTourPackages') }}",
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
        const preview = $(this).siblings('.description-preview'); // Get the sibling description-preview

        // Toggle the expanded class for smooth transition
        preview.toggleClass('expanded');
        preview.find('.fade-overlay').toggleClass('d-none');

        // If the content is expanded, show full content, else show truncated content
        if (preview.hasClass('expanded')) {
            preview.css('max-height', 'none');
            $(this).html('Read less <span style="margin-left: 5px;">&#9650;</span>');
        } else {
            preview.css('max-height', '200px');
            $(this).html('Read more <span style="margin-left: 5px;">&#9660;</span>');
        }
    });

    $('.moreless-button').click(function () {
        const preview = $(this).siblings('.description-preview');

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