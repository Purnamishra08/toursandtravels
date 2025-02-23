<!-- Metaheader Section-->
@include('Admin.include.metaheader')
<!-- Metaheader Section End -->
<style>
    .form-container, .table-container {
    margin-bottom: 25px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16);
    background-color: #fff;
    padding: 25px;
    border-radius: 4px;
    }
    .table thead {
        background-color: #17a2b8;
        color: white;
    }
    .btn-sm i {
        margin-right: 5px;
    }
    thead th {
        background: linear-gradient(to right, #222, #444); /* Dark Gradient */
        color: black;
        text-align: center;
        padding: 10px;
        border-bottom: 2px solid #666;
    }
</style>
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
                                <li class="breadcrumb-item active">Manage State</li>
                            </ol>
                            @include('Admin.include.sweetaleart')
                            <section class="content">
                                <div class="row">
                                    <!-- Left Column: State Form -->
                                    <div class="col-sm-4">
                                        <div class="form-container">
                                            <form action="{{ route('admin.state.addState') }}" method="POST" id="stateform" name="stateform" class="add-state" onsubmit="return validator()" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group">
                                                    <label>State Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter state name" name="state_name" id="state_name">
                                                </div>

                                                <div class="form-group">
                                                    <label>State URL</label>
                                                    <input type="text" class="form-control" placeholder="Enter state URL" name="state_url" id="state_url">
                                                </div>

                                                <div class="form-group">
                                                    <label>Banner Image</label>
                                                    <input type="file" name="bannerimg" id="bannerimg" class="form-control-file">
                                                    <small class="text-muted">Image size should be 1920px X 488px</small>
                                                </div>

                                                <div class="form-group">
                                                    <label>Alt Tag for Banner Image</label>
                                                    <input type="text" class="form-control" placeholder="Enter Alt tag" name="alttag_banner" maxlength="60" id="alttag_banner">
                                                </div>

                                                <div class="form-group">
                                                    <label>Meta Title</label>
                                                    <textarea class="form-control" placeholder="Meta Title..." name="state_meta_title" id="state_meta_title"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Meta Keywords</label>
                                                    <textarea class="form-control" placeholder="Meta Keywords..." name="state_meta_keywords" id="state_meta_keywords"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Meta Description</label>
                                                    <textarea class="form-control" placeholder="Meta Description..." name="state_meta_description" id="state_meta_description"></textarea>
                                                </div>

                                                <div class="form-group form-check">
                                                    <input type="checkbox" class="form-check-input" name="showmenu" id="showmenu" value="1">
                                                    <label class="form-check-label" for="showmenu"><strong>Show this state on menu</strong></label>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Right Column: State Table -->
                                    <div class="col-sm-8">
                                        <div class="table-container">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    @if(session('m_message'))
                                                        <div class="alert alert-info">{{ session('m_message') }}</div>
                                                    @endif

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped">
                                                            <thead class="thead-dark">
                                                                <tr class="bg-info text-white">
                                                                    <th>Sl #</th>
                                                                    <th>State Name</th>
                                                                    <th>Show on Menu</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($states as $index => $state)
                                                                <tr>
                                                                    <td>{{ ($states->currentPage() - 1) *
                                                                    $states->perPage() + $loop->iteration }}</td>
                                                                    <td>{{ $state->state_name }}</td>
                                                                    <td>
                                                                        @if($state->showmenu)
                                                                            <span class="btn btn-success btn-sm"><i class="fa fa-check"></i></span>
                                                                        @else
                                                                            <span class="btn btn-danger btn-sm"><i class="fa fa-times"></i></span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                    @if($state->status == 1)
                                                                        <span style="color: green; font-weight: bold; position: relative; padding-left: 20px;">
                                                                            <span style="width: 10px; height: 10px; background: green; border-radius: 50%; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
                                                                            box-shadow: 0 0 8px rgba(0, 255, 0, 0.8);"></span>
                                                                            Active
                                                                        </span>
                                                                    @else
                                                                        <span style="color: red; font-weight: bold; position: relative; padding-left: 20px;">
                                                                            <span style="width: 10px; height: 10px; background: red; border-radius: 50%; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
                                                                            box-shadow: 0 0 8px rgba(255, 0, 0, 0.8);"></span>
                                                                            Inactive
                                                                        </span>
                                                                    @endif
                                                                    </td>
                                                                    <td>
                                                                        <a href="{{ route('admin.state', $state->state_id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                            <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <form action="{{ route('admin.state.deleteState', $state->state_id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this state?')">
                                                                            @csrf
                                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                                <i class="fa fa-trash-o"></i>
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
                                                                Showing {{ $states->firstItem() }} to {{ $states->lastItem() }} of {{ $states->total() }} entries
                                                            </p>
                                                            {{ $states->links('pagination::bootstrap-4') }}
                                                        </div>
                                                    </div>
                                                </div>
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
     
    <script>
        function validator(){
            if(!blankCheck('state_name','State name cannot be blank'))
                return false;
            if(!blankCheck('state_url','State URL cannot be blank'))
                return false;
            if(!blankCheck('alttag_banner','Alt Tag for Banner Image cannot be blank'))
                return false;
            if(!blankCheck('state_meta_title','State meta title cannot be blank'))
                return false;
            if(!blankCheck('state_meta_keywords','State meta keywords cannot be blank'))
                return false;
            if(!blankCheck('state_meta_description','State meta description cannot be blank'))
                return false;
        }
    </script>

    <script src="{{ asset('assets/js/validation.js') }}"></script>
</body>

</html>