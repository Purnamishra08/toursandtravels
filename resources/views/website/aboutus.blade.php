@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">About Us</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
          
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">About Us</a>
            </li>
        </ul>
    </div>
</div>
<div class="page-area">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title-container wow animate__fadeInUp" data-wow-delay="200ms" style="visibility: visible; animation-delay: 200ms; animation-name: fadeInUp;">
                        <div>
                            <p class="section-title-small">About Us</p>
                            <h2 class="section-title">Welcome to <br>My Holidays Happiness</h2>
                        </div>
                        
                    </div>
                    <p class="about-text">
                            We are a self-motivated team of travel experts at your very own company of My Holiday Happiness. 
                            Pioneer in the Tourism sector is our company which has an intricate chain of connections with some of the premium 
                            hotels and resort chains across Southern India. With great knowledge and experience in the hospitality industry, 
                            we are all set to make your vacations memorable.
                    </p>
                    <h4 class="highlight-text mt-5">Featured In</h4>
                    <ul class="m-0 p-0 d-flex  align-items-center gap-4 flex-wrap mt-3 w-75">
                        <li>
                            <a href="https://raindrops-insider.beehiiv.com/p/how-yellosa-khoday-is-providing-one-click-holiday-solutions-with-his-startup-my-holiday-happiness">
                                <img class="featured-img" src="{{ asset('assets/img/web-img/timesnext-logo.png') }}" alt="TimesNext" />
                            </a>
                        </li>
                        <li>
                            <a href="https://startup.siliconindia.com/vendor/my-holiday-happiness-innovating-the-future-of-tourism-while-prioritizing-customer-satisfaction-cid-20513.html">
                                <img class="featured-img" src="{{ asset('assets/img/web-img/startupcity-logo.jpg') }}" alt="Silicon india startup cty" />
                            </a>
                        </li>
                        <li>
                            <a href="https://corporateconnectglobal.com/category/impact-recognition-indias-highly-trusted-tours-travels-agency-to-watchout-2024/">
                                <img class="featured-img" src="{{ asset('assets/img/web-img/corporateconnectglobal.jpeg') }}" alt="Corporate connect" />
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <div class="about-img-container">
                    <img src="{{ asset('assets/img/web-img/about-img.png') }}" alt="img" />
                    
                    <div class="about-statistics">
                        <ul class="d-flex justify-content-between align-items-center w-100 mt-3">
                            <li>
                                <h2 class="mb-1">5k</h2>
                                <p class="text-secondary">Happy Traveler</p>
                            </li>
                            <li>
                                <h2 class="mb-1">90.7%</h2>
                                <p class="text-secondary">Satisfaction Rate</p>
                            </li>
                            <li>
                                <h2 class="mb-1">500+</h2>
                                <p class="text-secondary">Tour Completed</p>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            






        </div>

    </section>
    <section class="bg-light">
        <div class="container">
        <div class=" highlight-para">
            <h4 class="mb-2">Our Motto</h4>
            <p>"Your Happiness is our Happiness" <br>
                Customer satisfaction is our topmost priority. We at My Holiday Happiness direct all our efforts, hardwork and resources towards fulfilling our motto of satisfying our loyal customers. We closely work towards satisfying the expectations that our customers have with their vacation. </p>

            </div>
            <div class=" highlight-para">
            <h4 class="mb-2">Quality Services</h4>
            <p>"Your Happiness is our Happiness" <br>
                Customer satisfaction is our topmost priority. We at My Holiday Happiness direct all our efforts, hardwork and resources towards fulfilling our motto of satisfying our loyal customers. We closely work towards satisfying the expectations that our customers have with their vacation. </p>

            </div>
            <div class=" highlight-para mb-0">
            <h4 class="mb-2">Financial Security</h4>
            <p>"Your Happiness is our Happiness" <br>
                Customer satisfaction is our topmost priority. We at My Holiday Happiness direct all our efforts, hardwork and resources towards fulfilling our motto of satisfying our loyal customers. We closely work towards satisfying the expectations that our customers have with their vacation. </p>

            </div>
        </div>
    </section>
 
    <section>
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  "  data-wow-delay="200ms">
                <div>
                    
                    <h2 class="section-title">Explore Our Most Popular Tour</h2>
                </div>
                <a href="#" class=" btn btn-outline-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
            </div>
            <div class="card-wrapper">
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-2.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-21.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-22.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-23.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-24.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card tour-card">

                    <img class="card-img-top" src="{{ asset('assets/img/web-img/tour-img-25.png') }}" alt="img">
                    <div class="card-body">
                        <p class="card-lavel">
                            <i class="bi bi-clock"></i> <span>5 Day &amp; 6 night</span>
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                            <span class="text-secondary">8.0 Superb</span>
                        </div>
                        <h5 class="card-title">Etiam placerat dictum consequat an Pellentesque habitant morbi.</h5>
                        <div class="d-flex justify-content-between align-items-center mt-3">

                            <div class="p-card-info">
                                <span>From</span>
                                <h6>$91.00 <span>Per Person</span></h6>
                            </div>
                            <a href="../tourdetails" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                        </div>
                    </div>
                </div>
           
            </div>
        </div>
    </section>
   
</div>
@include('website.include.webfooter')