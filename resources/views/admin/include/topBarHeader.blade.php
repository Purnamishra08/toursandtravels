<header class="navbar navbar-expand border-bottom">
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 ms-3" id="sidebarToggle" href="#!">
        <i class="bi bi-grid-fill"></i>
    </button>
    <!-- Navbar Search-->
   <h4 class="mb-0 d-flex align-items-center">
    @php
        // Define route mappings
        $routes = [
            'admin.change-password'   => ['Change Password', '', 'fa-pencil', ''],
            'admin.manageUser'        => ['Manage User', '', 'fa-user', ''],
            'admin.manageUser.addUser'=> ['Manage User', '', 'fa-user', ''],

            'admin.manageVehicletype' => ['Manage Vehicles', 'Vehicle Type', 'fa-truck', 'fa fa-car'],
            'admin.manageVehicletype.addVehicleType' => ['Manage Vehicles', 'Vehicle Type', 'fa-truck', 'fa fa-car'],
            'admin.manageVehicletype.editVehicleType' => ['Manage Vehicles', 'Vehicle Type', 'fa-truck', 'fa fa-car'],

            'admin.manageVehicleprice' => ['Manage Vehicles', 'Vehicle Price', 'fa-truck', 'fa-regular fa-money-bill-1'],
            'admin.manageVehicleprice.addVehiclePrice' => ['Manage Vehicles', 'Vehicle Price', 'fa-truck', 'fa-regular fa-money-bill-1'],
            'admin.manageVehicleprice.editVehiclePrice' => ['Manage Vehicles', 'Vehicle Price', 'fa-truck', 'fa-regular fa-money-bill-1'],

            'admin.manageHoteltype'   => ['Manage Hotels', 'Hotel Type','fa-building','fa fa-hotel'],
            'admin.manageHoteltype.addHotelType'   => ['Manage Hotels', 'Hotel Type','fa-building','fa fa-hotel'],
            'admin.manageHoteltype.editHotelType'   => ['Manage Hotels', 'Hotel Type','fa-building','fa fa-hotel'],

            'admin.manageSeasontype'   => ['Manage Hotels', 'Season Type','fa-building','fa-regular fa-sun'],
            'admin.manageSeasontype.addSeasonType'   => ['Manage Hotels', 'Season Type','fa-building','fa-regular fa-sun'],
            'admin.manageSeasontype.editSeasonType'   => ['Manage Hotels', 'Season Type','fa-building','fa-regular fa-sun'],

            'admin.manageHotels'   => ['Manage Hotels', 'Hotel','fa-building','fa fa-hotel'],
            'admin.manageHotels.addHotel'   => ['Manage Hotels', 'Hotel','fa-building','fa fa-hotel'],
            'admin.manageHotels.editHotel'   => ['Manage Hotels', 'Hotel','fa-building','fa fa-hotel'],
            'admin.manageHotels.viewHotel'   => ['Manage Hotels', 'Hotel','fa-building','fa fa-hotel'],

            'admin.state'             => ['Location', 'State', 'fa-globe', 'fa fa-flag'],

            'admin.destinationtype'   => ['Location', 'Destination Type', 'fa-globe', 'fa fa-map-marker'],
            'admin.destinationtype.adddestinationtype'   => ['Location', 'Destination Type', 'fa-globe', 'fa fa-map-marker'],
            'admin.destinationtype.editdestinationtype'   => ['Location', 'Destination Type', 'fa-globe', 'fa fa-map-marker'],

            'admin.destination'   => ['Location', 'Destinations', 'fa-globe', 'fa fa-location-dot'],
            'admin.destination.adddestination'   => ['Location', 'Destinations', 'fa-globe', 'fa fa-location-dot'],
            'admin.destination.editdestination'   => ['Location', 'Destinations', 'fa-globe', 'fa fa-location-dot'],

            'admin.places'   => ['Location', 'Places', 'fa-globe', 'fa fa fa-bookmark'],
            'admin.places.addplaces'   => ['Location', 'Places', 'fa-globe', 'fa fa fa-bookmark'],
            'admin.places.editplaces'   => ['Location', 'Places', 'fa-globe', 'fa fa fa-bookmark'],

            'admin.category'   => ['Menus', 'Category', 'fa fa-th-list', 'fa-brands fa fa-gg'],
            'admin.category.addcategory'   => ['Menus', 'Category', 'fa fa-th-list', 'fa-brands fa fa-gg'],
            'admin.category.editcategory'   => ['Menus', 'Category', 'fa fa-th-list', 'fa-brands fa fa-gg'],

            'admin.categorytags'   => ['Menus', 'Category Tags', 'fa fa-th-list', 'fa fa-tag'],
            'admin.categorytags.addcategorytags'   => ['Menus', 'Category Tags', 'fa fa-th-list', 'fa fa-tag'],
            'admin.categorytags.editcategorytags'   => ['Menus', 'Category Tags', 'fa fa-th-list', 'fa fa-tag'],

            'admin.managepackagedurations'   => ['Manage Packages', 'Package Durations', 'fa-person-walking-luggage', 'fa fa-hourglass'],
            'admin.managepackagedurations.addPackageDurations'   => ['Manage Packages', 'Package Durations', 'fa-person-walking-luggage', 'fa fa-hourglass'],
            'admin.managepackagedurations.editPackageDurations'   => ['Manage Packages', 'Package Durations', 'fa-person-walking-luggage', 'fa fa-hourglass'],

            'admin.menutag' => ['Menus', 'Menu Tags', 'fa fa-th-list', 'fa-solid fa-tags'],
            'admin.category.addmenutag' => ['Menus', 'Menu Tags', 'fa fa-th-list', 'fa-solid fa-tags'],
            'admin.category.editmenutag' => ['Menus', 'Menu Tags', 'fa fa-th-list', 'fa-solid fa-tags'],

            'admin.manageenquiry' => ['Manage Enquiries','Enquiry','fa-person-circle-question','fa-solid fa-question'],
            'admin.manageenquiry.viewEnquiry' => ['Manage Enquiries','Enquiry','fa-person-circle-question','fa-solid fa-question'],

            'admin.manageitineraryenquiry' => ['Manage Enquiries','Itinerary Enquiry','fa-person-circle-question','fa-solid fa-circle-question'],
            'admin.manageitineraryenquiry.viewItineraryEnquiry' => ['Manage Enquiries','Itinerary Enquiry','fa-person-circle-question','fa-solid fa-circle-question'],

            'admin.managepackageenquiry' => ['Manage Enquiries','Package Enquiry','fa-person-circle-question','fa-solid fa-clipboard-question'],
            'admin.managepackageenquiry.viewPackageEnquiry' => ['Manage Enquiries','Package Enquiry','fa-person-circle-question','fa-solid fa-clipboard-question'],
        ];

        $route = $routes[Route::currentRouteName()] ?? ['Dashboard', '',    'fa-line-chart', ''];
    @endphp

    <div class="d-flex align-items-center">
        <i class="fa {{ $route[2] }} me-2"></i> <strong>{{ $route[0] }}</strong>
    </div>

    @if($route[1]) 
        <span class="mx-2">/</span>
        <div class="d-flex align-items-center">
            <i class="{{ $route[3] }} me-2"></i> <span>{{ $route[1] }}</span>
        </div>
    @endif
