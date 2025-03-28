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
                                <!-- <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item active">Add User</li>
                                </ol> -->
                                <nav class="tab-menu">
                                    <a href="{{ isset($user) ? route('admin.manageUser.editUser', ['id' => $user->adminid]) : route('admin.manageUser.addUser') }}" 
                                    class="tab-menu__item active">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path>
                                        </svg>
                                        {{ isset($user) ? 'Edit' : 'Add' }}
                                    </a>
        							<a href="{{ route('admin.manageUser') }}" class="tab-menu__item ">
        								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
        									<path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
        									<path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
        								</svg>
        								View
        							</a>
        							<!-- table-utilities -->
        							<div class="table-utilities">
        								<strong class="manadatory me-1">*</strong>Indicates Mandatory
        							</div>
        							<!-- table-utilities end-->
        						</nav>
                                @include('admin.include.sweetaleart')
                                <section class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-bd lobidrag">
                                                <!-- <div class="panel-heading">
                                                    <div class="btn-group" id="buttonexport">
                                                        <a href="{{ route('admin.manageUser') }}">
                                                            <h4><i class="fa fa-plus-circle"></i> Manage Users</h4>
                                                        </a>
                                                    </div>
                                                </div> -->
                                                <div class="panel-body">
                                                    <form action="{{ isset($user) ? route('admin.manageUser.editUser', ['id' => $user->adminid]) : route('admin.manageUser.addUser') }}" method="POST" id="userform" name="userform" class="add-user" onsubmit="return {{ isset($user) ? 'validateFormEditUser()' : 'validateFormAddUser()' }}">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Name  <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter name" name="uname" id="uname" 
                                                                        value="{{ isset($user) ? $user->admin_name : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label class="d-block">User Type  <span class="manadatory">*</span></label>
                                                                @if(isset($user) && $user->admin_type == 1)
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="utype" id="utype1" value="1" 
                                                                            {{ isset($user) && $user->admin_type == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="utype1">Super Admin</label>
                                                                    </div>
                                                                @else
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="utype" id="utype2" value="2" 
                                                                            {{ isset($user) && $user->admin_type == 2 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="utype2">Admin</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="utype" id="utype2" value="3" 
                                                                            {{ isset($user) && $user->admin_type == 3 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="utype2">User</label>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Contact No.  <span class="manadatory">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Enter Contact no" name="contact" id="contact" 
                                                                        value="{{ isset($user) ? $user->contact_no : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Email  <span class="manadatory">*</span></label>
                                                                    <input type="email" class="form-control" placeholder="Enter Email Id" name="email" id="email" 
                                                                        value="{{ isset($user) ? $user->email_id : '' }}">
                                                                </div>
                                                            </div>

                                                            @if(!isset($user))
                                                            <!-- Show Password Fields Only in Add Mode -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Password  <span class="manadatory">*</span></label>
                                                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Confirm Password  <span class="manadatory">*</span></label>
                                                                    <input type="password" class="form-control" placeholder="Enter Confirm Password" name="cpassword" id="cpassword">
                                                                </div>
                                                            </div>
                                                            @endif

                                                            <div class="col-md-12">
                                                                <table id="modulesTable" class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SL No</th>
                                                                            <th>Module Name</th>
                                                                            <th>Module Access</th>
                                                                            <th>Module Delete Access</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @php $cnt = 0; @endphp
                                                                        @foreach ($modules as $module)
                                                                            @php 
                                                                                $cnt++; 
                                                                                $isChecked = in_array($module->moduleid, old('modules', $selectedModules ?? [])) ? 'checked' : '';
                                                                                $isDisabled = isset($user) && $user->admin_type == 1 ? 'disabled' : '';
                                                                                $accessValue = $moduleAccess[$module->moduleid] ?? 0;
                                                                                if (isset($user) && $user->admin_type == 1) {
                                                                                    $accessValue = 1;
                                                                                    $accessDisabled = 'disabled';
                                                                                } else {
                                                                                    $accessDisabled = $isChecked ? '' : 'disabled';
                                                                                }
                                                                            @endphp
                                                                            <tr>
                                                                                <td>{{ $cnt }}</td>
                                                                                <td>{{ $module->module }}</td>
                                                                                <td>
                                                                                    <input type="checkbox" name="modules[]" value="{{ $module->moduleid }}"
                                                                                        id="module_{{ $module->moduleid }}"
                                                                                        {{ $isChecked }}
                                                                                        {{ $isDisabled }}
                                                                                        onchange="toggleAccess({{ $module->moduleid }})">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="radio" name="access[{{ $module->moduleid }}]" value="1"
                                                                                        id="access_yes_{{ $module->moduleid }}"
                                                                                        {{ $accessValue == 1 ? 'checked' : '' }}
                                                                                        {{ $accessDisabled }}>
                                                                                    <label for="access_yes_{{ $module->moduleid }}">Yes</label>

                                                                                    <input type="radio" name="access[{{ $module->moduleid }}]" value="0"
                                                                                        id="access_no_{{ $module->moduleid }}"
                                                                                        {{ $accessValue == 0 ? 'checked' : '' }}
                                                                                        {{ $accessDisabled }}>
                                                                                    <label for="access_no_{{ $module->moduleid }}">No</label>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="reset-button">
                                                                <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
                                                                @if(!isset($user))
                                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        
        
        <script>
            function toggleAccess(moduleId) {
                let checkbox = document.getElementById('module_' + moduleId);
                let yesRadio = document.getElementById('access_yes_' + moduleId);
                let noRadio = document.getElementById('access_no_' + moduleId);

                if (checkbox.checked) {
                    yesRadio.removeAttribute('disabled');
                    noRadio.removeAttribute('disabled');
                } else {
                    yesRadio.setAttribute('disabled', 'disabled');
                    noRadio.setAttribute('disabled', 'disabled');
                    noRadio.checked = true; // Default to "No" when unchecked
                }
            }
        </script>

    </body>
</html>