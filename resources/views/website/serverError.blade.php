@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        
    </div>


</div>
<div class="page-area">
    <section>
        <div class="container">
            <div class="text-center">
            <img class="error-img" src="{{ asset('assets/img/web-img/500Error-1.jpg') }}" alt="error-img">
           
            </div>
            <div class="text-center mt-3">
            <a class=" btn btn-primary" href="{{route('website.home')}}"><i class="bi bi-house me-1"></i>Back to Home</a>

            </div>
        </div>
    </section>
   
</div>
@include('website.include.webfooter')
