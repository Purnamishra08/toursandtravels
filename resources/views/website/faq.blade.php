@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Faqs</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Faq</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>
                    <p class="section-title-small">Faqs</p>
                    <h2 class="section-title"> Everything You Need to Know</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="accordion faq-accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                  <h6>  How to search for tour package</h6>
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
                                <p ># 66 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar, Bengaluru, Karnataka 560010</p>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div>
                <p class="section-title-small">Feature tours</p>
                <h2 class="section-title">Most Popular Tour</h2>
            </div>
            <div class="card-wrapper">
            <div class="card tour-card" >
               
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
                       <h6>$91.00  <span>Per Person</span></h6>
                   </div>
                   <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
               </div>
           </div>
           <div class="card tour-card" >
               
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
                       <h6>$91.00  <span>Per Person</span></h6>
                   </div>
                   <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
               </div>
           </div>
           <div class="card tour-card" >
               
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
                       <h6>$91.00  <span>Per Person</span></h6>
                   </div>
                   <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
               </div>
           </div>
           <div class="card tour-card" >
               
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
                       <h6>$91.00  <span>Per Person</span></h6>
                   </div>
                   <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
               </div>
           </div>
           <div class="card tour-card" >
               
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
                       <h6>$91.00  <span>Per Person</span></h6>
                   </div>
                   <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                </div>
               </div>
           </div>
                <div class="card tour-card" >
               
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
                            <h6>$91.00  <span>Per Person</span></h6>
                        </div>
                        <a href="#" class="btn btn-outline-primary">Explore <i class="ms-2 bi bi-arrow-right-short"></i></a>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('website.include.webfooter')