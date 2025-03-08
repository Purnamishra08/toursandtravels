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
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Welcome to My Holiday Happiness</li>
                                </ol>
                                <!-- <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex justify-content-between">
                                                        <div class="align-self-center">
                                                            <i class="bi bi-pencil primary font-large-2 float-left"></i>
                                                        </div>
                                                        <div class="text-right">
                                                            <h3>278</h3>
                                                            <span>New Posts</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1 mb-0" style="height: 7px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"
                                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex justify-content-between">
                                                        <div class="align-self-center">
                                                            <i class="bi bi-chat-left-text warning font-large-2 float-left"></i>
                                                        </div>
                                                        <div class=" text-right">
                                                            <h3>156</h3>
                                                            <span>New Comments</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1 mb-0" style="height: 7px;">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 35%"
                                                            aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex justify-content-between">
                                                        <div class="align-self-center">
                                                            <i class="bi bi-bar-chart success font-large-2 float-left"></i>
                                                        </div>
                                                        <div class="text-right">
                                                            <h3>64.89 %</h3>
                                                            <span>Bounce Rate</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1 mb-0" style="height: 7px;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%"
                                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-4">
                                        <div class="card">
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <div class="media d-flex justify-content-between">
                                                        <div class="align-self-center">
                                                            <i class="bi bi-geo-alt danger font-large-2 float-left"></i>
                                                        </div>
                                                        <div class="text-right">
                                                            <h3>423</h3>
                                                            <span>Total Visits</span>
                                                        </div>
                                                    </div>
                                                    <div class="progress mt-1 mb-0" style="height: 7px;">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 40%"
                                                            aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Pie Chart
                                            </div>
                                            <div class="card-body">
                                                <div id="pieChart" style="height: 250px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <i class="fas fa-chart-bar me-1"></i>
                                                Bar Chart
                                            </div>
                                            <div class="card-body">
                                                <div id="barChart" style="height: 250px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-table me-1"></i>
                                        DataTable Example
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Office</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>61</td>
                                                    <td>2011/04/25</td>
                                                    <td>$320,800</td>
                                                </tr>
                                                <tr>
                                                    <td>Garrett Winters</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>63</td>
                                                    <td>2011/07/25</td>
                                                    <td>$170,750</td>
                                                </tr>
                                                <tr>
                                                    <td>Ashton Cox</td>
                                                    <td>Junior Technical Author</td>
                                                    <td>San Francisco</td>
                                                    <td>66</td>
                                                    <td>2009/01/12</td>
                                                    <td>$86,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Cedric Kelly</td>
                                                    <td>Senior Javascript Developer</td>
                                                    <td>Edinburgh</td>
                                                    <td>22</td>
                                                    <td>2012/03/29</td>
                                                    <td>$433,060</td>
                                                </tr>
                                                <tr>
                                                    <td>Airi Satou</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>33</td>
                                                    <td>2008/11/28</td>
                                                    <td>$162,700</td>
                                                </tr>
                                                <tr>
                                                    <td>Brielle Williamson</td>
                                                    <td>Integration Specialist</td>
                                                    <td>New York</td>
                                                    <td>61</td>
                                                    <td>2012/12/02</td>
                                                    <td>$372,000</td>
                                                </tr>
                                                <tr>
                                                    <td>Herrod Chandler</td>
                                                    <td>Sales Assistant</td>
                                                    <td>San Francisco</td>
                                                    <td>59</td>
                                                    <td>2012/08/06</td>
                                                    <td>$137,500</td>
                                                </tr>
                                                <tr>
                                                    <td>Rhona Davidson</td>
                                                    <td>Integration Specialist</td>
                                                    <td>Tokyo</td>
                                                    <td>55</td>
                                                    <td>2010/10/14</td>
                                                    <td>$327,900</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> -->
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

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="assets/js/chart.js"></script> 
    </body>
</html>