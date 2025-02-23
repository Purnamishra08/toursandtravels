<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <a class="navbar-brand ps-3 logoText mt-2 mb-3" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset('assets/img/duplicare-logo-dashbord.png') }}" alt="logo" class="leftmenu-logo" /></a>
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-speedometer"></i></div>
                    Dashboard
                </a>

                @if(session()->has('user') && session('user')->admin_type == 1)
                <a class="nav-link {{ request()->routeIs('admin.manageUser*') ? 'active' : '' }}"
                    href="{{ route('admin.manageUser') }}">
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                    Manage User
                </a>
                @endif
                <a class="nav-link dropdown {{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.manageVehicleprice*') ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#manageVehicles"
                    aria-expanded="{{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.manageVehicleprice*') ? 'true' : 'false' }}"
                    aria-controls="manageVehicles">
                    <div class="sb-nav-link-icon"><i class="fa fa-truck"></i></div>
                    Manage Vehicles
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.manageVehicleprice*') ? 'show' : '' }}"
                    id="manageVehicles" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.manageVehicletype') ? 'active' : '' }}"
                            href="{{ route('admin.manageVehicletype') }}">
                            <i class="fa fa-car mt-1 me-2"></i> Vehicle Type
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.manageVehicleprice*') ? 'active' : '' }}"
                            href="{{ route('admin.manageVehicleprice') }}">
                            <i class="fa fa-money mt-1 me-2"></i> Vehicle Price
                        </a>
                    </nav>
                </div>
                <a class="nav-link dropdown {{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.manageVehicleprice*') ? '' : 'collapsed' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#manageHotels"
                    aria-expanded="{{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.manageVehicleprice*') ? 'true' : 'false' }}"
                    aria-controls="manageHotels">
                    <div class="sb-nav-link-icon"><i class="fa fa-hotel"></i></div>
                    Manage Hotels
                    <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                </a>

                <div class="collapse {{ request()->routeIs('admin.manageVehicletype') || request()->routeIs('admin.vehicle-price*') ? 'show' : '' }}"
                    id="manageHotels" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->routeIs('admin.manageVehicletype') ? 'active' : '' }}"
                            href="{{ route('admin.manageVehicletype') }}">
                            <i class="fa fa-hotel mt-1 me-2"></i> Hotel Type
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.manageVehicleprice*') ? 'active' : '' }}"
                            href="">
                            <i class="fa fa-sun-o mt-1 me-2"></i> Season Type
                        </a>
                        <a class="nav-link {{ request()->routeIs('admin.manageVehicleprice*') ? 'active' : '' }}"
                            href="">
                            <i class="fa fa-hotel mt-1 me-2"></i> Hotel
                        </a>
                    </nav>
                </div>


                <!-- <a class="nav-link" href="tourist-registration.php"> 
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                     Tourist Registration List
                </a> -->
                <!-- <a class="nav-link" href="view-generated-passlist.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                     Generated Pass List
                </a>
                <a class="nav-link" href="view-transaction.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                     Booking & Transcations
                </a>
                <a class="nav-link" href="#"> 
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                    Booking Settlement
                </a>
                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                    Revenue Report
                </a> -->
                <!-- <a class="nav-link" href="view-feedback.php"> 
                    <div class="sb-nav-link-icon"><i class="bi bi-layout-split"></i></div>
                     Feedback
                </a>                       -->
            </div>
        </div>
    </nav>
</div>