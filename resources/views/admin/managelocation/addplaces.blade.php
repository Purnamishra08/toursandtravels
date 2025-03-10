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
                            </nav>
                            @include('Admin.include.sweetaleart')

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
                                                                    <label>Place Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter place name" name="place_name" id="place_name" value="{{ old('place_name', $placesData->place_name ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Place URL -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Url</label>
                                                                    <input type="text" class="form-control" readonly placeholder="Enter place url" name="place_url" id="place_url" value="{{ old('place_url', $placesData->place_url ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Destination -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination</label>
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
                                                                    <label>Banner Image</label>
                                                                    <input name="placeimg" id="placeimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview')">
                                                                    <span>Image size should be 1140px X 350px</span>
                                                                    <div id="banner_preview" style="margin-top: 10px;">
                                                                        <img id="bannerPreview" 
                                                                        src="{{ isset($placesData->placeimg) ? asset('storage/place_images/'.$placesData->placeimg) : '' }}" 
                                                                        alt="Banner Preview" 
                                                                        class="img-fluid rounded border" 
                                                                        style="max-width: 300px; display: {{ isset($placesData->placeimg) ? 'block' : 'none' }};">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <!-- Place Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Place Image</label>
                                                                    <input name="placethumbimg" id="placethumbimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview_dest')">
                                                                    <span>Image size should be 500px X 300px</span>
                                                                    <div id="banner_preview_dest" style="margin-top: 10px;">
                                                                        <img id="bannerPreviewDest" 
                                                                        src="{{ isset($placesData->placethumbimg) ? asset('storage/place_images/thumbs/'.$placesData->placethumbimg) : '' }}" 
                                                                        alt="Banner Preview Destination" 
                                                                        class="img-fluid rounded border" 
                                                                        style="max-width: 300px; display: {{ isset($placesData->placethumbimg) ? 'block' : 'none' }};">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <!-- Alt Tag for Banner Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Banner Image</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner', $placesData->alttag_banner ?? '') }}" maxlength="60">
                                                                </div>
                                                            </div>
    
                                                            <!-- Alt Tag for Place Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Place Image</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb', $placesData->alttag_thumb ?? '') }}" maxlength="60">
                                                                </div>
                                                            </div>
    
                                                            <!-- Latitude -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Latitude</label>
                                                                    <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="{{ old('latitude', $placesData->latitude ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Longitude -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Longitude</label>
                                                                    <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="{{ old('longitude', $placesData->longitude ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>To Find Latitude and Longitude Click <a href="http://www.latlong.net" target="_blank" style="color:#18c4c0">http://www.latlong.net</a></label>
                                                                </div>
                                                            </div>

                                                            <!-- Getaway Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Getaway Tags</label>
                                                                    <select data-placeholder="Choose getaway tags" class="chosen-select" multiple tabindex="4" id="getatagid" name="getatagid[]" style="width: 100%;">
                                                                        @foreach($tags as $tag)
                                                                            <option value="{{ $tag->tagid }}"
                                                                                @if(isset($selectedGetawayTags) && in_array($tag->tagid, $selectedGetawayTags)) selected @endif>
                                                                                {{ $tag->tag_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- About Destination -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>About Place</label>
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
                                                            <!-- Ideal Trip Duration -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Trip duration (including travel in hours)</label>
                                                                    <input type="text" class="form-control" placeholder="2-3 Hours" name="trip_duration" id="trip_duration" value="{{ old('trip_duration', $placesData->trip_duration ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Transportation Options -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Transportation Options</label>
                                                                    <select data-placeholder="Choose transport" class="chosen-select form-select efilter" multiple tabindex="4" id="transport" name="transport[]" style="width: 100%;">
                                                                        @foreach($vehicleType as $vtype)
                                                                            <option value="{{ $vtype->vehicleid }}"
                                                                                @if(!empty($selectedDestinationTypes) && in_array($vtype->vehicleid, $selectedDestinationTypes)) 
                                                                                    selected 
                                                                                @endif>
                                                                                {{ $vtype->vehicle_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
    
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

                                                        <!-- Other Information Section -->
                                                        <div class="box-main">
                                                        
                                                            <fieldset>
                                                                <legend>Other Information</legend>
                                                                <div class="row">
                                                                    <div class="col-md-6"> 
                                                                        <div class="form-group">
                                                                            <label>Entry Fee (<i class="fa-solid fa-indian-rupee-sign"></i>)</label>
                                                                            <input type="text" class="form-control" placeholder="Entry Fee" name="entry_fee" id="entry_fee" value="{{ old('entry_fee', $placesData->entry_fee ?? '') }}">
                                                                        </div>   
                                                                    </div>

                                                                    <div class="col-md-6"> 
                                                                        <div class="form-group">
                                                                            <label>Timing</label>
                                                                            <input type="text" class="form-control" placeholder="Timing" name="timing" id="timing" value="{{ old('timing', $placesData->timing ?? '') }}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6"> 
                                                                        <div class="form-group">
                                                                            <label>Rating</label>                                                    
                                                                            <select class="form-control" name="rating" id="rating">
                                                                                <option value="0">Select Rating</option>
                                                                                @foreach ([1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5] as $rate)
                                                                                    <option value="{{ $rate }}" {{ old('rating', $placesData->rating ?? '') == $rate ? 'selected' : '' }}>{{ $rate }}</option>
                                                                                @endforeach
                                                                            </select>
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
        
        $(document.body).on('keyup change', '#place_name', function() {
			$("#place_url").val(name_to_url($(this).val()));
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
            if (!blankCheck('place_name', 'Place name cannot be blank')) return false;
            if (!blankCheck('place_url', 'Place URL cannot be blank')) return false;
            if (!selectDropdown('destination_id', 'Please select a Destination')) return false;
            if (!validateFilePresence('placeimg', 'Banner image is required.')) return false;
            if (!validateFilePresence('placethumbimg', 'Place Image is required.')) return false;
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
