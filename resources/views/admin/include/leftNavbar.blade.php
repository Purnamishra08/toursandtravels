<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <a class="navbar-brand ps-3 logoText mt-2 mb-3" href="{{ route('admin.dashboard') }}"><img
                src="{{ asset('assets/img/logo.png') }}" alt="logo" class="leftmenu-logo" /></a>
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
                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[5]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.manageVehicletype', 'admin.manageVehicleprice']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#manageVehicles"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageVehicletype', 'admin.manageVehicleprice']) ? 'true' : 'false' }}"
                        aria-controls="manageVehicles">
                        <div class="sb-nav-link-icon"><i class="fa fa-truck"></i></div>
                        Manage Vehicles
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

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

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[12]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.manageHoteltype','admin.manageSeasontype','admin.manageHotels']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#manageHotels"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageHoteltype','admin.manageSeasontype','admin.manageHotels']) ? 'true' : 'false' }}"
                        aria-controls="manageHotels">
                        <div class="sb-nav-link-icon"><i class="fa fa-building"></i></div>
                        Manage Hotels
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif
                
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
                
                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[6]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{ Str::startsWith($currentRoute, ['admin.state','admin.destinationtype']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#locations"
                        aria-expanded="{{  Str::startsWith($currentRoute, ['admin.state','admin.destinationtype']) ? 'true' : 'false' }}"
                        aria-controls="locations">
                        <div class="sb-nav-link-icon"><i class="fa fa-globe"></i></div>
                        Manage Location
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.state','admin.destinationtype','admin.destination', 'admin.places']) ? 'show' : '' }}"
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
                        
                        <a class="nav-link {{ (Route::currentRouteName() == 'admin.destination' || Route::currentRouteName() == 'admin.destination.adddestination' || Route::currentRouteName() == 'admin.destination.editdestination') ? 'active' : '' }}"
                        href="{{ route('admin.destination') }}">
                            <i class="fa fa-location-dot mt-1 me-2"></i> Destinations
                        </a>

                        <a class="nav-link {{  Str::startsWith($currentRoute, ['admin.places']) ? 'active' : '' }}"
                            href="{{ route('admin.places') }}">
                            <i class="fa fa fa-bookmark mt-1 me-2"></i> Places
                        </a>
                    </nav>
                </div>

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[8]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#menus"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags']) ? 'true' : 'false' }}"
                        aria-controls="menus">
                        <div class="sb-nav-link-icon"><i class="fa fa-th-list"></i></div>
                        Manage Menus
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.category', 'admin.categorytags', 'admin.menutag']) ? 'show' : '' }}"
                    id="menus" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ $currentRoute == 'admin.menutag' || $currentRoute == 'admin.category.addmenutag' || $currentRoute == 'admin.category.editmenutag'  ? 'active' : ''}}"
                            href="{{ route('admin.menutag') }}">
                            <i class="fa-solid fa-tags mt-1 me-2"></i> Menu Tags
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

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[10]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.managepackagedurations','admin.managetourpackages']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#packages"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.managepackagedurations','admin.managetourpackages']) ? 'true' : 'false' }}"
                        aria-controls="packages">
                        <div class="sb-nav-link-icon"><i class="fa fa-person-walking-luggage"></i></div>
                        Manage Packages
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.managepackagedurations','admin.managetourpackages']) ? 'show' : '' }}"
                    id="packages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.managepackagedurations']) ? 'active' : ''}}"
                            href="{{ route('admin.managepackagedurations') }}">
                            <i class="fa fa-hourglass mt-1 me-2"></i> Package Durations
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.managetourpackages']) ? 'active' : ''}}"
                            href="{{ route('admin.managetourpackages') }}">
                            <i class="fa fa-route mt-1 me-2"></i> Tour Packages
                        </a>
                    </nav>
                </div>

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[4]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.manageenquiry','admin.manageitineraryenquiry','admin.managepackageenquiry']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#manageenquiries"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageenquiry','admin.manageitineraryenquiry','admin.managepackageenquiry']) ? 'true' : 'false' }}"
                        aria-controls="manageenquiries">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-person-circle-question"></i></div>
                        Manage Enquiries
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.manageenquiry','admin.manageitineraryenquiry','admin.managepackageenquiry']) ? 'show' : '' }}"
                    id="manageenquiries" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.manageenquiry']) ? 'active' : ''}}"
                            href="{{ route('admin.manageenquiry') }}">
                            <i class="fa-solid fa-question mt-1 me-2"></i> Enquiry
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.manageitineraryenquiry']) ? 'active' : ''}}"
                            href="{{ route('admin.manageitineraryenquiry') }}">
                            <i class="fa-solid fa-circle-question mt-1 me-2"></i>Itinerary Enquiry
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.managepackageenquiry']) ? 'active' : ''}}"
                            href="{{ route('admin.managepackageenquiry') }}">
                            <i class="fa-solid fa-clipboard-question mt-1 me-2"></i>Package Enquiry
                        </a>
                    </nav>
                </div>
                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[20]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.sources','admin.manageitineraryenquiry','admin.managepackageenquiry']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#managefollowenquiries"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.sources','admin.manageitineraryenquiry','admin.managepackageenquiry']) ? 'true' : 'false' }}"
                        aria-controls="managefollowenquiries">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-phone"></i></div>
                        Follow Up Enquiries
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.sources','admin.statuslist','admin.manageenquiriesentry','admin.manageenquiriesreport']) ? 'show' : '' }}"
                    id="managefollowenquiries" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.sources']) ? 'active' : ''}}"
                            href="{{ route('admin.sources') }}">
                            <i class="fa-solid fa-s mt-1 me-2"></i> Sources
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.statuslist']) ? 'active' : ''}}"
                            href="{{ route('admin.statuslist') }}">
                            <i class="fa-solid fa-comment-dots mt-1 me-2"></i>Status List
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.manageenquiriesentry']) ? 'active' : ''}}"
                            href="{{ route('admin.manageenquiriesentry') }}">
                            <i class="fa-solid fa-keyboard mt-1 me-2"></i>Enquiries Entry
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.manageenquiriesreport']) ? 'active' : ''}}"
                            href="{{ route('admin.manageenquiriesreport') }}">
                            <i class="fa-solid fa-receipt mt-1 me-2"></i>Enquiries Report
                        </a>
                    </nav>
                </div>

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[2]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link {{ request()->routeIs('admin.generalsettings*') ? 'active' : '' }}"
                        href="{{ route('admin.generalsettings') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-user"></i></div>
                        General Settings
                    </a>
                @endif

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[13]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link {{ request()->routeIs('admin.managereviews*') ? 'active' : '' }}"
                        href="{{ route('admin.managereviews') }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-comment"></i></div>
                        Manage Reviews
                    </a>
                @endif

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[16]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.commonfaqs', 'admin.packagefaqs']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#faqs"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.commonfaqs', 'admin.packagefaqs']) ? 'true' : 'false' }}"
                        aria-controls="faqs">
                        <div class="sb-nav-link-icon"><i class="fa fa-question"></i></div>
                        Manage Faqs
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.commonfaqs','admin.packagefaqs']) ? 'show' : '' }}"
                    id="faqs" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.commonfaqs']) ? 'active' : ''}}"
                            href="{{ route('admin.commonfaqs') }}">
                            <i class="fa fa-question mt-1 me-2"></i> Common Faqs
                        </a>
                        <a class="nav-link {{ Str::startsWith($currentRoute, ['admin.packagefaqs']) ? 'active' : ''}}"
                            href="{{ route('admin.packagefaqs') }}">
                            <i class="fa fa-question-circle mt-1 me-2"></i> Package Faqs
                        </a>
                    </nav>
                </div>

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[3]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link {{ request()->routeIs('admin.managecms*') ? 'active' : '' }}"
                        href="{{ route('admin.managecms', ['id' => $id ?? 1]) }}">
                        <div class="sb-nav-link-icon"><i class="fa fa-tasks"></i></div>
                        Manage CMS
                    </a>
                @endif

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[11]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link {{ request()->routeIs('admin.footerlinks*') ? 'active' : '' }}"
                        href="{{ route('admin.footerlinks') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-down"></i></div>
                        Manage Footer Links
                    </a>
                @endif

                @if(
                        (session()->has('moduleAccess') && session('user')->admin_type != 1 && isset(session('moduleAccess')[14]))
                        || (session()->has('user') && session('user')->admin_type == 1)
                    )
                    <a class="nav-link dropdown {{Str::startsWith($currentRoute, ['admin.manageblogs', 'admin.manageblogscomments']) ? '' : 'collapsed' }}"
                        href="#" data-bs-toggle="collapse" data-bs-target="#blogs"
                        aria-expanded="{{ Str::startsWith($currentRoute, ['admin.manageblogs', 'admin.manageblogscomments']) ? 'true' : 'false' }}"
                        aria-controls="blogs">
                        <div class="sb-nav-link-icon"><i class="fa-brands fa-blogger"></i></div>
                        Manage Blogs
                        <div class="sb-sidenav-collapse-arrow"><i class="bi bi-chevron-down"></i></div>
                    </a>
                @endif

                <div class="collapse {{ Str::startsWith($currentRoute, ['admin.manageblogs', 'admin.manageblogscomments']) ? 'show' : '' }}"
                    id="blogs" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Route::is('admin.manageblogs') ? 'active' : '' }}" 
                            href="{{ route('admin.manageblogs') }}">
                            <i class="fa-solid fa-closed-captioning mt-1 me-2"></i> Blogs
                        </a>

                        <a class="nav-link {{ Route::is('admin.manageblogscomments') ? 'active' : '' }}" 
                            href="{{ route('admin.manageblogscomments') }}">
                            <i class="fa fa-question-circle mt-1 me-2"></i> Comments
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>