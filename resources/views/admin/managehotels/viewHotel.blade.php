<!-- Metaheader Section-->
@include('Admin.include.metaheader')
<!-- Metaheader Section End -->
@php
    use Carbon\Carbon;
@endphp
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
                                <!-- <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.manageHotels') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L3.707 7.5H14.5a.5.5 0 0 1 .5.5z"/>
                                    </svg>
                                    Back
                                </a>
                            </nav>
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Hotel Name</label></div>
                                                            <div class="col-md-8">{{$hotels->hotel_name}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Destination Name </label></div>
                                                            <div class="col-md-8">{{$hotels->destination_name}} </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Hotel Type</label></div>
                                                            <div class="col-md-8">{{$hotels->hotel_type_name}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Room Type </label></div>
                                                            <div class="col-md-8">{{$hotels->room_type}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Trip Advisor URL</label></div>
                                                            <div class="col-md-8"><a href="{{$hotels->trip_advisor_url}}" target="_blank">Link</a></div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Default Price </label></div>
                                                            <div class="col-md-8">₹ {{$hotels->default_price}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Star Ratings (Out of 5)</label></div>
                                                            <div class="col-md-8">{{$hotels->star_rating}}</div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                <div class="table-responsive">
                                                    <table id="example"
                                                        class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr class="info width-auto">
                                                                <th width="1%">Sl#</th>
                                                                <th width="17%">Season Type</th>
                                                                <th width="20%">Season Start Month</th>
                                                                <th width="20%">Season Start Day</th>
                                                                <th width="20%">Season End Month</th>
                                                                <th width="20%">Season End Day</th>
                                                                <th width="9%">Price/Adult (₹)</th>
                                                                <th width="9%">Price/Couple (₹)</th>
                                                                <th width="9%">Price/Kids (₹)</th>
                                                                <th width="9%">Extra Bed/Adult</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($hotels->seasons as $key => $season)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $season->season_type_name }}</td>
                                                                <td>{{Carbon::createFromFormat('m', $season->sesonstart_month)->format('F')}}</td>
                                                                <td>{{ $season->sesonstart_day }}</td>
                                                                <td>{{Carbon::createFromFormat('m', $season->sesonend_month )->format('F')}}</td>
                                                                <td>{{ $season->sesonend_day }}</td>
                                                                <td>{{ $season->adult_price }}</td>
                                                                <td>{{ $season->couple_price }}</td>
                                                                <td>{{ $season->kid_price }}</td>
                                                                <td>{{ $season->adult_extra }}</td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td class="text-center" colspan="10">No data available
                                                                </td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
</body>

</html>