</h4>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0 align-items-center">
        <li class="nav-item dropdown">
            <!-- <a class="nav-link user-bell dropdown-toggle d-flex" href="#" id="navbarDropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i>
                <div class="notify">
                    <div class="point"><span class="heartbit "></span></div>
                </div>
            </a> -->

            <!-- <div class="dropdown-menu animated-box notification__list dropdown-menu-end"
                aria-labelledby="navbarDropdownMenuLink">
                <div class="notification__header">
                    <h5>Notification</h5><button class="view-all">View All</button>
                </div>
                <ul>
                    <li>
                        <a href="javascript:;">
                            <span class="notification__count">1</span>
                            <span>
                                <span class="msg">New Enrollment pending at first level verifier</span>
                                <span class="date">12-Jan-2022</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="notification__count">2</span>
                            <span>
                                <span class="msg">New Enrollment pending at first level verifier</span>
                                <span class="date">12-Jan-2022</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="notification__count">3</span>
                            <span>
                                <span class="msg">New Enrollment pending at first level verifier</span>
                                <span class="date">12-Jan-2022</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="notification__count">4</span>
                            <span>
                                <span class="msg">New Enrollment pending at first level verifier</span>
                                <span class="date">12-Jan-2022</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;">
                            <span class="notification__count">5</span>
                            <span>
                                <span class="msg">New Enrollment pending at first level verifier</span>
                                <span class="date">12-Jan-2022</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div> -->

        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person"></i></a>

            <ul class="dropdown-menu dropdown-menu-end animated-box" aria-labelledby="navbarDropdown">
                <li class="mb-3">
                    <div class="notification__header">
                    <h5>Welcome, {{ session('user')->admin_name ?? 'Guest' }}</h5>
                    </div>
                </li>
                <li class="mb-2"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.change-password') }}"><i
                            class="bi bi-key me-2 round-bg"></i> Change Password </a></li>
                <!-- <li class="mb-2"><a class="dropdown-item d-flex align-items-center" href="#!"><i
                            class="bi bi-pencil me-2 round-bg"></i>Edit Profile </a></li>
                <li> -->
                    <hr class="dropdown-divider" />
                </li>
                <li><a class="dropdown-item d-flex align-items-center manadatory" href="{{route('admin.logout') }}"><i
                            class="bi bi-box-arrow-left me-2 round-bg"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</header>