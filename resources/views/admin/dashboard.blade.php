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
                                <section class="content"> 
                                    <div class="admin-panel-txt" style="text-align-last: center;font-size: xxx-large;font-weight: 800;"> Welcome to My Holiday Happiness</div>
                                    <div class="row"></div>
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

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="assets/js/chart.js"></script> 
    </body>
</html>