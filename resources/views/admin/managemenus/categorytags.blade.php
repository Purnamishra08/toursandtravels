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
        							<a href="{{ route('admin.categorytags.addcategorytags') }}"class="tab-menu__item  ">
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
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                            <div class="panel">
                                                <div class="panel-body">
                                                <form action="{{ route('admin.categorytags') }}" method="GET" class="form-inline">
                                                    <div class="form-group col-auto">
                                                        <label for="records-per-page" class="mr-2">Records per page:</label>
                                                        <select name="perPage" id="records-per-page" class="form-control form-control-sm" onchange="this.form.submit()">
                                                            <option value="10" {{ request()->get('perPage') == 10 ? 'selected' : '' }}>10</option>
                                                            <option value="20" {{ request()->get('perPage') == 20 ? 'selected' : '' }}>20</option>
                                                            <option value="100" {{ request()->get('perPage') == 100 ? 'selected' : '' }}>100</option>
                                                        </select>
                                                    </div>
                                                </form>


                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th>Sl #</th>
                                                                    <th>Menus</th>
                                                                    <th>Categories</th>
                                                                    <th>Tags</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($category_tags as $index => $category_tag)
                                                                <tr>
                                                                    <td>{{ ($category_tags->currentPage() - 1) *
                                                                    $category_tags->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $category_tag->menu_name }}</td>
                                                                    <td>{{ $category_tag->cat_name }}</td>
                                                                    <td>{{ $category_tag->tag_name }}</td>
                                                                    <td>
                                                                        @if($category_tag->status == 1)
                                                                            <form action="{{ route('admin.categorytags.activecategorytags', ['id' => $category_tag->tagid]) }}" method="POST"
                                                                                onsubmit="return confirm('Are you sure you want to change the status?')">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-outline-success"
                                                                                        title="Active. Click to deactivate.">
                                                                                        <span class="label-custom label label-success">Active</span>
                                                                                    </button>
                                                                            </form>
                                                                        @else
                                                                            <form action="{{ route('admin.categorytags.activecategorytags', ['id' => $category_tag->tagid]) }}" method="POST"
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
                                                                        <a href="{{ route('admin.categorytags.editcategorytags', $category_tag->tagid) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.categorytags.deletecategorytags',  $category_tag->tagid) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this destination type?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                <i class="fa-regular fa-trash-can"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center">No data available</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{-- Pagination Links --}}
                                                        <div class="pagination-wrapper d-flex justify-content-between align-items-center">
                                                            <p class="mb-0">
                                                                Showing {{ $category_tags->firstItem() }} to {{ $category_tags->lastItem() }} of {{ $category_tags->total() }} entries
                                                            </p>
                                                            {{ $category_tags->links('pagination::bootstrap-4') }}
                                                        </div>
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
</body>

</html>