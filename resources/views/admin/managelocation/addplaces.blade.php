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
                                <a href="{{ isset($placesData) ? route('admin.places.editplaces', ['id' => $placesData->placeid]) : route('admin.places.addplaces') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($placesData) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.places') }}" class="tab-menu__item">
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
                                        <form action="{{ isset($placesData) ? route('admin.places.editplaces', ['id' => $placesData->placeid]) : route('admin.places.addplaces') }}" method="POST" id="form_destination" name="form_destination" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                            @csrf
                                            <div class="box-main">
                                                
                                                <fieldset>
                                                    <legend> Place Details</legend>
                                                    <div class="row">
                                                        <!-- Place Name -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Name  <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter place name" name="place_name" id="place_name" value="{{ old('place_name', $placesData->place_name ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Place URL -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Url <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter place url" name="place_url" id="place_url" value="{{ old('place_url', $placesData->place_url ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Destination -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Destination <span class="manadatory">*</span></label>
                                                                <select data-placeholder="Choose destination type" tabindex="4" id="destination_id" name="destination_id" style="width: 100%;" class="form-control">
                                                                    <option value="">--Select Destination--</option>
                                                                    @foreach($destinations as $type)
                                                                        <option value="{{ $type->destination_id }}"  {{ (isset($placesData) && $placesData->destination_id == $type->destination_id) ? 'selected' : '' }}>
                                                                            {{ $type->destination_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Place Types -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Type</label>
                                                                    <select data-placeholder="Choose destination type" class="chosen-select form-select efilter" multiple tabindex="4" id="place_type" name="place_type[]" style="width: 100%;">
                                                                        @foreach($destinationTypes as $type)
                                                                            <option value="{{ $type->destination_type_id }}"
                                                                                @if(!empty($selectedDestinationTypes) && in_array($type->destination_type_id, $selectedDestinationTypes)) 
                                                                                    selected 
                                                                                @endif>
                                                                                {{ $type->destination_type_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        <!-- Banner Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Banner Image <span class="manadatory">*</span></label>
                                                                <input name="placeimg" id="placeimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview')">
                                                                <span>Image size should be 1900px X 300px</span>
                                                                <div id="banner_preview" style="margin-top: 10px;">
                                                                    @if(isset($placesData->placeimg))
                                                                        <a href="{{ asset('storage/place_images/'.$placesData->placeimg) }}" target="_blank">
                                                                            <img id="bannerPreview"
                                                                                src="{{ asset('storage/place_images/'.$placesData->placeimg) }}"
                                                                                alt="Banner Preview"
                                                                                class="img-fluid rounded border"
                                                                                style="width: 400px; height: 200px; object-fit: cover;">
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Place Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Place Image <span class="manadatory">*</span></label>
                                                                <input name="placethumbimg" id="placethumbimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview_dest')">
                                                                <span>Image size should be 500px X 300px</span>
                                                                <div id="banner_preview_dest" style="margin-top: 10px;">
                                                                    @if(isset($placesData->placethumbimg))
                                                                        <a href="{{ asset('storage/place_images/thumbs/'.$placesData->placethumbimg) }}" target="_blank">
                                                                            <img id="bannerPreviewDest"
                                                                                src="{{ asset('storage/place_images/thumbs/'.$placesData->placethumbimg) }}"
                                                                                alt="Banner Preview Destination"
                                                                                class="img-fluid rounded border"
                                                                                style="width: 400px; height: 200px; object-fit: cover;">
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Alt Tag for Banner Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Alt Tag For Banner Image <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner', $placesData->alttag_banner ?? '') }}" maxlength="60">
                                                            </div>
                                                        </div>

                                                        <!-- Alt Tag for Place Image -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Alt Tag For Place Image <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb', $placesData->alttag_thumb ?? '') }}" maxlength="60">
                                                            </div>
                                                        </div>

                                                        <!-- Latitude -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Latitude <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="{{ old('latitude', $placesData->latitude ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Longitude -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Longitude <span class="manadatory">*</span></label>
                                                                <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="{{ old('longitude', $placesData->longitude ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>To Find Latitude and Longitude Click <a href="http://www.latlong.net" target="_blank" style="color:#18c4c0">http://www.latlong.net</a></label>
                                                            </div>
                                                        </div>

                                                        <!-- Show on Home Menu -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Show Home</label>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="checkbox" name="show_in_home" id="show_in_home" value="1" {{ old('show_in_home', $placesData->show_in_home ?? '') ? 'checked' : '' }}>
                                                                        For Home Page
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- About Destination -->
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>About Place <span class="manadatory">*</span></label>
                                                                <textarea name="short_desc" id="short_desc" class="form-control">{{ old('short_desc', $placesData->about_place ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <!-- Common Information Section -->
                                            <div class="box-main">
                                                
                                                <fieldset>
                                                    <legend>Common Information</legend>
                                                    <div class="row">
                                                        <!-- Best Time to Visit -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Travel Tips</label>
                                                                <textarea name="travel_tips" id="travel_tips" class="form-control" placeholder="travel tips...">{{ old('travel_tips', $placesData->travel_tips ?? '') }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Peak Season -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Distance from near by city</label>
                                                                <input type="text" class="form-control" placeholder="Ex-From Mysore Junction : 2.5 Kms" name="distance_from_nearest_city" id="distance_from_nearest_city" value="{{ old('distance_from_nearest_city', $placesData->distance_from_nearest_city ?? '') }}">
                                                            </div>
                                                        </div>

                                                        <!-- Google Map -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Google Map</label>
                                                                <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map">{{ old('google_map', $placesData->google_map ?? '') }}</textarea>
                                                                <b>Example :</b><p style="color:#18c4c0"> &lt;iframe src="https://www.google.com/maps/d/embed?mid=19xHbU7LdnDtVsj_gR5u6EpnQ4OM&hl=en" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen&gt; &lt;/iframe&gt;</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <!-- Meta Tags Section -->
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend>Place Meta Tags</legend>
                                                        <div class="row">
                                                            <!-- Place Meta Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Meta Title</label>
                                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="place_meta_title" id="place_meta_title">{{ old('place_meta_title', $placesData->meta_title ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Meta Keyword</label>
                                                                    <textarea name="place_meta_keywords" id="place_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('place_meta_keywords', $placesData->meta_keywords ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Meta Description</label>
                                                                    <textarea name="place_meta_description" id="place_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('place_meta_description', $placesData->meta_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </fieldset>
                                            </div>
                                            
                                            <div class="box-main">
                                                <fieldset>
                                                    <legend>Package Meta Tags</legend>
                                                        <div class="row">
                                                            <!-- Package Meta Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Meta Title</label>
                                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="pckg_meta_title" id="pckg_meta_title">{{ old('pckg_meta_title', $placesData->pckg_meta_title ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Meta Keyword</label>
                                                                    <textarea name="pckg_meta_keywords" id="pckg_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('pckg_meta_keywords', $placesData->pckg_meta_keywords ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Meta Description</label>
                                                                    <textarea name="pckg_meta_description" id="pckg_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('pckg_meta_description', $placesData->pckg_meta_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </fieldset>
                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="col-md-6 mb-3">
                                                <div class="reset-button">
                                                    <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($placesData) ? 'Update' : 'Save' }}</button>
                                                    @if(!isset($placesData))
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
         $(document).ready(function () {
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!",
                width: "100%"
            });
        });
         document.addEventListener("DOMContentLoaded", function () {
            CKEDITOR.replace('short_desc');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        @if(!isset($placesData->place_url))
            $(document.body).on('keyup change', '#place_name', function() {
                $("#place_url").val(name_to_url($(this).val()));
            });
        @endif
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
                output.innerHTML = '<img src="' + reader.result + '" alt="Preview" style="width: 400px; height: 200px; object-fit: cover; border: 1px solid #ddd; padding: 5px; margin-top: 10px;">';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        function validator() {
            if (!blankCheck('place_name', 'Place name cannot be blank')) return false;
            if (!blankCheck('place_url', 'Place URL cannot be blank')) return false;
            if (!selectDropdown('destination_id', 'Please select a Destination')) return false;

            @if(!isset($placesData->placeimg) && !isset($placesData->placethumbimg))
                if (!validateFilePresence('placeimg', 'Banner image is required.')) return false;
                if (!validateFilePresence('placethumbimg', 'Place Image is required.')) return false;
            @endif
            
            if (!blankCheck('alttag_banner', 'Banner Alt Tag cannot be blank')) return false;
            if (!blankCheck('alttag_thumb', 'Alt Tag For Getaways Image cannot be blank')) return false;
            if (!blankCheck('latitude', 'Latitude cannot be blank')) return false;
            if (!blankCheck('longitude', 'Longitude cannot be blank')) return false;
            if (!blankCheck('short_desc', 'About place cannot be blank')) return false;
            return true;
        }
    </script>
</body>
</html>
