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
    <section class="contact-section">
        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  " data-wow-delay="200ms">
                <div>
                    <p class="section-title-small">Faqs</p>
                    <h2 class="section-title"> Everything You Need to Know</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="accordion faq-accordion" id="accordionExample">
                        @foreach($faqData as $faqDatas)
                        @php $collapseId = 'collapse' . $loop->index; @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                                        <h6 class="mb-0">{{ $faqDatas->faq_question }}</h6>
                                    </button>
                                </h2>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $faqDatas->faq_answer !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card contact-card">
                        <div class="card-body">
                            <h4 class="text-white">Contact Us</h4>
                        <ul class="contact-wrapper mt-1">
                            <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:{{isset($parameters) ? $parameters[2]->par_value : ''}}">{{isset($parameters) ? $parameters[2]->par_value : ''}}</a>
                            </li>
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:{{isset($parameters) ? $parameters[3]->par_value : ''}}">{{isset($parameters) ? $parameters[3]->par_value : ''}}</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>{{isset($parameters) ? $parameters[0]->par_value : ''}}</p></p>
                            </li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div>
                <p class="section-title-small">Feature tours</p>
                <h2 class="section-title">Most Popular {{isset($placesData) ? $placesData->destination_name : ''}} Tour Packages</h2>
            </div>
            <div class="ajax-load text-center" style="display: none;">
                <p>Loading more packages...</.p>
            </div>
            <div class="card-wrapper" id="allTour"></div>
        </div>
    </section>
</div>
@include('website.include.webfooter')
<script>
    let isLoading = false;
    let finished = false;
    function loadPopularTourData() {
        if (finished) return;
        $.ajax({
            url: "{{ route('website.popularTourDataPlaces') }}",
            type: "get",
            beforeSend: function () {
                $('.ajax-load').show();
            }
        }).done(function (data) {
            if (data.trim().length == 0) {
                finished = true;
                $('.ajax-load').html("<p class='text-center'>No more records found</p>");
                return;
            }
            $('#allTour').append(data);
            isLoading = false;
            $('.ajax-load').hide();
        }).fail(function () {
            console.log("Server error");
            $('.ajax-load').hide();
        });
    }
    $(document).ready(function () {
        loadPopularTourData(true);
    });
</script>