<!-- Metaheader Section-->
@include('admin.include.metaheader')
<!-- Metaheader Section End -->
<body>
    <div id="layoutSidenav">
        <!-- Left Navbar Start-->
        @include('admin.include.leftNavbar')
        <!-- Left Navbar End-->

        <div id="layoutSidenav_content">
            <div class="content-body">

                <!-- TopBar header Start-->
                @include('admin.include.topBarHeader')
                <!-- TopBar header End -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ isset($packagefaq) ? route('admin.packagefaqs.editpackagefaqs', ['id' => $packagefaq->faq_id]) : route('admin.packagefaqs.addpackagefaqs') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($packagefaq) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.packagefaqs') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                                <!-- table-utilities -->
                                <div class="table-utilities">
                                    <strong class="manadatory me-1">*</strong>Indicates Mandatory
                                </div>
                                <!-- table-utilities end-->
                            </nav>
                            @include('admin.include.sweetaleart')

                            <section class="content">
                                <div class="form-container">
                                    <div class="panel-body">
                                        
                                            <form action="{{ isset($packagefaq) ? route('admin.packagefaqs.editpackagefaqs', ['id' => $packagefaq->faq_id]) : route('admin.packagefaqs.addpackagefaqs') }}" method="POST" id="form_packagefaq" name="form_packagefaq" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                @csrf
                                                <div class="box-main">
                                                    <fieldset>
                                                        <legend>Package FAQs Details</legend>

                                                        <div class="row">
                                                            <!-- Faq Type -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="faq_type">FAQ Type <span class="manadatory">*</span></label>
                                                                    <select class="form-control" id="faq_type" name="faq_type" onchange="callPackage(this.value)" style="width: 100%;">
                                                                        <option value="">--Select Package--</option>
                                                                        <option value="1" {{ (old('faq_type', $packagefaq->faq_type ?? '') == 1) ? 'selected' : '' }}>Package FAQ</option>
                                                                        <option value="2" {{ (old('faq_type', $packagefaq->faq_type ?? '') == 2) ? 'selected' : '' }}>Quick Links FAQ</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Tour Package -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="tag_id">Tour Package <span class="manadatory">*</span></label>
                                                                    <select class="form-control" id="tag_id" name="tag_id" style="width: 100%;">
                                                                        <option value="">--Select Tour Package--</option>
                                                                        <!-- Options will be loaded dynamically via AJAX -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <!-- FAQ Question -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="faq_question">Question <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" id="faq_question" name="faq_question" placeholder="Enter FAQ question" value="{{ old('faq_question', $packagefaq->faq_question ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- FAQ Answer -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="faq_answer">Answer <span class="manadatory">*</span></label>
                                                                    <textarea class="form-control" id="faq_answer" name="faq_answer" placeholder="Enter FAQ answer">{{ old('faq_answer', $packagefaq->faq_answer ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Order No -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="faq_order">Order No <span class="manadatory">*</span></label>
                                                                    <input type="number" class="form-control" id="faq_order" name="faq_order" placeholder="Order no" value="{{ old('faq_order', $packagefaq->faq_order ?? '') }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="reset-button">
                                                        <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($packagefaq) ? 'Update' : 'Save' }}</button>
                                                        @if(!isset($packagefaq))
                                                            <button name='reset' type="reset" value='Reset' class="btn btn-secondary">Reset</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </form>
                                      
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>

                <!-- Footer Start-->
                @include('admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('admin.include.footerJs')
    <!-- FooterJs End-->
    
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
        const selectedTagId = "{{ old('tag_id', $packagefaq->tag_id ?? '') }}";
        $(document).ready(function () {
            let faqType = $('#faq_type').val();
            if (faqType) {
                callPackage(faqType);
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('faq_answer');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        function validator() {
            // Validate text fields
            if (!selectDropdown('faq_type', 'Please select a Faq type')) return false;
            if (!selectDropdown('tag_id', 'Please select a Tour package')) return false;
            if (!blankCheck('faq_question', 'Question name cannot be blank')) return false;
            if (!blankCheck('faq_answer', 'Answer cannot be blank')) return false;
            if (!onlyNumeric('faq_order', 'Order no must be a number')) return false;

            return true;
        }
        function callPackage(val) {
            $.ajax({
                url: "{{ route('website.faqType') }}",
                method: 'POST',
                data: {
                    valData: val
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let options = `<option value=''>--Select Package</option>`;
                        response.data.forEach(item => {
                            let selected = (item.id == selectedTagId) ? 'selected' : '';
                            options += `<option value="${item.id}" ${selected}>${item.packageName}</option>`;
                        });
                        $('#tag_id').html(options);
                    } else {
                        $('#tag_id').html(`<option value=''>No packages found</option>`);
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Something went wrong. Try again.', 'error');
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>
