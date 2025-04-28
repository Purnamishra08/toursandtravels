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
<div class="loader">
  <div class="circle">
    <img class="world-map" src="{{ asset('assets/img/web-img/globe.png') }}" alt="World Map" />
    <div class="airplane">✈️</div>
  </div>
  <div class="loading-text">Loading...</div>
</div>
 
</div>
@include('website.include.webfooter')