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
                <!--TopBar header end -->

                <!-- Main Content Start-->
                <main>
                    <div class="inner-layout">
                        <div class="container-fluid px-4 pt-3">
                            <nav class="tab-menu">
                                <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-plus" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                        </path>
                                    </svg>
                                    Add
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
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <form action="{{ route('admin.manageHotels.addHotel') }}" method="POST"
                                                    id="userform" name="userform" class="add-user"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="box-main">
                                                        <fieldset>
                                                            <legend>Hotel Details</legend>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Hotel Name <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Hotel Name" name="hotel_name"
                                                                                id="hotel_name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Destination <span
                                                                                    class="manadatory">*</span></label>
                                                                            <select class="form-control" id="destinationid"
                                                                                name="destinationid">
                                                                                <option value="">-- Select destination --
                                                                                </option>
                                                                                @forelse($destinations as $destination)
                                                                                <option
                                                                                    value="{{ $destination->destination_id }}"
                                                                                    {{ old('destinationid')==$destination->
                                                                                    destination_id ? 'selected' : '' }}>
                                                                                    {{ $destination->destination_name }}
                                                                                </option>
                                                                                @empty
                                                                                <option value="" disabled>No destination
                                                                                    available
                                                                                </option>
                                                                                @endforelse
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Hotel Type <span
                                                                                    class="manadatory">*</span></label>
                                                                            <select class="form-control" id="hotel_type"
                                                                                name="hotel_type">
                                                                                <option value="">-- Select Hotel Type --
                                                                                </option>
                                                                                @forelse($hotelTypes as $hotelType)
                                                                                <option value="{{ $hotelType->hotel_type_id }}"
                                                                                    {{ old('hotel_type')==$hotelType->
                                                                                    hotel_type_id ? 'selected' : '' }}>
                                                                                    {{ $hotelType->hotel_type_name }}
                                                                                </option>
                                                                                @empty
                                                                                <option value="" disabled>No hotel type
                                                                                    available
                                                                                </option>
                                                                                @endforelse
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Room Type <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Room Type" name="room_type"
                                                                                id="room_type">
                                                                        </div>
                                                                    </div>

                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Trip Advisor URL</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Trip Advisor URL"
                                                                                name="trip_url" id="trip_url">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Default Price (₹) <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Default Price"
                                                                                name="default_price" id="default_price">
                                                                        </div>
                                                                    </div>

                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Star Ratings (Out of 5)</label>
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Enter Star Ratings. Eg. 4 or 4.5 "
                                                                                name="star_ratings" id="star_ratings">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="box-main">
                                                        <fieldset>
                                                            <legend>Season Wise Price (In ₹)</legend>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <table id="addRowTable"
                                                                        class="table table-bordered table-striped table-hover">
                                                                        <thead>
                                                                            <tr class="info">
                                                                                <th width="17%">Season Type <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="20%">Season Start Duration <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="20%">Season End Duration <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="9%">Price/Adult (₹) <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="9%">Price/Couple (₹) <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="9%">Price/Kids (₹) <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="9%">Extra Bed/Adult <span
                                                                                        class="manadatory">*</span></th>
                                                                                <th width="7%"></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <select class="form-control"
                                                                                        id="season_type"
                                                                                        name="season_type[]">
                                                                                        <option value="">-- Select Type --
                                                                                        </option>
                                                                                        @forelse($seasonTypes as $seasonType)
                                                                                        <option
                                                                                            value="{{ $seasonType->season_type_id }}"
                                                                                            {{
                                                                                            old('season_type')==$seasonType->
                                                                                            season_type_id ? 'selected' : ''
                                                                                            }}>
                                                                                            {{ $seasonType->season_type_name
                                                                                            }}
                                                                                        </option>
                                                                                        @empty
                                                                                        <option value="" disabled>No season
                                                                                            type available
                                                                                        </option>
                                                                                        @endforelse
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_startmonth[]"
                                                                                                class="form-control"
                                                                                                id="from_startmonth">
                                                                                                <option value="">--Month--
                                                                                                </option>
                                                                                                <option value="01">January
                                                                                                </option>
                                                                                                <option value="02">February
                                                                                                </option>
                                                                                                <option value="03">March
                                                                                                </option>
                                                                                                <option value="04">April
                                                                                                </option>
                                                                                                <option value="05">May
                                                                                                </option>
                                                                                                <option value="06">June
                                                                                                </option>
                                                                                                <option value="07">July
                                                                                                </option>
                                                                                                <option value="08">August
                                                                                                </option>
                                                                                                <option value="09">September
                                                                                                </option>
                                                                                                <option value="10">October
                                                                                                </option>
                                                                                                <option value="11">November
                                                                                                </option>
                                                                                                <option value="12">December
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div
                                                                                            class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_startdate[]"
                                                                                                class="form-control"
                                                                                                id="from_startdate">
                                                                                                <option value="">--Day--
                                                                                                </option>
                                                                                                <?php for ($i = 1; $i < 32; $i++) { ?>
                                                                                                <option
                                                                                                    value="<?php echo $i ?>">
                                                                                                    <?php echo $i ?>
                                                                                                </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td>
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_endmonth[]"
                                                                                                class="form-control"
                                                                                                id="from_endmonth">
                                                                                                <option value="">--Month--
                                                                                                </option>
                                                                                                <option value="01">January
                                                                                                </option>
                                                                                                <option value="02">February
                                                                                                </option>
                                                                                                <option value="03">March
                                                                                                </option>
                                                                                                <option value="04">April
                                                                                                </option>
                                                                                                <option value="05">May
                                                                                                </option>
                                                                                                <option value="06">June
                                                                                                </option>
                                                                                                <option value="07">July
                                                                                                </option>
                                                                                                <option value="08">August
                                                                                                </option>
                                                                                                <option value="09">September
                                                                                                </option>
                                                                                                <option value="10">October
                                                                                                </option>
                                                                                                <option value="11">November
                                                                                                </option>
                                                                                                <option value="12">December
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>

                                                                                        <div
                                                                                            class="col-md-6 col-sm-6 col-xs-6 months">
                                                                                            <select name="from_enddate[]"
                                                                                                class="form-control"
                                                                                                id="from_enddate">
                                                                                                <option value="">--Day--
                                                                                                </option>
                                                                                                <?php for ($i = 1; $i < 32; $i++) { ?>
                                                                                                <option
                                                                                                    value="<?php echo $i ?>">
                                                                                                    <?php echo $i ?>
                                                                                                </option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text" class="form-control"
                                                                                        placeholder="Price"
                                                                                        name="adult_price[]"
                                                                                        id="adult_price">
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text" class="form-control"
                                                                                        placeholder="Price"
                                                                                        name="couple_price[]"
                                                                                        id="couple_price">
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text" class="form-control"
                                                                                        placeholder="Price"
                                                                                        name="kid_price[]" id="kid_price">
                                                                                </td>

                                                                                <td>
                                                                                    <input type="text" class="form-control"
                                                                                        placeholder="Price"
                                                                                        name="adult_extra[]"
                                                                                        id="adult_extra">
                                                                                </td>

                                                                                <td>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-success btn-sm views addrowbtn"
                                                                                        title="Add"><i
                                                                                            class="fa fa-plus"></i></a>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="btn btn-danger btn-sm views delrowbtn"
                                                                                        title="Delete" name="del[]"
                                                                                        id="del_0"><i
                                                                                            class="fa-regular fa-trash-can"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
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
                @include('admin.include.footer')
                <!-- Footer End-->
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('admin.include.footerJs')
    <!-- FooterJs End-->

    <script>
        function validator() {
            // Validate hotel details
            if (!blankCheck('hotel_name', 'Hotel Name cannot be blank')) return false;
            if (!selectDropdown('destinationid', 'Please select a Destination')) return false;
            if (!selectDropdown('hotel_type', 'Please select a Hotel Type')) return false;
            if (!blankCheck('default_price', 'Default Price cannot be blank')) return false;
            if (!onlyNumeric('default_price', 'Default Price must be a number')) return false;


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
                if (!onlyNumeric(adultPrice[i].id, 'Price for Adult must be a number')) return false;

                if (!blankCheck(couplePrice[i].id, 'Price for Couple cannot be blank')) return false;
                if (!onlyNumeric(couplePrice[i].id, 'Price for Couple must be a number')) return false;

                if (!blankCheck(kidPrice[i].id, 'Price for Kids cannot be blank')) return false;
                if (!onlyNumeric(kidPrice[i].id, 'Price for Kids must be a number')) return false;

                if (!blankCheck(adultExtra[i].id, 'Extra Bed Price cannot be blank')) return false;
                if (!onlyNumeric(adultExtra[i].id, 'Extra Bed Price for Adults must be a number')) return false;
            }

            return true;


        }

    </script>
</body>

</html>