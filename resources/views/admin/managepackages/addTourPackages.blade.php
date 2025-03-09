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
                <!--TopBar header end -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ route('admin.managetourpackages.addTourPackages') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a>
                                <a href="{{ route('admin.managetourpackages') }}" class="tab-menu__item">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <form action="{{ route('admin.managetourpackages.addTourPackages') }}" method="POST" id="form_tpackages" name="form_tpackages" class="add-user" enctype="multipart/form-data" onsubmit="return validator()">
                                                    @csrf
                                                    <div class="box-main">
                                                        <h3>Package Details</h3>
                                                        <div class="row">
                                                            <!-- Package Name -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Name</label>
                                                                    <input type="text" class="form-control" placeholder="Enter package name" name="tpackage_name" id="tpackage_name" value="{{ old('tpackage_name') }}">
                                                                </div>
                                                            </div>
                                                            <!-- Package Url -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Url</label>
                                                                    <input type="text" class="form-control" placeholder="Enter tour package url" name="tpackage_url" id="tpackage_url" value="{{ old('tpackage_url') }}">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Package Code -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Code</label>
                                                                    <input type="text" class="form-control" placeholder="Enter tour package code" name="tpackage_code" id="tpackage_code" value="{{ old('tpackage_code') }}">
                                                                </div>
                                                            </div>
                                                            <!-- Package Duration -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Duration</label>
                                                                    <select class="form-control" name="pduration" id="pduration">
                                                                        <option value="">-- Select Duration --</option>
                                                                        @foreach($durations as $duration)
                                                                            <option value="{{ $duration->durationid }}" {{ old('pduration') == $duration->durationid ? 'selected' : '' }}>
                                                                                {{ $duration->duration_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Price and Fake Price -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Price (₹)</label>
                                                                    <input type="text" class="form-control" placeholder="Enter price for package" name="price" id="price" value="{{ old('price') }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Fake Price (₹)</label>
                                                                    <input type="text" class="form-control" placeholder="Enter fake price for package" name="fakeprice" id="fakeprice" value="{{ old('fakeprice') }}">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Profit Margin Percentage -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Profit Margin Percentage (%)</label>
                                                                    <input type="text" class="form-control" placeholder="Enter profit margin percentage" name="pmargin_perctage" id="pmargin_perctage" value="{{ old('pmargin_perctage') }}">
                                                                </div>
                                                            </div>
                                                            <!-- Package Ratings -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Ratings</label>
                                                                    <select class="form-control" name="rating" id="rating">
                                                                        <option value="0">Select Rating</option>
                                                                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1</option>
                                                                        <option value="1.5" {{ old('rating') == '1.5' ? 'selected' : '' }}>1.5</option>
                                                                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2</option>
                                                                        <option value="2.5" {{ old('rating') == '2.5' ? 'selected' : '' }}>2.5</option>
                                                                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3</option>
                                                                        <option value="3.5" {{ old('rating') == '3.5' ? 'selected' : '' }}>3.5</option>
                                                                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4</option>
                                                                        <option value="4.5" {{ old('rating') == '4.5' ? 'selected' : '' }}>4.5</option>
                                                                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Tour Availability Checkboxes -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="accomodation">Tour Availability</label>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <input type="checkbox" name="accomodation" id="accomodation" value="1" {{ old('accomodation') ? 'checked' : '' }}> Accommodation &nbsp;
                                                                            <input type="checkbox" name="tourtransport" id="tourtransport" value="1" {{ old('tourtransport') ? 'checked' : '' }}> Transportation &nbsp;
                                                                            <input type="checkbox" name="sightseeing" id="sightseeing" value="1" {{ old('sightseeing') ? 'checked' : '' }}> Sightseeing &nbsp;
                                                                            <input type="checkbox" name="breakfast" id="breakfast" value="1" {{ old('breakfast') ? 'checked' : '' }}> Breakfast &nbsp;
                                                                            <input type="checkbox" name="waterbottle" id="waterbottle" value="1" {{ old('waterbottle') ? 'checked' : '' }}> Water Bottle
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id="tour_avai_err"></div>
                                                            </div>
                                                            <!-- Tour Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Tour Tags</label>
                                                                    <select data-placeholder="Choose tour tags" class="chosen-select" multiple tabindex="4" id="getatagid" name="getatagid[]" style="width: 100%; height: auto; border: 1px solid #aaa; font-size:13px; padding:5px 7px;">
                                                                        @foreach($tags as $tag)
                                                                            <option value="{{ $tag->tagid }}">{{ $tag->tag_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div id="gettourtag_err"></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Banner and Tour Images -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Banner Image</label>
                                                                    <input type="file" name="tourimg" id="tourimg">
                                                                    <span>Image size should be 745px X 450px</span>
                                                                </div>
                                                                <div id="placeimo_err"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Tour Image</label>
                                                                    <input type="file" name="tourthumb" id="tourthumb">
                                                                    <span>Image size should be 300px X 225px</span>
                                                                </div>
                                                                <div id="placeimot_err"></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Alt Tags -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Banner Image</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for banner image" name="alttag_banner" id="alttag_banner" value="{{ old('alttag_banner') }}" maxlength="60">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Alt Tag For Tour Image</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Alt tag for tour image" name="alttag_thumb" id="alttag_thumb" value="{{ old('alttag_thumb') }}" maxlength="60">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Package Type and Itinerary -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Package Type</label>
                                                                    <select class="form-control" name="packtype" id="packtype">
                                                                        <option value="">-- Select Package Type --</option>
                                                                        @foreach($packageTypes as $pack)
                                                                            <option value="{{ $pack->parid }}" {{ old('packtype') == $pack->parid ? 'selected' : '' }}>
                                                                                {{ $pack->par_value }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Choose Itinerary</label>
                                                                    <select class="form-control" name="itinerary" id="itinerary">
                                                                        <option value="">-- Select Itinerary --</option>
                                                                        @foreach($itineraries as $itin)
                                                                            <option value="{{ $itin->itinerary_id }}" {{ old('itinerary') == $itin->itinerary_id ? 'selected' : '' }}>
                                                                                {{ $itin->itinerary_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Video Itinerary -->
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="checkbox" name="show_video_itinerary" id="show_video_itinerary" {{ old('show_video_itinerary') ? 'checked' : '' }}> Show Video Itinerary
                                                                </div>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <div class="form-group">
                                                                    <label>Video Itinerary Link</label>
                                                                    <input type="text" name="video_itinerary_link" id="video_itinerary_link" placeholder="https://www.youtube.com/embed/XXXXXXXXXX" class="form-control" value="{{ old('video_itinerary_link') }}">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Starting City -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Starting City</label>
                                                                    <select class="form-control" name="starting_city" id="starting_city">
                                                                        <option value="">-- Select Starting City --</option>
                                                                        @foreach($destinations as $destination)
                                                                            <option value="{{ $destination->destination_id }}" {{ old('starting_city') == $destination->destination_id ? 'selected' : '' }}>
                                                                                {{ $destination->destination_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Inclusion / Exclusion -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Inclusion / Exclusion</label>
                                                                    <textarea name="inclusion" id="inclusion" class="form-control" placeholder="Inclusion / Exclusion...">{{ old('inclusion', $inclusion ?? '') }}</textarea>
                                                                </div>
                                                                <div id="inclusion_err"></div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <!-- Itinerary Note -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Itinerary Note</label>
                                                                    <textarea name="itinerary_note" id="itinerary_note" class="form-control" placeholder="Itinerary Note...">{{ old('itinerary_note') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Accomodation Section -->
                                                    <div class="box-main">
                                                        <h3>Accomodation</h3>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <table id="addRowTable" class="table table-bordered table-striped table-hover">
                                                                    <thead>
                                                                        <tr class="info">
                                                                            <th width="50%">Destination name</th>
                                                                            <th width="40%">No of Nights Booking in Hotel</th>
                                                                            <th width="10%"></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <select class="form-control" id="destination_id" name="destination_id[]">
                                                                                    <option value="">-- Select destination --</option>
                                                                                    @foreach($availableDestinations as $dest)
                                                                                        <option value="{{ $dest->destination_id }}">{{ $dest->destination_name }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <div id="seasontype_err"></div>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="no_ofdays[]" id="no_ofdays">
                                                                                    <option value="">-- Select No of Nights --</option>
                                                                                    @for($i = 1; $i <= $max_noof_days; $i++)
                                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                                    @endfor
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <a href="javascript:void(0);" class="btn btn-success btn-sm views addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm views delrowbtn" title="Delete" name="del[]" id="del_0"><i class="fa-regular fa-trash-can"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>

                                                    <!-- Meta Tags Section -->
                                                    <div class="box-main">
                                                        <h3>Meta Tags</h3>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Title</label>
                                                                    <textarea name="meta_title" id="meta_title" class="form-control textarea1" placeholder="Meta Title...">{{ old('meta_title') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Keywords</label>
                                                                    <textarea name="meta_keywords" id="meta_keywords" class="form-control textarea1" placeholder="Meta Keywords...">{{ old('meta_keywords') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Meta Description</label>
                                                                    <textarea name="meta_description" id="meta_description" class="form-control textarea" placeholder="Meta Description here...">{{ old('meta_description') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                            <button type="reset" class="btn btn-danger">Reset</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>
                <!-- Main Content End -->

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
        <!-- jQuery (Required for Chosen) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Chosen CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
        <!-- Chosen JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
        <script>
        $(document.body).on('keyup change', '#tpackage_name', function() {
            $("#tpackage_url").val(name_to_url($(this).val()));
        });
        function name_to_url(name) {
            name = name.toLowerCase(); // lowercase
            name = name.replace(/^\s+|\s+$/g, ''); // remove leading and trailing whitespaces
            name = name.replace(/\s+/g, '-'); // convert (continuous) whitespaces to one -
            name = name.replace(/[^a-z0-9-]/g, ''); // remove everything that is not [a-z] or -
            return name;
        }
    </script>

    <script type="text/javascript">
        CKEDITOR.replace('inclusion');  
        CKEDITOR.replace('itinerary_note'); 
        
        $(document).ready(function(){
            $('#getatagid').chosen();
        });
    </script>
    <<script>
        function validator(){
        if(!blankCheck('tpackage_name','Please Enter Package Name'))
        return false;
        if(!blankCheck('tpackage_url','Please Enter Package Url'))
        return false;
        if(!blankCheck('tpackage_code','Please Enter Package Code'))
        return false;
        if(!selectDropdown('pduration','Please Select Package Duration'))
        return false;
        if(!blankCheck('price','Please Enter Price (₹)'))
        return false;
        if(!isDecimalUptoTwo('price','Price (₹)  must be a number'))
        return false;
        if(!blankCheck('fakeprice','Please Enter Fake Price (₹)'))
        return false;
        if(!isDecimalUptoTwo('fakeprice','Fake Price (₹)  must be a number'))
        return false;
        if(!blankCheck('pmargin_perctage','Please Enter Profit Margin Percentage (%)'))
        return false;
        if(!isDecimalUptoTwo('pmargin_perctage','Profit Margin Percentage (%)  must be a number'))
        return false;
        if (!validateFilePresence('tourimg', 'Banner image is required.')) 
        return false;
        if (!validateFilePresence('tourthumb', 'Tour image is required.')) 
        return false;
        if(!blankCheck('alttag_banner','Please Enter Alt Tag For Banner Image'))
        return false;
        if(!blankCheck('alttag_thumb','Please Enter Alt Tag For Tour Image'))
        return false;
        if(!selectDropdown('itinerary','Please Select Itinerary'))
        return false;
        if(!selectDropdown('starting_city','Please Select Starting City'))
        return false;
        }
        
        </script>

</body>

</html>