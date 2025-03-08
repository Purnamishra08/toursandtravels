<body>
    <header id="header">
        <nav class="navbar navbar-expand-xl fixed-top">
            <div class="container">
                <a href="#" class="navbar-brand"><img src="{{ asset('assets/img/web-img/duplicate-logo.png') }}" alt="logo" /></a>
                <a class="nav-link ms-auto me-3 mob-menu mt-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop" aria-current="page" href="#"><i class="bi bi-search text-white fs-5"></i></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="bi bi-text-right"></i></span>
                </button>
                <div class="offcanvas offcanvas-end" id="navbarOffcanvas" tabindex="-1"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title text-light" id="offcanvasNavbarLabel">
                            <a href="#" class="navbar-brand"><img src="{{ asset('assets/img/web-img/duplicate-logo.png') }}" alt="logo" /></a>
                        </h5>
                        <button type="button" class="btn-close btn-close-dark text-reset me-3"
                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#">About Us</a>
                            </li>

                            <!-- Below Destination is only show in desktop -->
                            <li class="nav-item submenu desktop-menu">
                                <a class="nav-link" href="#"> Destination </a>
                                <div class="mega-box">
                                    <div class="content">
                                        <div class="d-flex align-items-start">
                                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                                aria-orientation="vertical">
                                                <button class="nav-link active" id="v-pills-home-tab"
                                                    data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"
                                                    role="tab" aria-controls="v-pills-home" aria-selected="true">
                                                    Trending now
                                                </button>
                                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                                    aria-controls="v-pills-profile" aria-selected="false">
                                                    Quick Breaks
                                                </button>
                                                <button class="nav-link" id="v-pills-disabled-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-disabled" type="button" role="tab"
                                                    aria-controls="v-pills-disabled" aria-selected="false">
                                                    Most popular destination
                                                </button>
                                                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                                    aria-controls="v-pills-messages" aria-selected="false">
                                                    Explore States
                                                </button>
                                            </div>
                                            <div class="tab-content w-100" id="v-pills-tabContent">
                                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                    aria-labelledby="v-pills-home-tab" tabindex="0">
                                                    <ul class="submenu-container">
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li>
                                                            <a href="#">Destination Name Destination Name</a>
                                                        </li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                    aria-labelledby="v-pills-profile-tab" tabindex="0">
                                                    <ul class="submenu-container">
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li>
                                                            <a href="#">Destination Name Destination Name</a>
                                                        </li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-disabled" role="tabpanel"
                                                    aria-labelledby="v-pills-disabled-tab" tabindex="0">
                                                    <ul class="submenu-container">
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li>
                                                            <a href="#">Destination Name Destination Name</a>
                                                        </li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                    </ul>
                                                </div>
                                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                                                    aria-labelledby="v-pills-messages-tab" tabindex="0">
                                                    <ul class="submenu-container">
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li>
                                                            <a href="#">Destination Name Destination Name</a>
                                                        </li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                        <li><a href="#">Destination Name</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- Below Destination is only show in mobile -->
                            <li class="nav-item dropdown mob-menu">
                                <div class="accordion accordion-flush" id="parent-accordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#parentOne"
                                                aria-expanded="false" aria-controls="parentOne">
                                                Destination
                                            </button>
                                        </h2>
                                        <div id="parentOne" class="accordion-collapse collapse px-2"
                                            data-bs-parent="#parent-accordion">
                                            <!-- child Accordion -->
                                            <div class="accordion accordion-flush child-accordion" id="child-accordion">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#child-one"
                                                            aria-expanded="false" aria-controls="childOne">
                                                            Trending now
                                                        </button>
                                                    </h2>
                                                    <div id="child-one" class="accordion-collapse collapse"
                                                        data-bs-parent="#child-accordion">
                                                        <ul class="mob-sub-menu">
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li>
                                                                <a href="#">Destination Name Destination Name</a>
                                                            </li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#child-two"
                                                            aria-expanded="false" aria-controls="childOne">
                                                            Trending now
                                                        </button>
                                                    </h2>
                                                    <div id="child-two" class="accordion-collapse collapse"
                                                        data-bs-parent="#child-accordion">
                                                        <ul class="mob-sub-menu">
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li>
                                                                <a href="#">Destination Name Destination Name</a>
                                                            </li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#child-three"
                                                            aria-expanded="false" aria-controls="childOne">
                                                            Trending now
                                                        </button>
                                                    </h2>
                                                    <div id="child-three" class="accordion-collapse collapse"
                                                        data-bs-parent="#child-accordion">
                                                        <ul class="mob-sub-menu">
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li>
                                                                <a href="#">Destination Name Destination Name</a>
                                                            </li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#child-four"
                                                            aria-expanded="false" aria-controls="childOne">
                                                            Trending now
                                                        </button>
                                                    </h2>
                                                    <div id="child-four" class="accordion-collapse collapse"
                                                        data-bs-parent="#child-accordion">
                                                        <ul class="mob-sub-menu">
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li>
                                                                <a href="#">Destination Name Destination Name</a>
                                                            </li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                            <li><a href="#">Destination Name</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="#">Blogs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="../contactus.blade.php">Contact</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop" aria-current="page" href="#"><i class="bi bi-search"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasTopLabel">
                <a href="../index.blade.php" class="navbar-brand">
                <img src="{{ asset('assets/img/web-img/duplicate-logo.png') }}" alt="logo" />
                   </a>
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body text-center ">
               <div class="row justify-content-center">
                    <div class="col-8 mb-3">
                        <input type="text" class="form-control"  placeholder="Search">
                    </div>
               </div>
               <button class="btn btn-primary">Search</button>
             
            </div>
          </div>
    </header>