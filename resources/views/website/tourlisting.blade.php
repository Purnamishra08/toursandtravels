@include('website.include.webmeta')
@include('website.include.webheader')
<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Tours</h1>
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
                    <p class="section-title-small">Feature tours</p>
                    <h2 class="section-title"> Most Popular Tour</h2>
                </div>
            </div>
            <div class="card-wrapper" id="allTour">
            </div>
            <!-- <div class="text-center mt-4">
                <button class="btn btn-primary">Load More</button>

            </div> -->
            
                

            

        </div>


    </section>

</div>
@include('website.include.webfooter')

<script>
    var page = 1;
    var isLoading = false;
    var finished = false;


    function loadPopularTour(page) {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.allTourPackages') }}?page=" + page,
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
            $('#allTour').append(data);
            isLoading = false;
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }

    // Initial load
    $(document).ready(function () {
        loadPopularTour(page);
    });
</script>