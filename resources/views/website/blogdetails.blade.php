@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Blogs</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
          
            <li class="breadcrumb-item">
                <a href="{{ route('website.blogdetails', ['slug' => $blog->blog_url]) }}" class="breadcrumb-link active">Blogs</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 blog-details-box">
                    <img src="{{ asset('storage/blog_images/' . $blog->image) }}" alt="{{ $blog->alttag_image }}" />
                    <h3 class="mt-2">{{ $blog->title }}</h3>
                    <ul class="mb-3">
                        <li><i class="bi bi-calendar"></i>{{ date('d-M-Y', strtotime($blog->created_date)) }}</li>

                    </ul>
                    <p>{!! $blog->content !!}</p>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-2">
                        <div class="card-header bg-white">
                        <h5 class="mt-3">Search Here</h5>
                        </div>
                        <div class="card-body">

                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="basic-addon1">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                            </div>
                           
                       
                        </div>

                    </div>
                    <div class="card ">
                        <div class="card-header bg-white">
                        <h5 class="mt-3">Recent Blog</h5>
                        </div>
                        <div class="card-body">
                            <ul class="m-0 p-0">
                            @if(isset($blogDataRecent) && count($blogDataRecent) > 0)
                                @foreach($blogDataRecent as $key => $values)
                                    <li class="d-flex gap-3 recent-blog-card ">
                                        <img class="card-img-top" src="{{ asset('storage/blog_images/' . $values->image) }}" alt="{{ $values->alttag_image }}" />
                                        <div>
                                            <a href="{{ route('website.blogdetails', ['slug' => $values->blog_url]) }}">{{$values->title}}</a>
                                            <ul>
                                                    <li><i class="bi bi-calendar"></i> {{ date('d-M-Y', strtotime($values->created_date)) }}</li>

                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                            </ul>
                        </div>
                    </div>


                </div>
            </div>







        </div>


    </section>

</div>
@include('website.include.webfooter')