<!-- Metaheader Section-->
@include('Admin.include.metaheader')
<!-- Metaheader Section End -->
<body>
    <div id="layoutSidenav">
        <!-- Left Navbar Start-->
        @include('Admin.include.leftNavbar')
        <!-- Left Navbar End-->

        <div id="layoutSidenav_content">
            <div class="content-body">

                <!-- TopBar header Start-->
                @include('Admin.include.topBarHeader')
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
                            @include('Admin.include.sweetaleart')

                            <section class="content">
                                <div class="form-container">
                                    <div class="panel-body">
                                        
                                            <form action="{{ isset($packagefaq) ? route('admin.packagefaqs.editpackagefaqs', ['id' => $packagefaq->faq_id]) : route('admin.packagefaqs.addpackagefaqs') }}" method="POST" id="form_packagefaq" name="form_packagefaq" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                @csrf
                                                <div class="box-main">
                                                    <fieldset>
                                                        <legend> Package Faqs Details</legend>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Tour Package <span class="manadatory">*</span></label>
                                                                    <select data-placeholder="Choose getaway tags" class="form-control" tabindex="4" id="tag_id" name="tag_id" style="width: 100%;">
                                                                        <option value=''>--Select Package</option>
                                                                        @foreach($tags as $tag)
                                                                            <option value="{{ $tag->tagid }}"
                                                                                @if(isset($packagefaq) && $tag->tagid == $packagefaq->tag_id) selected @endif>
                                                                                {{ $tag->tag_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Question <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Faq question" name="faq_question" id="faq_question" value="{{ old('faq_question', $packagefaq->faq_question ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class=""> 
                                                                    <label>Answer <span class="manadatory">*</span></label>
                                                                    <textarea name="faq_answer" id="faq_answer" class="form-control">{{ old('faq_answer', $packagefaq->faq_answer ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Order No <span class="manadatory">*</span></label>
                                                                    <input type="number" class="form-control" placeholder="Order no" name="faq_order" id="faq_order" value="{{ old('faq_order', $packagefaq->faq_order ?? '') }}">
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
                @include('Admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
    <!-- FooterJs End-->
    
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
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
            if (!selectDropdown('tag_id', 'Please select a Tour package')) return false;
            if (!blankCheck('faq_question', 'Question name cannot be blank')) return false;
            if (!blankCheck('faq_answer', 'Answer cannot be blank')) return false;
            if (!onlyNumeric('faq_order', 'Order no must be a number')) return false;

            return true;
        }
    </script>
</body>
</html>
