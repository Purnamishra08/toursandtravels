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
                                <a href="{{ isset($destinationData) ? route('admin.destination.editdestination', ['id' => $destinationData->destination_id]) : route('admin.destination.adddestination') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                    </svg>
                                    {{ isset($destinationData) ? 'Edit' : 'Add' }}
                                </a>
                                <a href="{{ route('admin.destination') }}" class="tab-menu__item">
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
                                        
                                            <form action="{{ isset($destinationData) ? route('admin.destination.editdestination', ['id' => $destinationData->destination_id]) : route('admin.destination.adddestination') }}" method="POST" id="form_destination" name="form_destination" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                @csrf
                                                <div class="box-main">
                                                    
                                                    <fieldset>
                                                        <legend> Destination Details</legend>
                                                        <div class="row">
                                                            <!-- Destination Name -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination Name <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter destination name" name="destination_name" id="destination_name" value="{{ old('destination_name', $destinationData->destination_name ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Destination URL -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination Url <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" readonly placeholder="Enter destination url" name="destination_url" id="destination_url" value="{{ old('destination_url', $destinationData->destination_url ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Destination Types -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination Types</label>
                                                                    <select data-placeholder="Choose destination type" class="chosen-select form-select efilter" multiple tabindex="4" id="destination_type" name="destination_type[]" style="width: 100%;">
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
    
    
                                                                
                                                            <!-- Destination Categories -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination Categories</label>
                                                                    <select data-placeholder="Choose destination category" class="chosen-select efilter" multiple tabindex="4" id="edesti" name="edesti[]" style="width: 100%;">
                                                                        @foreach($categories as $category)
                                                                            <option value="{{ $category->catid }}"
                                                                                @if(isset($selectedCategories) && in_array($category->catid, $selectedCategories)) selected @endif>
                                                                                {{ $category->cat_name }}
                                                                            </option>
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
                                                                            <option value="{{ $tag->tagid }}"
                                                                                @if(isset($selectedGetawayTags) && in_array($tag->tagid, $selectedGetawayTags)) selected @endif>
                                                                                {{ $tag->tag_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
    
                                                            <!-- Banner Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Banner Image <span class="manadatory">*</span></label>
                                                                    <input name="destiimg" id="destiimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview')">
                                                                    <span>Image size should be 2000px X 350px</span>
                                                                    <div id="banner_preview" style="margin-top: 10px;">
                                                                        <img id="bannerPreview" 
                                                                        src="{{ isset($destinationData->destiimg) ? asset('storage/destination_images/'.$destinationData->destiimg) : '' }}" 
                                                                        alt="Banner Preview" 
                                                                        class="img-fluid rounded border" 
                                                                        style="max-width: 300px; display: {{ isset($destinationData->destiimg) ? 'block' : 'none' }};">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <!-- Destination Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination Image <span class="manadatory">*</span></label>
                                                                    <input name="destismallimg" id="destismallimg" class="form-control" type="file" onchange="previewImage(event, 'banner_preview_dest')">
                                                                    <span>Image size should be 300px X 225px</span>
                                                                    <div id="banner_preview_dest" style="margin-top: 10px;">
                                                                        <img id="bannerPreviewDest" 
                                                                        src="{{ isset($destinationData->destiimg_thumb) ? asset('storage/destination_images/thumbs/'.$destinationData->destiimg_thumb) : '' }}" 
                                                                        alt="Banner Preview Destination" 
                                                                        class="img-fluid rounded border" 
                                                                        style="max-width: 300px; display: {{ isset($destinationData->destiimg_thumb) ? 'block' : 'none' }};">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <!-- Alt Tag for Banner Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Banner Image <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner', $destinationData->alttag_banner ?? '') }}" maxlength="60">
                                                                </div>
                                                            </div>
    
                                                            <!-- Alt Tag for Destination Image -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Destination Image <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for destination image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb', $destinationData->alttag_thumb ?? '') }}" maxlength="60">
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label> Destination Type (For showing in home page) </label>
                                                                    <select class="form-control" name="desttype_for_home" id="desttype_for_home">
                                                                        <option value=''>-- Select Destination Type --</option>
                                                                        @foreach($parameters as $type)
                                                                            <option value="{{ $type->parid }}" @if(isset($destinationData) && $destinationData->desttype_for_home == $type->parid) selected @endif>{{ $type->par_value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                    
    
                                                            <!-- Show on Footer Menu -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Show on footer menu</label>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <input type="checkbox" name="show_on_footer" id="show_on_footer" value="1" {{ old('show_on_footer', $destinationData->show_on_footer ?? '') ? 'checked' : '' }}>
                                                                            For footer menu
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <!-- Pick/Drop Price -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Pick / Drop Price () <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Pick or Drop Price" name="pick_drop_price" id="pick_drop_price" value="{{ old('pick_drop_price', $destinationData->pick_drop_price ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Minimum Accommodation Price -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Minimum Accommodation Price /Person () <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Minimum Accommodation price" name="accomodation_price" id="accomodation_price" value="{{ old('accomodation_price', $destinationData->accomodation_price ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Latitude -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Latitude <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Destination Latitude" name="latitude" id="latitude" value="{{ old('latitude', $destinationData->latitude ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Longitude -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Longitude <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Destination Longitude" name="longitude" id="longitude" value="{{ old('longitude', $destinationData->longitude ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>To Find Latitude and Longitude Click <a href="http://www.latlong.net" target="_blank" style="color:#18c4c0">http://www.latlong.net</a></label>
                                                                </div>
                                                            </div>
    
                                                            <!-- About Destination -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>About Destination <span class="manadatory">*</span></label>
                                                                    <textarea name="short_desc" id="short_desc" class="form-control">{{ old('short_desc', $destinationData->about_destination ?? '') }}</textarea>
                                                                </div>
                                                            </div>
    
                                                            <!-- Places to Visit Text -->
                                                            <div class="col-md-12">
                                                                <div class="">
                                                                    <label>Places to Visit Text</label>
                                                                    <textarea name="places_to_visit_desc" id="places_to_visit_desc" class="form-control">{{ old('places_to_visit_desc', $destinationData->places_visit_desc ?? '') }}</textarea>
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
                                                                    <label>Ideal Trip Duration</label>
                                                                    <input type="text" class="form-control" placeholder="Ex- 3days / 2night" name="trip_duration" id="trip_duration" value="{{ old('trip_duration', $destinationData->trip_duration ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Nearest City -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Nearest City</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Nearest City" name="nearest_city" id="nearest_city" value="{{ old('nearest_city', $destinationData->nearest_city ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Best Time to Visit -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Best Time To Visit</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Visit Time" name="visit_time" id="visit_time" value="{{ old('visit_time', $destinationData->visit_time ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Peak Season -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Peak Season</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Peak season" name="peak_season" id="peak_season" value="{{ old('peak_season', $destinationData->peak_season ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Weather Info -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Weather Info</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Weather info" name="weather_info" id="weather_info" value="{{ old('weather_info', $destinationData->weather_info ?? '') }}">
                                                                </div>
                                                            </div>
    
                                                            <!-- Similar Destination -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Similar Destination</label>
                                                                    <select data-placeholder="Choose Similar Destination" class="chosen-select efilter" multiple tabindex="4" id="other_info" name="other_info[]" style="width: 100%;">
                                                                        @foreach($similarDestinations as $destination)
                                                                            <option value="{{ $destination->destination_id }}" 
                                                                                @if(!empty($similarDestinationTags) && in_array($destination->destination_id, $similarDestinationTags)) selected @endif>
                                                                                {{ $destination->destination_name }}
                                                                            </option>
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
                                                                            <option value="{{ $place->destination_id }}" 
                                                                                @if(!empty($nearbyPlacesTags) && in_array($place->destination_id, $nearbyPlacesTags)) selected @endif>
                                                                                {{ $place->destination_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
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
                                                            <!-- Internet Availability -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Internet Availability</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Internet Availability" name="internet_avl" id="internet_avl" value="{{ old('internet_avl' , $destinationData->internet_availability ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Std Code -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Std Code</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Std Code" name="std_code" id="std_code" value="{{ old('std_code', $destinationData->std_code ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Languages Spoken -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Languages Spoken</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Languages Spoken" name="lng_spk" id="lng_spk" value="{{ old('lng_spk', $destinationData->language_spoken ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Major Festivals -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Major Festivals</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Major Festivals" name="mjr_fest" id="mjr_fest" value="{{ old('mjr_fest', $destinationData->major_festivals ?? '') }}">
                                                                </div>
                                                            </div>

                                                            <!-- Notes/Tips -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Notes/Tips</label>
                                                                    <textarea class="form-control" placeholder="Notes/Tips..." name="note_tips" id="note_tips">{{ old('note_tips', $destinationData->note_tips ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Google Map -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Google Map</label>
                                                                    <textarea class="form-control" placeholder="Enter Google Map" name="google_map" id="google_map">{{ old('google_map', $destinationData->google_map ?? '') }}</textarea>
                                                                    <b>Example :</b><p style="color:#18c4c0"> &lt;iframe src="https://www.google.com/maps/d/embed?mid=19xHbU7LdnDtVsj_gR5u6EpnQ4OM&hl=en" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen&gt; &lt;/iframe&gt;</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <!-- Meta Tags Section -->
                                                <div class="box-main">
                                                    <fieldset>
                                                        <legend>Meta Tags</legend>
                                                        <div class="row">
                                                            <!-- Overview Meta Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Title</label>
                                                                    <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="meta_title" id="meta_title">{{ old('meta_title', $destinationData->meta_title ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Keyword</label>
                                                                    <textarea name="meta_keywords" id="meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('meta_keywords', $destinationData->meta_keywords ?? '') }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Description</label>
                                                                    <textarea name="meta_description" id="meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('meta_description', $destinationData->meta_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="box-main">
                                                    <fieldset>
                                                        <legend>Place Meta Tags</legend>
                                                            <div class="row">
                                                                <!-- Place Meta Tags -->
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Place Meta Title</label>
                                                                        <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="place_meta_title" id="place_meta_title">{{ old('place_meta_title', $destinationData->place_meta_title ?? '') }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Place Meta Keyword</label>
                                                                        <textarea name="place_meta_keywords" id="place_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('place_meta_keywords', $destinationData->place_meta_keywords ?? '') }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Place Meta Description</label>
                                                                        <textarea name="place_meta_description" id="place_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('place_meta_description', $destinationData->place_meta_description ?? '') }}</textarea>
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
                                                                        <textarea cols="" rows="" placeholder="Meta Title..." class="form-control textarea1" name="pckg_meta_title" id="pckg_meta_title">{{ old('pckg_meta_title', $destinationData->package_meta_title ?? '') }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Package Meta Keyword</label>
                                                                        <textarea name="pckg_meta_keywords" id="pckg_meta_keywords" cols="" rows="" placeholder="Meta Keywords..." class="form-control textarea1">{{ old('pckg_meta_keywords', $destinationData->package_meta_keywords ?? '') }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label>Package Meta Description</label>
                                                                        <textarea name="pckg_meta_description" id="pckg_meta_description" cols="" rows="" placeholder="Meta Description here..." class="form-control textarea">{{ old('pckg_meta_description', $destinationData->package_meta_description ?? '') }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </fieldset>
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="reset-button">
                                                        <button type="submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit">{{ isset($destinationData) ? 'Update' : 'Save' }}</button>
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
            CKEDITOR.replace('places_to_visit_desc');
            const originalWarn = console.warn;
            console.warn = function (message) {
                if (!message.includes("This CKEditor 4.22.1 (Standard) version is not secure")) {
                    originalWarn.apply(console, arguments);
                }
            };
        });
        
        $(document.body).on('keyup change', '#destination_name', function() {
			$("#destination_url").val(name_to_url($(this).val()));
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
            // Validate text fields
            if (!blankCheck('destination_name', 'Destination name cannot be blank')) return false;
            if (!blankCheck('destination_url', 'Destination URL cannot be blank')) return false;
            if (!blankCheck('alttag_banner', 'Banner Alt Tag cannot be blank')) return false;
            if (!blankCheck('alttag_thumb', 'Alt Tag For Getaways Image cannot be blank')) return false;
            if (!blankCheck('about_tag', 'About Tag cannot be blank')) return false;
            if (!blankCheck('pick_drop_price', 'Pick up drop price cannot be blank')) return false;
            if (!blankCheck('accomodation_price', 'Accomodation price cannot be blank')) return false;
            if (!blankCheck('latitude', 'Latitude cannot be blank')) return false;
            if (!blankCheck('longitude', 'Longitude cannot be blank')) return false;
            if (!blankCheck('short_desc', 'About destination cannot be blank')) return false;

            // Validate file inputs
            if (!validateFilePresence('menutag_img', 'Banner image is required.')) return false;
            if (!validateFilePresence('menutagthumb_img', 'Getaways/Tour Image is required.')) return false;

            // Validate numeric fields
            if (!onlyNumeric('pick_drop_price', 'Pick up drop price must be a numeric value.')) return false;
            if (!onlyNumeric('accomodation_price', 'Accomodation price must be a numeric value.')) return false;
            // If all validations pass

            return true;
        }
    </script>
</body>
</html>
