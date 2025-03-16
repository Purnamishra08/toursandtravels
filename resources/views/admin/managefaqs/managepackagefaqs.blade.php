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
                        <nav class="tab-menu">
        							<a href="{{ route('admin.packagefaqs.addpackagefaqs') }}"class="tab-menu__item  ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        									<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
        								  </svg>
        								Add
        							</a>
        							<a href="#" class="tab-menu__item active ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
        									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
        									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
        								</svg>
        								View
        							</a>
        							<!-- table-utilities -->
        							<div class="table-utilities">
        								<!-- <strong class="manadatory me-1">*</strong>Indicates Mandatory -->
        							</div>
        							<!-- table-utilities end-->
        						</nav>
                                <!--Filter Box Start-->
                                <div class="filterBox collapse bg-light p-3" id="filterBox">
                                    <form id="filterForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label>Tour Package <span class="manadatory">*</span></label>
                                                <select data-placeholder="Choose Tour Package" class="form-control" tabindex="4" id="tag_id" name="tag_id" style="width: 100%;">
                                                    <option value=''>--Select Package</option>
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->tagid }}">
                                                            {{ $tag->tag_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Question Name -->
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Question</label>
                                                <input type="text" class="form-control" id="faq_question" name="faq_question"
                                                    value="{{ request('faq_question') }}">
                                            </div>
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Answer</label>
                                                <input type="text" class="form-control" id="faq_answer" name="faq_answer"
                                                    value="{{ request('faq_answer') }}">
                                            </div>
                                            <!-- Status -->
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Status</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="">--Select--</option>
                                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <!-- Submit and Reset Buttons -->
                                            <div class="col-sm-4 form-group mb-sm-0 align-self-end">
                                                <button class="btn btn-success mr-2" type="submit">Submit</button>
                                                <button class="btn btn-warning" type="reset" id="resetBtn">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="text-center filterBtn">
                                    <button type="button" class="showListBtn" data-bs-toggle="collapse"
                                        data-bs-target="#filterBox"><i class="fa fa-search"></i> Search</button>
                                </div>
                                <!--Filter Box End-->
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table id="faqTable" class="table table-bordered table-striped">
                                                <thead class="thead-dark">
                                                    <tr class="bg-info text-white">
                                                        <th width="2%">Sl #</th>
                                                        <th width="15%">Package</th>
                                                        <th width="15%">Questions</th>
                                                        <th width="20%">Answers</th>
                                                        <th width="2%">Order</th>
                                                        <th width="5%">Created</th>
                                                        <th width="3%">Status</th>
                                                        <th width="5%">Action</th>
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
                @include('Admin.include.footer')
                <!-- Footer End-->
                 
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
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
            var table = $('#faqTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.packagefaqs.data') }}",
                    type: "GET",
                    data: function (d) {
                        d.search = $('input[type="search"]').val();
                        d.tagid = $('#tag_id').val();
                        d.faq_question = $('#faq_question').val();
                        d.faq_answer = $('#faq_answer').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'tpackage_name', name: 'tpackage_name'},
                    { data: 'faq_question', name: 'faq_question' },
                    { data: 'faq_answer', name: 'faq_answer', render: function(data, type, row) {
                        return $('<div>').html(data).text(); // Decode HTML entities
                    }},
                    { data: 'faq_order', name: 'faq_order' },
                    { data: 'created_date', name: 'created_date' },
                    { data: 'status', name: 'status', orderable: false, searchable: false, render: function(data, type, row) {
                        return data; // Allow HTML rendering
                    }},
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
            // Handle form submission
            $('#filterForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                table.ajax.reload(); // Reload the DataTable with the new filters
            });

            // Handle reset button click
            $('#resetBtn').on('click', function () {
                $('#filterForm')[0].reset(); // Reset the form
                table.ajax.reload(); // Reload the DataTable without filters
            });
        });
    </script>
</body>

</html>