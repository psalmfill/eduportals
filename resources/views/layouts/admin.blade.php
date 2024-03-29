<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themewagon.github.io/celestialAdmin-free-admin-template/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 13:20:12 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Eduportals</title>
    <!-- base:css -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-icons/entypo/css/entypo.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    @yield('page_styles')
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="{{ route('admin.dashboard') }}"><img
                        src="{{ asset('images/logo.svg') }}" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="logo" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
                    data-toggle="minimize">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown"
                            id="profileDropdown">
                            <i class="typcn typcn-user-outline mr-0"></i>
                            <span class="nav-profile-name"> {{ user()->first_name }} {{ user()->last_name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="typcn typcn-cog text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="typcn typcn-power text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="typcn typcn-th-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <div class="d-flex sidebar-profile">
                            <div class="sidebar-profile-image">
                                <img src="{{ asset('images/faces/face29.png') }}" alt="image">
                                <span class="sidebar-status-indicator"></span>
                            </div>
                            <div class="sidebar-profile-name">
                                <p class="sidebar-name">
                                    {{ user()->first_name }} {{ user()->last_name }}
                                </p>
                                <p class="sidebar-designation">
                                    Welcome
                                </p>
                            </div>
                        </div>
                        <p class="sidebar-menu-title">Dashboard menu</p>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.dashboard') }}">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['vendors.index', 'vendor-categories.index']) ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#vendors-basic" aria-expanded="false"
                            aria-controls="vendors-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Vendors</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), ['vendors.index', 'vendor-categories.index']) ? 'show' : '' }}"
                            id="vendors-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendors.index']) ? 'active' : '' }}"
                                        href="{{ route('vendors.index') }}">
                                        <span class="title">All Vendors</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor-categories.index']) ? 'active' : '' }}"
                                        href="{{ route('vendor-categories.index') }}">
                                        <span class="title">Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['schools.index', 'schools.create', 'school-categories.index']) ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#schools-basic" aria-expanded="false"
                            aria-controls="schools-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Schools</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), ['schools.index', 'schools.create', 'school-categories.index']) ? 'show' : '' }}"
                            id="schools-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['schools.index']) ? 'active' : '' }}"
                                        href="{{ route('schools.index') }}">
                                        <span class="title">All Schools</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['schools.create']) ? 'active' : '' }}"
                                        href="{{ route('schools.create') }}">
                                        <span class="title">Onboard School</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['school-categories.index']) ? 'active' : '' }}"
                                        href="{{ route('school-categories.index') }}">
                                        <span class="title">Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#admins-basic" aria-expanded="false"
                            aria-controls="admins-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Admins</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse" id="admins-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link " href="{{ route('schools.index') }}">
                                        <span class="title">All Schools</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('school-categories.index') }}">
                                        <span class="title">Categories</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['pins.index', 'pins.collections']) ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#pins-basic" aria-expanded="false"
                            aria-controls="pins-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Pins</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse" id="pins-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link  {{ in_array(Route::currentRouteName(), ['pins.index']) ? 'active' : '' }}"
                                        href="{{ route('pins.index') }}">
                                        <span class="title">Generate Pins</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  {{ in_array(Route::currentRouteName(), ['pins.collections']) ? 'active' : '' }}"
                                        href="{{ route('pins.collections') }}">
                                        <span class="title">Collections</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li
                        class="nav-item  {{ in_array(Route::currentRouteName(), ['admin.roles.index', 'academic-sessions.index']) ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#settings-basic" aria-expanded="false"
                            aria-controls="settings-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Settings</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), ['admin.roles.index', 'academic-sessions.index']) ? 'show' : '' }}"
                            id="settings-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link  {{ in_array(Route::currentRouteName(), ['admin.roles.index']) ? 'active' : '' }}"
                                        href="{{ route('admin.roles.index') }}">
                                        <span class="title">Roles</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('school-categories.create') }}">
                                        <span class="title">Permissions</span>
                                    </a>
                                </li>

                                <li
                                    class="nav-item  {{ in_array(Route::currentRouteName(), ['academic-sessions.index']) ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('academic-sessions.index') }}">
                                        <span class="title">Sessions</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.logout') }}">
                            <i class="mdi mdi-logout menu-icon"></i>
                            <span class="menu-title">Logout</span>
                        </a>
                    </li>
                </ul>

            </nav>


            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @if (\Session::has('message'))
                                <div class="alert alert-success">
                                    {{ \Session::get('message') }}
                                </div>
                            @endif
                            @if (\Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ \Session::get('error') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    Distributed By: <a href="{{ env('BASE_URL') }}" target="_blank">Eduportals</a>

                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="{{ asset('assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js') }}"></script>
    <!-- base:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->
    <script>
        const BASE_URL = " {{ url('') }}"
    </script>
    @yield('page_scripts')
</body>

<!-- Mirrored from themewagon.github.io/celestialAdmin-free-admin-template/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 13:20:24 GMT -->

</html>
