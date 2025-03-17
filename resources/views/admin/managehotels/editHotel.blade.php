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
                                <a href="{{ route('admin.manageHotels.editHotel', ['id' => $hotel->hotel_id]) }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l2.0 2.0a.5.5 0 0 1 0 .708L5.207 13.5H3v-2.207L12.146.146zM11.207 2L4 9.207V10h.793L13 3.793 11.207 2z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.manageHotels') }}" class="tab-menu__item ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
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
                                                <form action="{{ route('admin.manageHotels.editHotel', ['id' => $hotel->hotel_id]) }}" method="POST" id="userform" name="userform" class="edit-user" onsubmit="return validator()">
                                                    @csrf

                                                    <div class="box-main">
                                                        <h3>Hotel Details</h3>
                                                        <div class="row">
                                                            <!-- Hotel Name -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hotel Name <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Hotel Name" name="hotel_name" id="hotel_name" value="{{ old('hotel_name', $hotel->hotel_name) }}">
                                                                </div>
                                                            </div>

                                                            <!-- Destination -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Destination <span class="manadatory">*</span></label>
                                                                    <select class="form-control" id="destinationid" name="destinationid">
                                                                        <option value="">-- Select destination --</option>
                                                                        @forelse($destinations as $destination)
                                                                            <option value="{{ $destination->destination_id }}"
                                                                                {{ old('destinationid', $hotel->destination_name) == $destination->destination_id ? 'selected' : '' }}>
                                                                                {{ $destination->destination_name }}
                                                                            </option>
                                                                        @empty
                                                                            <option value="" disabled>No destination available</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="clearfix"></div>

                                                            <!-- Hotel Type -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Hotel Type <span class="manadatory">*</span></label>
                                                                    <select class="form-control" id="hotel_type" name="hotel_type">
                                                                        <option value="">-- Select Hotel Type --</option>
                                                                        @forelse($hotelTypes as $hotelType)
                                                                            <option value="{{ $hotelType->hotel_type_id }}"
                                                                                {{ old('hotel_type', $hotel->hotel_type) == $hotelType->hotel_type_id ? 'selected' : '' }}>
                                                                                {{ $hotelType->hotel_type_name }}
                                                                            </option>
                                                                        @empty
                                                                            <option value="" disabled>No hotel type available</option>
                                                                        @endforelse
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Room Type -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Room Type <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Room Type" name="room_type" id="room_type" value="{{ old('room_type', $hotel->room_type) }}">
                                                                </div>
                                                            </div>

                                                            <div class="clearfix"></div>

                                                            <!-- Trip Advisor URL -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Trip Advisor URL</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Trip Advisor URL" name="trip_url" id="trip_url" value="{{ old('trip_url', $hotel->trip_advisor_url) }}">
                                                                </div>
                                                            </div>

                                                            <!-- Default Price -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Default Price (₹) <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Default Price" name="default_price" id="default_price" value="{{ old('default_price', $hotel->default_price) }}">
                                                                </div>
                                                            </div>

                                                            <div class="clearfix"></div>

                                                            <!-- Star Ratings -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Star Ratings (Out of 5)</label>
                                                                    <input type="text" class="form-control" placeholder="Enter Star Ratings. Eg. 4 or 4.5" name="star_ratings" id="star_ratings" value="{{ old('star_ratings', $hotel->star_rating) }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="box-main">
                                                        <h3>Season Wise Price (In ₹)</h3>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table id="addRowTable" class="table table-bordered table-striped table-hover">
                                                                    <thead>
                                                                        <tr class="info">
                                                                            <th width="17%">Season Type <span class="manadatory">*</span></th>
                                                                            <th width="20%">Season Start Duration <span class="manadatory">*</span></th>
                                                                            <th width="20%">Season End Duration <span class="manadatory">*</span></th>
                                                                            <th width="9%">Price/Adult (₹) <span class="manadatory">*</span></th>
                                                                            <th width="9%">Price/Couple (₹) <span class="manadatory">*</span></th>
                                                                            <th width="9%">Price/Kids (₹) <span class="manadatory">*</span></th>
                                                                            <th width="9%">Extra Bed/Adult <span class="manadatory">*</span></th>
                                                                            <th width="7%">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if($seasons->count())
                                                                            @foreach($seasons as $index => $season)
                                                                                <tr>
                                                                                    <td>
                                                                                        <select class="form-control" name="season_type[]" id="season_type_{{ $index }}">
                                                                                            <option value="">-- Select Type --</option>
                                                                                            @forelse($seasonTypes as $stype)
                                                                                                <option value="{{ $stype->season_type_id }}" {{ old("season_type.$index", $season->season_type) == $stype->season_type_id ? 'selected' : '' }}>
                                                                                                    {{ $stype->season_type_name }}
                                                                                                </option>
                                                                                            @empty
                                                                                                <option value="" disabled>No season type available</option>
                                                                                            @endforelse
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                                <select name="from_startmonth[]" class="form-control" id="from_startmonth_{{ $index }}">
                                                                                                    <option value="">--Month--</option>
                                                                                                    @for ($m = 1; $m <= 12; $m++)
                                                                                                        @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                                                                                        <option value="{{ $monthNum }}" {{ old("from_startmonth.$index", $season->sesonstart_month) == $monthNum ? 'selected' : '' }}>
                                                                                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                                                                        </option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                                <select name="from_startdate[]" class="form-control" id="from_startdate_{{ $index }}">
                                                                                                    <option value="">--Day--</option>
                                                                                                    @for ($d = 1; $d <= 31; $d++)
                                                                                                        <option value="{{ $d }}" {{ old("from_startdate.$index", $season->sesonstart_day) == $d ? 'selected' : '' }}>
                                                                                                            {{ $d }}
                                                                                                        </option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                                <select name="from_endmonth[]" class="form-control" id="from_endmonth_{{ $index }}">
                                                                                                    <option value="">--Month--</option>
                                                                                                    @for ($m = 1; $m <= 12; $m++)
                                                                                                        @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                                                                                        <option value="{{ $monthNum }}" {{ old("from_endmonth.$index", $season->sesonend_month) == $monthNum ? 'selected' : '' }}>
                                                                                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                                                                        </option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                                <select name="from_enddate[]" class="form-control" id="from_enddate_{{ $index }}">
                                                                                                    <option value="">--Day--</option>
                                                                                                    @for ($d = 1; $d <= 31; $d++)
                                                                                                        <option value="{{ $d }}" {{ old("from_enddate.$index", $season->sesonend_day) == $d ? 'selected' : '' }}>
                                                                                                            {{ $d }}
                                                                                                        </option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" placeholder="Price" name="adult_price[]" id="adult_price_{{ $index }}" value="{{ old("adult_price.$index", $season->adult_price) }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" placeholder="Price" name="couple_price[]" id="couple_price_{{ $index }}" value="{{ old("couple_price.$index", $season->couple_price) }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" placeholder="Price" name="kid_price[]" id="kid_price_{{ $index }}" value="{{ old("kid_price.$index", $season->kid_price) }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" class="form-control" placeholder="Extra Price" name="adult_extra[]" id="adult_extra_{{ $index }}" value="{{ old("adult_extra.$index", $season->adult_extra) }}">
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delrowbtn" title="Delete" id="del_{{ $index }}"><i class="fa-regular fa-trash-can"></i></a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                            <tr>
                                                                                <td>
                                                                                    <select class="form-control" name="season_type[]" id="season_type_0">
                                                                                        <option value="">-- Select Type --</option>
                                                                                        @forelse($seasonTypes as $stype)
                                                                                            <option value="{{ $stype->season_type_id }}">{{ $stype->season_type_name }}</option>
                                                                                        @empty
                                                                                            <option value="" disabled>No season type available</option>
                                                                                        @endforelse
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_startmonth[]" class="form-control" id="from_startmonth_0">
                                                                                                <option value="">--Month--</option>
                                                                                                @for ($m = 1; $m <= 12; $m++)
                                                                                                    @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                                                                                    <option value="{{ $monthNum }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_startdate[]" class="form-control" id="from_startdate_0">
                                                                                                <option value="">--Day--</option>
                                                                                                @for ($d = 1; $d <= 31; $d++)
                                                                                                    <option value="{{ $d }}">{{ $d }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_endmonth[]" class="form-control" id="from_endmonth_0">
                                                                                                <option value="">--Month--</option>
                                                                                                @for ($m = 1; $m <= 12; $m++)
                                                                                                    @php $monthNum = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                                                                                    <option value="{{ $monthNum }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_enddate[]" class="form-control" id="from_enddate_0">
                                                                                                <option value="">--Day--</option>
                                                                                                @for ($d = 1; $d <= 31; $d++)
                                                                                                    <option value="{{ $d }}">{{ $d }}</option>
                                                                                                @endfor
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" placeholder="Price" name="adult_price[]" id="adult_price_0">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" placeholder="Price" name="couple_price[]" id="couple_price_0">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" placeholder="Price" name="kid_price[]" id="kid_price_0">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" placeholder="Extra Price" name="adult_extra[]" id="adult_extra_0">
                                                                                </td>
                                                                                <td>
                                                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm addrowbtn" title="Add"><i class="fa fa-plus"></i></a>
                                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delrowbtn" title="Delete"><i class="fa-regular fa-trash-can"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <!-- <button type="reset" class="btn btn-danger">Reset</button> -->
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

    <script>
        
        function validator() {
            // Validate hotel details
            if (!blankCheck('hotel_name', 'Hotel Name cannot be blank')) return false;
            if (!selectDropdown('destinationid', 'Please select a Destination')) return false;
            if (!selectDropdown('hotel_type', 'Please select a Hotel Type')) return false;
            if (!blankCheck('default_price', 'Default Price cannot be blank')) return false;
            if (!isDecimalUptoTwo('default_price', 'Default Price must be a number')) return false;


            // Validate season-wise price table
            let seasonTypes = document.getElementsByName("season_type[]");
            let fromStartMonth = document.getElementsByName("from_startmonth[]");
            let fromStartDate = document.getElementsByName("from_startdate[]");
            let fromEndMonth = document.getElementsByName("from_endmonth[]");
            let fromEndDate = document.getElementsByName("from_enddate[]");
            let adultPrice = document.getElementsByName("adult_price[]");
            let couplePrice = document.getElementsByName("couple_price[]");
            let kidPrice = document.getElementsByName("kid_price[]");
            let adultExtra = document.getElementsByName("adult_extra[]");

            for (let i = 0; i < seasonTypes.length; i++) {
                if (!selectDropdown(seasonTypes[i].id, 'Please select a Season Type')) return false;
                if (!selectDropdown(fromStartMonth[i].id, 'Please select a Start Month')) return false;
                if (!selectDropdown(fromStartDate[i].id, 'Please select a Start Date')) return false;
                if (!selectDropdown(fromEndMonth[i].id, 'Please select an End Month')) return false;
                if (!selectDropdown(fromEndDate[i].id, 'Please select an End Date')) return false;
                if (!blankCheck(adultPrice[i].id, 'Price for Adult cannot be blank')) return false;
                if (!isDecimalUptoTwo(adultPrice[i].id, 'Price for Adult must be a number')) return false;

                if (!blankCheck(couplePrice[i].id, 'Price for Couple cannot be blank')) return false;
                if (!isDecimalUptoTwo(couplePrice[i].id, 'Price for Couple must be a number')) return false;

                if (!blankCheck(kidPrice[i].id, 'Price for Kids cannot be blank')) return false;
                if (!isDecimalUptoTwo(kidPrice[i].id, 'Price for Kids must be a number')) return false;

                if (!blankCheck(adultExtra[i].id, 'Extra Bed Price cannot be blank')) return false;
                if (!isDecimalUptoTwo(adultExtra[i].id, 'Extra Bed Price for Adults must be a number')) return false;
            }

            return true;


        }

    </script>

    <script src="{{ asset('assets/js/validation.js') }}"></script>

</body>

</html>