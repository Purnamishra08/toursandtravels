<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <a class="navbar-brand ps-3 logoText mt-2 mb-3" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset('assets/img/duplicare-logo-dashbord.png') }}" alt="logo" class="leftmenu-logo" /></a>
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-line-chart"></i></div>
                    Dashboard
                </a>

                @if(session()->has('user') && session('user')->admin_type == 1)
                <a class="nav-link {{ request()->routeIs('admin.manageUser*') ? 'active' : '' }}"
                    href="{{ route('admin.manageUser') }}">
                    <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                    Manage User
                </a>
                @endif
                @php
                    $currentRoute = request()->route()->getName();
                    
                @endphp
                

                <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.manageVehicletype', 'admin.manageVehicleprice']) ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#manageVehicles"
                    aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageVehicletype', 'admin.manageVehicleprice']) ? 'true' : 'false' }}"
                    aria-controls="manageVehicles">
                    <div class="sb-nav-link-icon"><i class="fa fa-truck"></i></div>
                    Manage Vehicles
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.manageVehicletype', 'admin.manageVehicleprice']) ? 'show' : '' }}"
                    id="manageVehicles" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, 'admin.manageVehicletype') ? 'active' : '' }}"
                            href="{{ route('admin.manageVehicletype') }}">
                            <i class="fa fa-car mt-1 me-2"></i> Vehicle Type
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, 'admin.manageVehicleprice') ? 'active' : '' }}"
                            href="{{ route('admin.manageVehicleprice') }}">
                            <i class="fa-regular fa-money-bill-1 mt-1 me-2"></i> Vehicle Price
                        </a>
                    </nav>
                </div>

                
                <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.manageHoteltype','admin.manageSeasontype','admin.manageHotels']) ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#manageHotels"
                    aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageHoteltype','admin.manageSeasontype','admin.manageHotels']) ? 'true' : 'false' }}"
                    aria-controls="manageHotels">
                    <div class="sb-nav-link-icon"><i class="fa fa-building"></i></div>
                    Manage Hotels
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.manageHoteltype','admin.manageSeasontype', 'admin.manageHotels']) ? 'show' : '' }}"
                    id="manageHotels" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, 'admin.manageHoteltype') ? 'active' : '' }}"
                            href="{{ route('admin.manageHoteltype') }}">
                            <i class="fa fa-hotel mt-1 me-2"></i> Hotel Type
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, 'admin.manageSeasontype') ? 'active' : '' }}"
                            href="{{ route('admin.manageSeasontype') }}">
                            <!-- <i class="fa-thin fa-sun"></i> -->
                            <i class="fa-regular fa-sun mt-1 me-2"></i> Season Type
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, 'admin.manageHotels') ? 'active' : '' }}"
                            href="{{ route('admin.manageHotels') }}">
                            <i class="fa fa-hotel mt-1 me-2"></i> Hotel
                        </a>
                    </nav>
                </div>
               
                <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.state','admin.destinationtype']) ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#locations"
                    aria-expanded="{{  Str::startsWith($currentRoute, ['admin.state','admin.destinationtype']) ? 'true' : 'false' }}"
                    aria-controls="locations">
                    <div class="sb-nav-link-icon"><i class="fa fa-globe"></i></div>
                    Location
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.state','admin.destinationtype','admin.destination']) ? 'show' : '' }}"
                    id="locations" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <!-- <a class="nav-link {{  Str::startsWith($currentRoute, ['admin.state']) ? 'active' : '' }}"
                            href="{{ route('admin.state') }}">
                            <i class="fa fa-flag mt-1 me-2"></i> State
                        </a> -->
                        <a class="nav-link {{  Str::startsWith($currentRoute, ['admin.destinationtype']) ? 'active' : '' }}"
                            href="{{ route('admin.destinationtype') }}">
                            <i class="fa fa-map-marker mt-1 me-2"></i> Destination Type
                        </a>
                        <a class="nav-link {{  Str::startsWith($currentRoute, ['admin.destination']) ? 'active' : '' }}"
                            href="{{ route('admin.destination') }}">
                            <i class="fa fa-location-dot mt-1 me-2"></i> Destinations
                        </a>
                        <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}"
                            href="">
                            <i class="fa fa fa-bookmark mt-1 me-2"></i> Places
                        </a>
                    </nav>
                </div>
                
                <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags']) ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#menus"
                    aria-expanded="{{ Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags']) ? 'true' : 'false' }}"
                    aria-controls="menus">
                    <div class="sb-nav-link-icon"><i class="fa fa-th-list"></i></div>
                    Menus
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags', 'admin.menutag']) ? 'show' : '' }}"
                    id="menus" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ $currentRoute == 'admin.menutag' || $currentRoute == 'admin.category.addmenutag' || $currentRoute == 'admin.category.editmenutag'  ? 'active' : ''}}"
                            href="{{ route('admin.menutag') }}">
                            <i class="fa fa-th-list mt-1 me-2"></i> Menu Tags
                        </a>
                        <a class="nav-link {{ $currentRoute == 'admin.category' || $currentRoute == 'admin.category.addcategory' || $currentRoute == 'admin.category.editcategory'  ? 'active' : ''}}"
                            href="{{ route('admin.category') }}">
                            <i class="fa-brands fa-gg mt-1 me-2"></i> Category
                        </a>
                         <a class="nav-link {{ $currentRoute == 'admin.categorytags' || $currentRoute == 'admin.categorytags.addcategorytags' ||$currentRoute == 'admin.categorytags.editcategorytags' ? 'active' : '' }}"
                            href="{{ route('admin.categorytags') }}">
                            <i class="fa fa-tag mt-1 me-2"></i> Category Tags
                        </a>
                    </nav>
                </div>
                <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.managepackagedurations']) ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#packages"
                    aria-expanded="{{ Str::startsWith($currentRoute, ['admin.managepackagedurations']) ? 'true' : 'false' }}"
                    aria-controls="packages">
                    <div class="sb-nav-link-icon"><i class="fa fa-person-walking-luggage"></i></div>
                    Manage Packages
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.managepackagedurations']) ? 'show' : '' }}"
                    id="packages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ $currentRoute == 'admin.managepackagedurations' ? 'active' : ''}}"
                            href="{{ route('admin.managepackagedurations') }}">
                            <i class="fa fa-hourglass mt-1 me-2"></i> Package Duration
                        </a>
                        <!-- <a class="nav-link {{ $currentRoute == 'admin.category' || $currentRoute == 'admin.category.addcategory' || $currentRoute == 'admin.category.editcategory'  ? 'active' : ''}}"
                            href="{{ route('admin.category') }}">
                            <i class="fa fa-gg mt-1 me-2"></i> Category
                        </a>
                         <a class="nav-link {{ $currentRoute == 'admin.categorytags' || $currentRoute == 'admin.categorytags.addcategorytags' ||$currentRoute == 'admin.categorytags.editcategorytags' ? 'active' : '' }}"
                            href="{{ route('admin.categorytags') }}">
                            <i class="fa fa-tag mt-1 me-2"></i> Category Tags
                        </a> -->
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>