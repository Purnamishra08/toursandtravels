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
        							<a href="#" class="tab-menu__item active ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
        									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
        									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
        								</svg>
        								View
        							</a>
        						</nav>
                            @include('admin.include.sweetaleart')
                            <section class="content">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table id="generalsettingstable" class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th>Sl #</th>
                                                                    <th>Parameter</th>
                                                                    <th width="60%">Parameter Value</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">

    <!-- jQuery (Required for DataTables) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var table = $('#generalsettingstable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: "{{ route('admin.generalsettings.data') }}",
                        type: "GET",
                        data: function (d) {
                            d.search = $('input[type="search"]').val();
                        }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'parameter', name: 'parameter' },
                    { data: 'par_value', name: 'par_value' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, render: function(data, type, row) {
                        return data; // Render buttons properly
                    }}
                ],
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                language: {
                search: "Filter records:",
                },
            });
        });
    </script>
</body>

</html>