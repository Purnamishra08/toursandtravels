@include('website.include.webmeta')
@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Blogs</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
            
            <li class="breadcrumb-item">
                <a href="#" class="breadcrumb-link active">Blogs</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>
                    <p class="section-title-small">FROM OUR BLOG</p>
                    <h2 class="section-title"> OUR RECENT POSTS</h2>
                </div>
            </div>
            <div class="recent-post-wrapper">
                @if(isset($blogData) && count($blogData) > 0)
                    @foreach($blogData as $key => $values)
                        <div class="card recent-post-card wow animate__fadeInUp  " data-wow-delay="200ms">
                            <img src="{{ asset('storage/blog_images/' . $values->image) }}" alt="{{ $values->alttag_image }}" />
                            <p class="tour-badge">Travel</p>
                            <div class="card-body">
                                <ul>
                                    <li><i class="bi bi-calendar"></i> {{ date('d-M-Y', strtotime($values->created_date)) }}</li>
                                </ul>
                                <h5 class="card-title mt-3">
                                    {{$values->title}}
                                </h5>
                                <p>{!! implode(' ', array_slice(explode(' ', $values->content), 0, 30)) !!}</p>
                                <div class="text-end mt-2">
                                <a href="../blogdetails" class="btn btn-outline-primary">Read More <i class="ms-2 bi bi-arrow-right-short"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <span>No record found.</span>
                @endif
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-primary">Load More</button>
            </div>
        </div>


    </section>

</div>
@include('website.include.webfooter')