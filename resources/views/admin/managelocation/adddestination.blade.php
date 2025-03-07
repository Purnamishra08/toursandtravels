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
                                <a href="{{ route('admin.destination.adddestination') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($Categorytags) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.destination') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                    </svg>
                                    View
                                </a>
                            </nav>
                            @include('Admin.include.sweetaleart')

                            <section class="content">
                                <div class="form-container" style="margin-bottom: 25px; box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16); background-color:#fff; padding:25px; border-radius: 4px;">
                                    <div class="panel-body">
                                        <div class="container">
                                            <form action="{{ route('admin.destination.adddestination') }}" method="POST" id="form_destination" name="form_destination" class="add-user" enctype="multipart/form-data">
                                                @csrf
                                                <div class="box-main">
                                                    <h3>Destination Details</h3>
                                                    <div class="row">
                                                        <!-- Destination Name -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter destination name" name="destination_name" id="destination_name" value="{{ old('destination_name') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Destination URL -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination Url</label>
                                                                <input type="text" class="form-control" readonly placeholder="Enter destination url" name="destination_url" id="destination_url" value="{{ old('destination_url') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Destination Types -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination Types</label>
                                                                <select data-placeholder="Choose destination type" class="chosen-select efilter" multiple tabindex="4" id="destination_type" name="destination_type[]" style="width: 100%;">
                                                                    @foreach($destinationTypes as $type)
                                                                        <option value="{{ $type->destination_type_id }}">{{ $type->destination_type_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                            
                                                        <!-- Destination Categories -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination Categories</label>
                                                                <select data-placeholder="Choose destination category" class="chosen-select efilter" multiple tabindex="4" id="edesti" name="edesti[]" style="width: 100%;">
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->catid }}">{{ $category->cat_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Getaway Tags -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Getaway Tags</label>
                                                                <select data-placeholder="Choose getaway tags" class="chosen-select" multiple tabindex="4" id="getatagid" name="getatagid[]" style="width: 100%;">
                                                                    @foreach($tags as $tag)
                                                                        <option value="{{ $tag->tagid }}">{{ $tag->tag_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Banner Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Banner Image</label>
                                                                <input name="destiimg" id="destiimg" type="file">
                                                                <span>Image size should be 2000px X 350px</span>
                                                            </div>
                                                        </div>

                                                        <!-- Destination Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination Image</label>
                                                                <input name="destismallimg" id="destismallimg" type="file">
                                                                <span>Image size should be 300px X 225px</span>
                                                            </div>
                                                        </div>

                                                        <!-- Alt Tag for Banner Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Alt Tag For Banner Image</label>
                                                                <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner') }}" maxlength="60">
                                                            </div>
                                                        </div>

                                                        <!-- Alt Tag for Destination Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Alt Tag For Destination Image</label>
                                                                <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb') }}" maxlength="60">
                                                            </div>
                                                        </div>

                                                

                                                        <!-- Show on Footer Menu -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Show on footer menu</label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1" {{ old('show_on_footer') ? 'checked' : '' }}>
                                                                        For footer menu
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Pick/Drop Price -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Pick / Drop Price ()</label>
                                                                <input type="text" class="form-control" placeholder="Enter Pick or Drop Price" name="pick_drop_price" id="pick_drop_price" value="{{ old('pick_drop_price') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Minimum Accommodation Price -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Minimum Accommodation Price /Person ()</label>
                                                                <input type="text" class="form-control" placeholder="Enter Minimum Accommodation price" name="accomodation_price" id="accomodation_price" value="{{ old('accomodation_price') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Latitude -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Latitude</label>
                                                                <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="{{ old('latitude') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Longitude -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Longitude</label>
                                                                <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                                            </div>
                                                        </div>

                                                        <!-- About Destination -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Destination</label>
                                                                <textarea name="short_desc" id="short_desc" class="form-control">{{ old('short_desc') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Places to Visit Text -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Places to Visit Text</label>
                                                                <textarea name="places_to_visit_desc" id="places_to_visit_desc" class="form-control">{{ old('places_to_visit_desc') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Common Information Section -->
                                                <div class="box-main">
                                                    <h3>Common Information</h3>
                                                    <div class="row">
                                                        <!-- Ideal Trip Duration -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Ideal Trip Duration</label>
                                                                <input type="text" class="form-control" placeholder="Ex- 3days / 2night" name="trip_duration" id="trip_duration" value="{{ old('trip_duration') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Nearest City -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Nearest City</label>
                                                                <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="{{ old('nearest_city') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Best Time to Visit -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Best Time To Visit</label>
                                                                <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="{{ old('visit_time') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Peak Season -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Peak Season</label>
                                                                <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="{{ old('peak_season') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Weather Info -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Weather Info</label>
                                                                <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="{{ old('weather_info') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Similar Destination -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Similar Destination</label>
                                                                <select data-placeholder="Choose Similar Destination" class="chosen-select efilter" multiple tabindex="4" id="other_info" name="other_info[]" style="width: 100%;">
                                                                    @foreach($similarDestinations as $destination)
                                                                        <option value="{{ $destination->destination_id }}">{{ $destination->destination_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Near By Place -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Near By Place</label>
                                                                <select data-placeholder="Choose Near By Place" class="chosen-select efilter" multiple tabindex="4" id="near_info" name="near_info[]" style="width: 100%;">
                                                                    @foreach($nearByPlaces as $place)
                                                                        <option value="{{ $place->destination_id }}">{{ $place->destination_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Other Information Section -->
                                                <div class="box-main">
                                                    <h3>Other Information</h3>
                                                    <div class="row">
                                                        <!-- Internet Availability -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Internet Availability</label>
                                                                <input type="text" class="form-control" placeholder="Enter Internet Availability" name="internet_avl" id="internet_avl" value="{{ old('internet_avl') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Std Code -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Std Code</label>
                                                                <input type="text" class="form-control" placeholder="Enter Std Code" name="std_code" id="std_code" value="{{ old('std_code') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Languages Spoken -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Languages Spoken</label>
                                                                <input type="text" class="form-control" placeholder="Enter Languages Spoken" name="lng_spk" id="lng_spk" value="{{ old('lng_spk') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Major Festivals -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Major Festivals</label>
                                                                <input type="text" class="form-control" placeholder="Enter Major Festivals" name="mjr_fest" id="mjr_fest" value="{{ old('mjr_fest') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Notes/Tips -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Notes/Tips</label>
                                                                <textarea class="form-control" placeholder="Notes/Tips..." name="note_tips" id="note_tips">{{ old('note_tips') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Google Map -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Google Map</label>
                                                                <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map">{{ old('google_map') }}</textarea>
                                                                Example : &lt;iframe src="https://www.google.com/maps/d/embed?mid=19xHbU7LdnDtVsj_gR5u6EpnQ4OM&hl=en" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen&gt; &lt;/iframe&gt;
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Meta Tags Section -->
                                                <div class="box-main">
                                                    <h3>Meta Tags</h3>
                                                    <div class="row">
                                                        <!-- Overview Meta Tags -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Meta Title</label>
                                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title">{{ old('meta_title') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Meta Keyword</label>
                                                                <textarea name="meta_keywords" id="meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('meta_keywords') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Meta Description</label>
                                                                <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('meta_description') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Place Meta Tags -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Meta Title</label>
                                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="place_meta_title" id="place_meta_title">{{ old('place_meta_title') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Meta Keyword</label>
                                                                <textarea name="place_meta_keywords" id="place_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('place_meta_keywords') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Meta Description</label>
                                                                <textarea name="place_meta_description" id="place_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('place_meta_description') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Package Meta Tags -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Package Meta Title</label>
                                                                <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="pckg_meta_title" id="pckg_meta_title">{{ old('pckg_meta_title') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Package Meta Keyword</label>
                                                                <textarea name="pckg_meta_keywords" id="pckg_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('pckg_meta_keywords') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Package Meta Description</label>
                                                                <textarea name="pckg_meta_description" id="pckg_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('pckg_meta_description') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6">
                                                    <div class="reset-button">
                                                        <button type="submit" class="btn redbtn" name="btnSubmit" id="btnSubmit">Save</button>
                                                        <button name='reset' type="reset" value='Reset' class="btn blackbtn">Reset</button>
                                                    </div>
                                                </div>
                                            </xform>
                                        </div>
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
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>   
    <!-- JavaScript for Image Preview -->
    <script>
         document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('short_desc');
            CKEDITOR.replace('places_to_visit_desc');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        
        $(document.body).on('keyup change', '#tag_name', function() {
			$("#tag_url").val(name_to_url($(this).val()));
		});
		function name_to_url(name) {
			name = name.toLowerCase(); // lowercase
			name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
			name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
			name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
			return name;
		}
        function previewImage(event, previewId) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById(previewId);
                output.innerHTML = '<img src="' + reader.result + '" alt="Preview" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        function validator() {
            if(!blankCheck('tag_name', 'Tag name cannot be blank'))
                return false;
            if(!blankCheck('tag_url', 'Tag name cannot be blank'))
                return false;
            if(!selectDropdown('menuid', 'Menu is required'))
                return false;
            if(!selectDropdown('catId', 'Category is required'))
                return false;
            if(!validateFilePresence('menutag_img', 'Banner image is required.'))
                return false;
            if(!validateFilePresence('menutagthumb_img', 'Getaways/Tour Image is required.'))
                return false;
            if (!blankCheck('alttag_banner', 'Banner Alt Tag cannot be blank'))
                 return false;
            if (!blankCheck('alttag_thumb', 'Alt Tag For Getaways Image cannot be blank'))
                 return false;
            if (!blankCheck('about_tag', 'About Tag cannot be blank'))
                 return false;
            if (!blankCheck('meta_title', 'Meta Title cannot be blank'))
                 return false;
            if (!blankCheck('meta_keywords', 'Meta Keywords cannot be blank'))
                 return false;
            if (!blankCheck('meta_description', 'Meta Description cannot be blank'))
                 return false;
        }
        function getCategory(selectElement) {
            var menuId = selectElement.value;
        
            if (menuId) {
                $.ajax({
                    url: "{{ url('/categorytags/getCategoryMenuWise') }}", // Route for AJAX request
                    type: "POST",
                    data: { menu_id: menuId },
                    dataType: "json",
                    cache: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        var categorySelect = $('#catId');
                        categorySelect.empty(); // Clear previous categories
                        categorySelect.append('<option value=""> -- Select category --</option>'); // Default option
                        
                        // Loop through the categories returned from the controller
                        $.each(response.categories, function(index, category) {
                            var selected = '';
                            if (category.catid == '{{ old('catId', $Categorytags->cat_id ?? '') }}') {
                                selected = 'selected';
                            }
                            categorySelect.append('<option value="' + category.catid + '" ' + selected + '>' + category.cat_name + '</option>');
                        });
                    }
                });
            } else {
                $('#catId').empty().append('<option value=""> -- Select category --</option>'); // Reset if no menu selected
            }
        }
    </script>
</body>
</html>
