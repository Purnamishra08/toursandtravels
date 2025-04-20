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
                                <h2 class="mb-1">7k</h2>
                                <p class="text-secondary">Happy Traveler</p>
                            </li>
                            <li>
                                <h2 class="mb-1">100%</h2>
                                <p class="text-secondary">Satisfaction Rate</p>
                            </li>
                            <li>
                                <h2 class="mb-1">5000+</h2>
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
            {!! isset($aboutus) ? $aboutus->page_content: '' !!}
            <!-- <div class=" highlight-para">
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

            </div> -->
        </div>
    </section>
 
    <section>
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  "  data-wow-delay="200ms">
                <div>
                    
                    <h2 class="section-title">Explore Our Most Popular {{isset($placesData) ? $placesData->destination_name : ''}} Tour Packages</h2>
                </div>
                <a href="{{route('website.allTourPackages')}}" target="_blank" class=" btn btn-primary">View all <i class="ms-2 bi bi-arrow-right-short"></i></a>
            </div>
            <div class="card-wrapper" id="allTour">
            </div>
        </div>
    </section>
   
</div>
@include('website.include.webfooter')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
<script>
    let page = 1;
    let isLoading = false;
    let finished = false;
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
        loadPopularTourData(true);
    });
</script>