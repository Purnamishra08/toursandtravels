@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Privacy-Policy</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')  }}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>

            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Privacy-Policy</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section>
        <div class="container">
            <div class="page-section">
                {!! $privacyPolicy->page_content !!}
            </div>
        </div>


    </section>

  

</div>


@include('website.include.webfooter')