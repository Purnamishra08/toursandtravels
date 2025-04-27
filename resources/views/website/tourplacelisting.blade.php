@include('website.include.webmeta')
@include('website.include.webheader')
<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">{{!empty($placesData) ? $placesData->place_name : ''}}</h1>
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
                    <!-- <p class="section-title-small">Feature tours</p> -->
                    <h2 class="section-title"> {{!empty($countAndPrice) ? $countAndPrice->total_packages : 0}} {{!empty($placesData) ? $placesData->place_name : ''}} Tour Packages Found.</h2>
                </div>
            </div>
            <div class="card-wrapper">
                @foreach($tours as $values)
                    <div class="card tour-card">
                        <img class="card-img-top" src="{{ asset('storage/tourpackages/thumbs/' . $values->tour_thumb) }}" alt="{{ $values->alttag_thumb }}">

                        @if($values->pack_type == 15)
                            <span class="badge">Most popular</span>
                        @endif

                        <div class="card-body">
                            <p class="card-lavel">
                                <i class="bi bi-clock"></i> {{ str_replace('/', '&', $values->duration_name) }}
                                <small class="d-block">Ex- {{ $values->destination_name }}</small>
                            </p>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="{{ asset('assets/img/web-img/single-star.png') }}" alt="Rating">
                                <span class="text-secondary">{{ $values->ratings }} Star</span>
                            </div>

                            <h5 class="card-title">{{ $values->tpackage_name }}</h5>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="p-card-info">
                                    <h6 class="mb-0"><span>₹</span> {{ $values->price }}</h6>
                                    <strike>₹ {{ $values->fakeprice }}</strike>
                                </div>
                                <a href="{{ route('website.tourDetails', ['slug' => $values->tpackage_url]) }}" class="btn btn-outline-primary stretched-link" target="_blank">
                                    Explore <i class="ms-2 bi bi-arrow-right-short"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</div>
@include('website.include.webfooter')