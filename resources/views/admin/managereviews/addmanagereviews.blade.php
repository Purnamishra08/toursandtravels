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
                                <a href="{{ isset($reviews) ? route('admin.managereviews.editreviews', ['id' => $reviews->review_id]) : route('admin.managereviews.addreviews') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($reviews) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.managereviews') }}" class="tab-menu__item">
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
                                        
                                            <form action="{{ isset($reviews) ? route('admin.managereviews.editreviews', ['id' => $reviews->review_id]) : route('admin.managereviews.addreviews') }}" method="POST" id="form_destination" name="form_destination" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                @csrf
                                                <div class="box-main">
                                                    
                                                    <fieldset>
                                                        <legend> Reviews Details</legend>
                                                        <div class="row">
                                                            <!-- Reviewer Name -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Name <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter reviewer name" name="reviewer_name" id="reviewer_name" value="{{ old('reviewer_name', $reviews->reviewer_name ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Reviewer Location -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Location <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter reviewer location" name="reviewer_loc" id="reviewer_loc" value="{{ old('reviewer_loc', $reviews->reviewer_loc ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Ratings <span class="manadatory">*</span></label>
                                                                    <select class="form-control" name="no_of_star" id="no_of_star">
                                                                        <option value="0">Select Rating</option>
                                                                        <option value="1" {{ old('no_of_star', $reviews->no_of_star ?? '') == '1' ? 'selected' : '' }}>1</option>
                                                                        <option value="1.5" {{ old('no_of_star', $reviews->no_of_star ?? '') == '1.5' ? 'selected' : '' }}>1.5</option>
                                                                        <option value="2" {{ old('no_of_star', $reviews->no_of_star ?? '') == '2' ? 'selected' : '' }}>2</option>
                                                                        <option value="2.5" {{ old('no_of_star', $reviews->no_of_star ?? '') == '2.5' ? 'selected' : '' }}>2.5</option>
                                                                        <option value="3" {{ old('no_of_star', $reviews->no_of_star ?? '') == '3' ? 'selected' : '' }}>3</option>
                                                                        <option value="3.5" {{ old('no_of_star', $reviews->no_of_star ?? '') == '3.5' ? 'selected' : '' }}>3.5</option>
                                                                        <option value="4" {{ old('no_of_star', $reviews->no_of_star ?? '') == '4' ? 'selected' : '' }}>4</option>
                                                                        <option value="4.5" {{ old('no_of_star', $reviews->no_of_star ?? '') == '4.5' ? 'selected' : '' }}>4.5</option>
                                                                        <option value="5" {{ old('no_of_star', $reviews->no_of_star ?? '') == '5' ? 'selected' : '' }}>5</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class=""> 
                                                                    <label>Feedback <span class="manadatory">*</span></label>
                                                                    <textarea name="feedback_msg" id="feedback_msg" class="form-control">{{ old('feedback_msg', $reviews->feedback_msg ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Associated Tour Tags</label>
                                                                    <select data-placeholder="Choose associated tour tags" class="chosen-select" multiple tabindex="4" id="getatagid" name="getatagid[]" style="width: 100%;">
                                                                        @foreach($tags as $tag)
                                                                            <option value="{{ $tag->tagid }}"
                                                                                @if(isset($reviews->tourtagid) && in_array($tag->tagid, explode(',', $reviews->tourtagid))) selected @endif>
                                                                                {{ $tag->tag_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="reset-button">
                                                        <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($reviews) ? 'Update' : 'Save' }}</button>
                                                        <button name='reset' type="reset" value='Reset' class="btn btn-secondary">Reset</button>
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
    <script src="{{ asset('assets/js/validation.js') }}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script>
         $(document).ready(function () {
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
        function validator() {
            // Validate text fields
            if (!blankCheck('reviewer_name', 'Reviewer name cannot be blank')) return false;
            if (!blankCheck('reviewer_loc', 'Reviewer location cannot be blank')) return false;
            if (!selectDropdown('no_of_star', 'Please select Ratings ')) return false;
            if (!blankCheck('feedback_msg', 'Alt Tag For Getaways Image cannot be blank')) return false;

            return true;
        }
    </script>
</body>
</html>
