@include('website.include.webmeta')

{{-- Breadcrumb --}}
<script type="application/ld+json">
{!! json_encode([
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => [
        [
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Home",
            "item" => url('/')
        ],
        [
            "@type" => "ListItem",
            "position" => 2,
            "name" => "Contact us",
            "item" => route('website.contactus')
        ]
    ]
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</script>

{{-- Organization Schema --}}
<script type="application/ld+json">
{!! json_encode($organisationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- WebPage Schema --}}
<script type="application/ld+json">
{!! json_encode($webPageSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- Contact Us Schema --}}
<script type="application/ld+json">
{!! json_encode($contactUsSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@include('website.include.webheader')

<div class="breadcrumb-section">
    <div class="container">
        <h1 class="page-name">Contact Us</h1>
        <ul class="breadcrumb-list">
            <li class="breadcrumb-item">
                <a href="{{route('website.home')}}" class="breadcrumb-link"><i class="bi bi-house"></i></a>
            </li>
           
            <li class="breadcrumb-item">
                <a href="{{ route('website.contactus')}}" class="breadcrumb-link active">Contact Us</a>
            </li>
        </ul>
    </div>


</div>
<div class="page-area">
    <section class="contact-section">

        <div class="container">
            <div class="section-title-container wow animate__fadeInUp  "  data-wow-delay="200ms">
                <div>
                <p class="section-title-small">Contact Us</p>
                <h2 class="section-title">Feel free to write to us anytime</h2>
                </div>
            </div>
       
            <div class="row">
                <div class="col-lg-6">
                <ul class="contact-left-section">
                                <li class="d-flex gap-4 align-items-center">
                                    <span class="icon-box">
                                    <i class="bi bi-briefcase"></i>
                                    </span>
                                    <div>
                                        <h5>10 years of experiance</h5>
                                        <p>empowering enterprises to deliver value</p>
                                    </div>

                                </li>
                                <li class="d-flex gap-4 align-items-center">
                                    <span class="icon-box">
                                    <i class="bi bi-award"></i>
                                    </span>
                                    <div>
                                        <h5> Multiple Awards</h5>
                                        <p>Implemented across industries</p>
                                    </div>

                                </li>
                                <li class="d-flex gap-4 align-items-center">
                                    <span class="icon-box">
                                    <i class="bi bi-people"></i>
                                    </span>
                                    <div>
                                        <h5>Over 6000+ Clients</h5>
                                        <p>Implemented across industries</p>
                                    </div>

                                </li>
                                <!-- <li class="d-flex gap-4 align-items-center">
                                    <span class="icon-box">
                                    <i class="bi bi-people"></i>
                                    </span>
                                    <div>
                                        <h5>1600+ Agents</h5>
                                        <p> Experts at what they do</p>
                                    </div>

                                </li> -->
                               
                            </ul>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-3">
                        <div class="card-body p-md-4">
                            <h5 class="mb-2">Please fill this form</h5>
                            <form method="POST" id="contact_enquiry" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-3">
                                    <div class="mb-3">
                                        <label for="name" class="d-block">Name</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="d-block">Mobile No.</label>
                                        <input type="number" class="form-control" name="phone_number" id="phone_number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="d-block">Email</label>
                                        <input type="email" class="form-control" name="email_address" id="email_address">
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="d-block">Mesasage</label>
                                        <textarea class="form-control" placeholder="Leave your message here" id="comments" style="height: 100px" name="comments"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_SITE_KEY') }}"></div>
                                    </div>
                                    <div class="mb-3 mt-2">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="office-add-section">
        <div class="container">
            <div class="row g-3">
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        <h5>Corporate Office</h5>
                    <ul class="contact-wrapper">
                            <!-- <li>
                            <i class="bi bi-telephone"></i>
                                <a href="tel:+926669990000">+ 926669990000</a>
                            </li> -->
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:support@coorgpackages.com">support@coorgpackages.com</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p># 66 (old no 681), IInd Floor, 10th C Main Rd, 6th Block, Rajajinagar, Bengaluru, Karnataka 560010</p>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        <h5>Ooty Office </h5>
                    <ul class="contact-wrapper">
                            <!-- <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:+926669990000">+ 926669990000</a>
                            </li> -->
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:ooty@myholidayhappiness.com">ooty@myholidayhappiness.com</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>My Holiday Happiness, No. 5, Kil Thalayathimund, Ooty, Tamil Nadu India - 643001</p>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        <h5>Bhubaneswar Office</h5>
                    <ul class="contact-wrapper">
                            <!-- <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:+926669990000">+ 926669990000</a>
                            </li> -->
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:bhubaneswar@myholidayhappiness.com">bhubaneswar@myholidayhappiness.com</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>6402, Panchamukhi Enclave, RaghunathPur, Bhubaneswar, Dist Khurdha,Pin- 751002, Odisha</p>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        <h5>Andaman Office</h5>
                    <ul class="contact-wrapper">
                            <!-- <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:+926669990000">+ 926669990000</a>
                            </li> -->
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:andaman@myholidayhappiness.com">andaman@myholidayhappiness.com</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>Near N.K International sea shore road anarkali, Port Blair, Andaman and Nicobar Islands 744102</p>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        <h5>Shimla Office</h5>
                        <ul class="contact-wrapper">
                            <!-- <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:+926669990000">+ 926669990000</a>
                            </li> -->
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:shimla@myholidayhappiness.com">shimla@myholidayhappiness.com</a>
                            </li>
                            <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>Near Court Complex, Chakkar, Shimla, Himachal Pradesh 171005</p>
                            </li>
                        </ul>
                    </div>
                </div>
              </div>
              <div class="col-lg-4 md-6">
                <div class="card office-address">
                    <div class="card-body">
                        @php
                            $mobileNo   = $parameters->firstWhere('parid', 3)->par_value ?? '';
                            $LandlineNo = $parameters->firstWhere('parid', 14)->par_value ?? '';
                            $mailId     = $parameters->firstWhere('parid', 2)->par_value ?? '';
                        @endphp
                        <h5>Contact Us</h5>
                        <ul class="contact-wrapper">
                            <li>
                                <i class="bi bi-telephone-fill"></i>
                                <a href="tel:{{$mobileNo}}">{{$mobileNo}}</a>
                            </li>
                            <li>
                                <i class="bi bi-telephone"></i>
                                <a href="tel:{{$LandlineNo}}">{{$LandlineNo}}</a>
                            </li>
                            <li>
                                <i class="bi bi-envelope"></i>
                                <a href="mailto:{{$mailId}}">{{$mailId}}</a>
                            </li>
                            <!-- <li>
                                <i class="bi bi-geo-alt"></i>
                                <p>Near Court Complex, Chakkar, Shimla, Himachal Pradesh 171005</p>
                            </li> -->
                        </ul>
                    </div>
                </div>
              </div>
              
             
            </div>
        </div>
    </section>
    <div class="responsive-map mt-3">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31103.037150194585!2d77.554943!3d12.979549!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae3f2ed2301e45%3A0x89e7ba8485a43c37!2sMy%20Holiday%20Happiness!5e0!3m2!1sen!2sin!4v1741623414820!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>

</div>


@include('website.include.webfooter')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $('#contact_enquiry').on('submit', function(e) {
        e.preventDefault(); // 🔒 prevent normal form submit

        let name            = $('#customer_name').val().trim();
        let email           = $('#email_address').val().trim();
        let phone_number    = $('#phone_number').val().trim();
        let comment         = $('#comments').val().trim();
        let recaptcha       = grecaptcha.getResponse();

        if (name === '') {
            Swal.fire('Error', 'Please enter your name', 'error');
            return false;
        }

        if (phone_number === '') {
            Swal.fire('Error', 'Please enter your contact number', 'error');
            return false;
        } else if (!/^\d{10}$/.test(phone_number)) {
            Swal.fire('Error', 'Please enter a valid 10-digit contact number', 'error');
            return false;
        }

        if (email === '') {
            Swal.fire('Error', 'Please enter your email', 'error');
            return false;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            Swal.fire('Error', 'Please enter a valid email address', 'error');
            return false;
        }
        if (comment === '') {
            Swal.fire('Error', 'Please enter a message', 'error');
            return false;
        }
        if (recaptcha === '') {
            Swal.fire('Error', 'Please verify reCAPTCHA', 'error');
            return false;
        }

        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('website.addContacUs') }}",
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success');
                    $('#contact_enquiry')[0].reset();
                    grecaptcha.reset();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            }
        });
    });
</script>