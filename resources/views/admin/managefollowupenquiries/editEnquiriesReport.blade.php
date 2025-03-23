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
                                <a href="{{ route('admin.manageenquiriesreport.editEnquiriesReport', ['id' => $enquiry->id]) }}" class="tab-menu__item active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l2.0 2.0a.5.5 0 0 1 0 .708L5.207 13.5H3v-2.207L12.146.146zM11.207 2L4 9.207V10h.793L13 3.793 11.207 2z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.manageenquiriesreport') }}" class="tab-menu__item ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-eye" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg>
                                    Manaage Enquiry Report
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
                                                <form action="{{ route('admin.manageenquiriesreport.editEnquiriesReport', ['id' => $enquiry->id])}}" method="POST"
                                                    id="userform" name="userform" class="add-user"
                                                    onsubmit="return validator()">
                                                    @csrf
                                                    <div class="box-main">
                                                        <fieldset>
                                                            <legend>Enquiries Details</legend>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Customer Name <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ old('customer_name', $enquiry->customer_name) }}" readonly disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Email Address <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="email" class="form-control" name="email_address" id="email_address" value="{{ old('email_address', $enquiry->email_address) }}" readonly disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Phone Number <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number', $enquiry->phone_number) }}" readonly disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Source <span class="manadatory">*</span></label>
                                                                            <select class="form-select" name="source_id" id="source_id" readonly disabled>
                                                                            <option value="">-- Select Source --</option>
                                                                                @foreach($sources as $source)
                                                                                    <option value="{{ $source->id }}" {{ $enquiry->source_id == $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Status <spany class="manadatory">*</spany></label>
                                                                            <select class="form-select" name="status_id" id="status_id">
                                                                            <option value="">-- Select Status --</option>
                                                                                @foreach($statuses as $status)
                                                                                    <option value="{{ $status->id }}" {{ $enquiry->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Trip Name <span class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control" name="trip_name" id="trip_name" value="{{ old('trip_name', $enquiry->trip_name) }}" readonly disabled>
                                                                        </div>
                                                                    </div>

                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Trip Start Date <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker-no-validation" id="trip_start_date" name="trip_start_date" autocomplete="off" readonly placeholder="Choose Trip Start Date" value="{{ old('trip_start_date', \Carbon\Carbon::parse($enquiry->trip_start_date)->format('m/d/Y')) }}">
        
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Follow Up Date <span
                                                                                    class="manadatory">*</span></label>
                                                                            <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker-no-validation" id="follow_up_date" name="follow_up_date" autocomplete="off" readonly placeholder="Choose Follow Up Date" value="{{ old('follow_up_date', \Carbon\Carbon::parse($enquiry->followup_date)->format('m/d/Y')) }}">
                                                                                
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="clearfix"></div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>No. of Travellers <span class="manadatory">*</span></label>
                                                                            <input type="text" class="form-control" name="no_of_travellers" id="no_of_travellers" value="{{ old('no_of_travellers', $enquiry->travellers_count) }}">
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Comment <span
                                                                            class="manadatory">*</span></label>
                                                                            <textarea type="text" class="form-control" placeholder="Enter Comments" name="comment" id="comment">{{ old('comment', $enquiry->comments) }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="reset-button">
                                                            <button type="submit" class="btn btn-primary">Update</button>
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

    <script>
        function validator() {
            if (!blankCheck('customer_name', 'Customer Name cannot be blank')) return false;
            if (!blankCheck('email_address', 'Email Address cannot be blank')) return false;
            if (!blankCheck('phone_number', 'Phone Number cannot be blank')) return false;
            // if (!onlyNumeric('phone_number', 'Phone Number must be a valid number')) return false;
            if (!selectDropdown('source_id', 'Please select a Source')) return false;
            if (!selectDropdown('status_id', 'Please select a Status')) return false;
            if (!blankCheck('trip_name', 'Trip Name cannot be blank')) return false;
            if (!onlyNumeric('no_of_travellers', 'Number of Travellers must be a number')) return false;
            if (!blankCheck('comment', 'Comment cannot be blank')) return false;
            
            return true;
        }

    </script>
</body>

</html>