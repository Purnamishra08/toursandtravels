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
            'admin.manageVehicletype' => ['Manage Vehicles', 'Vehicle Type', 'fa-truck', 'fa-car'],
            'admin.manageVehicleprice' => ['Manage Vehicles', 'Vehicle Price', 'fa-truck', 'fa-money'],
            'admin.manageHoteltype'   => ['Manage Hotels', 'Hotel Type','fa-building','fa-hotel'],
            'admin.manageSeasontype'   => ['Manage Hotels', 'Season Type','fa-building','fa-sun-o'],
            'admin.manageHotel'   => ['Manage Hotels', 'Hotel','fa-building','fa-hotel'],
            'admin.state'             => ['Location', 'State', 'fa-globe', 'fa-flag'],
            'admin.destinationtype'   => ['Location', 'Destination Type', 'fa-globe', 'fa-map-marker'],
        ];

        $route = $routes[Route::currentRouteName()] ?? ['Dashboard', '', 'fa-line-chart', ''];
    @endphp

    <div class="d-flex align-items-center">
        <i class="fa {{ $route[2] }} me-2"></i> <strong>{{ $route[0] }}</strong>
    </div>

    @if($route[1]) 
        <span class="mx-2">/</span>
        <div class="d-flex align-items-center">
            <i class="fa {{ $route[3] }} me-2"></i> <span>{{ $route[1] }}</span>
        </div>
    @endif
</h4>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0 align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link user-bell dropdown-toggle d-flex" href="#" id="navbarDropdownMenuLink"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell"></i>
                <div class="notify">
                    <div class="point"><span class="heartbit "></span></div>
                </div>
            </a>

            <div class="dropdown-menu animated-box notification__list dropdown-menu-end"
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
            </div>

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