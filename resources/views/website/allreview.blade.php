@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Recent My Holiday Happiness Reviews</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="{{route('website.allreview')}}" class="breadcrumb-link active">My Holiday Happiness Reviews</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>

                    <h2 class="section-title"> Recent My Holiday Happiness Reviews</h2>
                </div>
            </div>
            <div class="review-wrapper View_all-review-wrapper thin-scroll">
                @if(isset($reviewData))
                    @foreach($reviewData as $review)
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
                                        </svg>{{$review->reviewer_loc}}</p>



                                </div>
                                <p class="clent-message"> {{$review->feedback_msg}} </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No Reviews Found !.</p>
                @endif
            </div>

        </div>
    </section>

</div>
@include('website.include.webfooter')