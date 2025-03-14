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
        							<a href="{{ route('admin.managereviews.addreviews') }}"class="tab-menu__item  ">
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
                                    <form action="{{ route('admin.managereviews') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <!-- Hotel Name -->
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Name</label>
                                                <input type="text" class="form-control" id="reviewer_name" name="reviewer_name"
                                                    value="{{ request('reviewer_name') }}">
                                            </div>
                                            <div class="col-sm-6 form-group mb-sm-0">
                                                <label class="control-label">Location</label>
                                                <input type="text" class="form-control" id="reviewer_loc" name="reviewer_loc"
                                                    value="{{ request('reviewer_loc') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ratings</label>
                                                    <select class="form-control" name="no_of_star" id="no_of_star">
                                                        <option value="0">Select Rating</option>
                                                        <option value="1" {{ request('no_of_star') == '1' ? 'selected' : '' }}>1</option>
                                                        <option value="1.5" {{ request('no_of_star') == '1.5' ? 'selected' : '' }}>1.5</option>
                                                        <option value="2" {{ request('no_of_star') == '2' ? 'selected' : '' }}>2</option>
                                                        <option value="2.5" {{ request('no_of_star') == '2.5' ? 'selected' : '' }}>2.5</option>
                                                        <option value="3" {{ request('no_of_star') == '3' ? 'selected' : '' }}>3</option>
                                                        <option value="3.5" {{ request('no_of_star') == '3.5' ? 'selected' : '' }}>3.5</option>
                                                        <option value="4" {{ request('no_of_star') == '4' ? 'selected' : '' }}>4</option>
                                                        <option value="4.5" {{ request('no_of_star') == '4.5' ? 'selected' : '' }}>4.5</option>
                                                        <option value="5" {{ request('no_of_star') == '5' ? 'selected' : '' }}>5</option>
                                                    </select>
                                                </div>
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
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th width="2%">Sl #</th>
                                                                    <th width="10%">Name</th>
                                                                    <th width="10%">Location</th>
                                                                    <th width="10%">Tour Tags</th>
                                                                    <th width="5%">No of Star</th>
                                                                    <th width="25%">Review</th>
                                                                    <th width="10%">Review Date</th>
                                                                    <th width="8%">Status</th>
                                                                    <th width="10%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($reviews as $index => $review)
                                                                <tr>
                                                                    <td>{{ ($reviews->currentPage() - 1) *
                                                                    $reviews->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $review->reviewer_name }}</td>
                                                                    <td>{{ $review->reviewer_loc }}</td>
                                                                    <td>{{ $review->tag_name }}</td>
                                                                    <td>{{ $review->no_of_star }}</td>
                                                                    <td>{{ $review->feedback_msg }}</td>
                                                                    <td>{{ $review->updated_date }}</td>
                                                                    <td>
                                                                        @if($review->status == 1)
                                                                            <form action="{{ route('admin.managereviews.activereviews', ['id' => $review->review_id]) }}" method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-outline-success"
                                                                                        title="Active. Click to deactivate.">
                                                                                        <span class="label-custom label label-success">Active</span>
                                                                                    </button>
                                                                            </form>
                                                                        @else
                                                                            <form action="{{ route('admin.managereviews.activereviews', ['id' => $review->review_id]) }}" method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-outline-dark"
                                                                                    title="Active. Click to deactivate.">
                                                                                    <span class="label-custom label label-danger">Inactive</span>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.managereviews.editreviews', $review->review_id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm view" title="View" onclick="loadReviewDetails({{ $review->review_id }})">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.managereviews.deletereviews',  $review->review_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this review ?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                <i class="fa-regular fa-trash-can"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="9" class="text-center">No data available</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} entries
                                                            </p>
                                                            {{ $reviews->links('pagination::bootstrap-4') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            </section>
                        </div>
                    </div>
                </main>
                <div id="userModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="userModalLabel">Review Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="dynamicModalContainer" class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Start-->
                @include('Admin.include.footer')
                <!-- Footer End-->
                 
            </div>
        </div>
    </div>
    <!-- FooterJs Start-->
    @include('Admin.include.footerJs')
    <!-- FooterJs End-->
    <script>
        function loadReviewDetails(reviewId) {
            $('#userModal .modal-body').html('<div style="text-align:center;margin-top:150px;margin-bottom:100px;color:#377b9e;"><i class="fa fa-spinner fa-spin fa-3x"></i> <span>Processing...</span></div>');

            $.ajax({
                url: "{{ url('/managereviews/viewpop') }}",
                type: "POST",
                data: { reqId: reviewId },
                dataType: "json",
                cache: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    if (response.error) {
                        alert("Error: " + response.error);
                    } else {
                        $("#dynamicModalContainer").html(response.html); // Inject only the dynamic content
                        $("#userModal").modal("show"); // Show the modal
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", xhr.responseText);
                    alert("Status: " + status + "\nError: " + xhr.responseText);
                }
            });
        }
        $(document).on('click', '[data-dismiss="modal"]', function () {
            $('#userModal').modal('hide');
        });
    </script>
</body>

</html>