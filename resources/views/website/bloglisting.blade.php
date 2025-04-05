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
                <a href="{{route('website.bloglisting')}}" class="breadcrumb-link active">Blogs</a>
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
            <div class="recent-post-wrapper" id="post-data">
            </div>
            <div class="ajax-load text-center my-4" style="display: none;">
                <p><i class="fa fa-spinner fa-spin"></i> Loading More...</p>
            </div>
        </div>


    </section>

</div>
@include('website.include.webfooter')
<script>
    var page = 1;
    var isLoading = false;
    var finished = false;

    function loadMoreData(page) {
        if (finished) return;

        $.ajax({
            url: "{{ route('website.bloglisting') }}?page=" + page,
            type: "get",
            beforeSend: function () {
                $('.ajax-load').show();
            }
        }).done(function (data) {
            if (data.trim().length == 0) {
                $('.ajax-load').html("<p>No more records found</p>");
                finished = true;
                return;
            }
            $('.ajax-load').hide();
            $('#post-data').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    // Initial load
    $(document).ready(function () {
        loadMoreData(page);
    });

    // Infinite scroll
    $(window).scroll(function () {
        if (isLoading || finished) return;
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
            isLoading = true;
            page++;
            loadMoreData(page);
        }
    });
</script>