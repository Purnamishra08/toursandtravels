@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <img
        src="{{ asset('assets/img/web-img/innerpage-baner.png') }}"
        width="1920"
        height="250"
        fetchpriority="high"
        decoding="async"
        style="width: 100%; height: 100%; position: absolute; z-index: -1;"
    >
    <div class="container" style="padding-bottom: 2rem">
        <h1 class="page-name">Booking-Policy</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')  }}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Booking-Policy</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section>
        <div class="container">
            <div class="page-section " >
                {!! isset($bookingPolicy) ? $bookingPolicy->page_content : '' !!}
            </div>
        </div>


    </section>

  

</div>


@include('website.include.webfooter')