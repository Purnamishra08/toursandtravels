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
                                <!-- <a href="{{ route('admin.manageHotels.addHotel') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                    Add
                                </a> -->
                                <a href="{{ route('admin.managetourpackages') }}" class="tab-menu__item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l4.147 4.146a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708.708L3.707 7.5H14.5a.5.5 0 0 1 .5.5z"/>
                                    </svg>
                                    Back
                                </a>
                            </nav>
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-bd lobidrag">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Package Name</label></div>
                                                            <div class="col-md-8">{{$tourPackage->tpackage_name}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Package URL </label></div>
                                                            <div class="col-md-8">{{$tourPackage->tpackage_url}} </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Package Code</label></div>
                                                            <div class="col-md-8">{{$tourPackage->tpackage_code}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Package Duration </label></div>
                                                            <div class="col-md-8">{{$tourPackage->duration_name}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Price (₹)</label></div>
                                                            <div class="col-md-8">₹ {{$tourPackage->price}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Fakeprice (₹) </label></div>
                                                            <div class="col-md-8">₹ {{$tourPackage->fakeprice}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Profit Margin(%)</label></div>
                                                            <div class="col-md-8">{{$tourPackage->pmargin_perctage}}%</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Package Ratings </label></div>
                                                            <div class="col-md-8">
                                                            @php
                                                                $fullStars = floor($tourPackage->ratings); // Full stars count
                                                                $halfStar = (fmod($tourPackage->ratings, 1) !== 0.00) ? 1 : 0; // Half star check
                                                                $emptyStars = 5 - ($fullStars + $halfStar); // Remaining empty stars

                                                                // Print full stars
                                                                for ($i = 1; $i <= $fullStars; $i++) {
                                                                    echo '<i class="fa fa-star text-warning"></i> ';
                                                                }

                                                                // Print half star
                                                                if ($halfStar) {
                                                                    echo '<i class="fa fa-star-half-stroke text-warning"></i> ';
                                                                }

                                                                // Print empty stars
                                                                for ($i = 1; $i <= $emptyStars; $i++) {
                                                                    echo '<i class="fa fa-star text-secondary"></i> ';
                                                                }
                                                            @endphp
                                                                    {{$tourPackage->ratings}} {{'Star'}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Tour Availability </label></div>
                                                            <div class="col-md-8">	
                                                                <ul>
                                                                    <li>{{ $tourPackage->accomodation ? '✔️ Accommodation' : '❌ Accommodation' }}</li>
                                                                    <li>{{ $tourPackage->tourtransport ? '✔️ Transportation' : '❌ Transportation' }}</li>
                                                                    <li>{{ $tourPackage->sightseeing ? '✔️ Sightseeing' : '❌ Sightseeing' }}</li>
                                                                    <li>{{ $tourPackage->breakfast ? '✔️ Breakfast' : '❌ Breakfast' }}</li>
                                                                    <li>{{ $tourPackage->waterbottle ? '✔️ Water Bottle' : '❌ Water Bottle' }}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Tour Tags </label></div>
                                                            <div class="col-md-8">{{$tourTags}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Banner Image  </label></div>
                                                            <div class="col-md-8">	
                                                                <a href="{{ asset('storage/tourpackages/' . $tourPackage->tpackage_image) }}" target="_blank">
                                                                    <img id="destinationBannerPreview"
                                                                        src="{{ asset('storage/tourpackages/' . $tourPackage->tpackage_image) }}"
                                                                        alt="Banner Images Preview"
                                                                        class="img-fluid rounded border"
                                                                        style="width: 150px; height: 150px; object-fit: cover;">
                                                                    </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Tour Image </label></div>
                                                            <div class="col-md-8">
                                                                <a href="{{ asset('storage/tourpackages/thumbs/' . $tourPackage->tour_thumb) }}"    target="_blank">
                                                                    <img id="destinationBannerPreview"
                                                                        src="{{ asset('storage/tourpackages/thumbs/' . $tourPackage->tour_thumb) }}"
                                                                        alt="Banner Images Preview"
                                                                        class="img-fluid rounded border"
                                                                        style="width: 150px; height: 150px; object-fit: cover;">
                                                                    </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Package Type</label></div>
                                                            <div class="col-md-8">{{$tourPackage->par_value}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Starting City </label></div>
                                                            <div class="col-md-8">{{$tourPackage->starting_city_name}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Show Video Itinerary </label></div>
                                                            <div class="col-md-8">{{ $tourPackage->show_video_itinerary ? '✔️ Yes' : '❌ No' }}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Video Itinerary Link </label></div>
                                                            <div class="col-md-8">
                                                                @if($tourPackage->video_itinerary_link)
                                                                <a href="{{$tourPackage->video_itinerary_link}}" target="_blank" rel="noopener noreferrer">Link</a>
                                                                @else
                                                                {{'No Link'}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12">
                                                        <div class="gap row">
                                                            <div class="col-md-2"> <label>Itinerary Details</label></div>
                                                            <div class="col-md-10 table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <th class="text-center">Day</th>
                                                                        <th>Title</th>
                                                                        <th>Description</th>
                                                                        <th>Place</th>
                                                                        <th>Other Itinerary Places</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($itineraryDetails as $itineraryDetail)
                                                                        <tr>
                                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                                            <td>{{$itineraryDetail->title}}</td>
                                                                            <td>{!! $itineraryDetail->itinerary_desc !!}</td>
                                                                            <td>{{$itineraryDetail->place_names}}</td>
                                                                            <td>{{$itineraryDetail->other_iternary_places}}</td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td class="text-center" colspan="4">No data available
                                                                            </td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12">
                                                        <div class="gap row">
                                                            <div class="col-md-2"> <label>Accomodation</label></div>
                                                            <div class="col-md-10 table-responsive">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <th class="text-center">Sl#</th>
                                                                        <th>Destination Name</th>
                                                                        <th>No of Nights</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($accomodations as $accomodation)
                                                                        <tr>
                                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                                            <td>{{$accomodation->destination_name}}</td>
                                                                            <td>{{$accomodation->noof_days}}</td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td class="text-center" colspan="3">No data available
                                                                            </td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12">
                                                        <div class="gap row">
                                                            <div class="col-md-2"> <label>Inclusion / Exclusion</label></div>
                                                            <div class="col-md-10">@php echo $tourPackage->inclusion_exclusion @endphp</div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Itinerary Note:</label></div>
                                                            <div class="col-md-8">@php echo $tourPackage->itinerary_note @endphp</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Meta Title  </label></div>
                                                            <div class="col-md-8">{{$tourPackage->meta_title}}</div>
                                                        </div>
                                                    </div> 
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label> Meta Keywords</label></div>
                                                            <div class="col-md-8">{{$tourPackage->meta_keywords}}</div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="col-md-6">
                                                        <div class="gap row">
                                                            <div class="col-md-4"> <label>Meta Description  </label></div>
                                                            <div class="col-md-8">{{$tourPackage->meta_description}}</div>
                                                        </div>
                                                    </div> 
                                                
                                                    
                                                    <br><br>
                                                
                                            </div>
                                        </div>
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
</body>

</html>