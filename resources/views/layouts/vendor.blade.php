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
                <a class="navbar-brand brand-logo" href="{{ route('vendor.dashboard') }}"><img
                        src="{{ asset('images/logo.svg') }}" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('vendor.dashboard') }}">
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
                            <a class="dropdown-item" href="{{ route('vendor.account.setting') }}">
                                <i class="typcn typcn-cog text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('vendor.logout') }}">
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
            <nav class="sidebar sidebar-offcanvas bg-dark" id="sidebar">
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
                        <a class="nav-link" href="{{ route('vendor.dashboard') }}">
                            <i class="typcn typcn-device-desktop menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), ['vendor.schools.index', 'vendor.school.create']) ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#schools-basic" aria-expanded="false"
                            aria-controls="schools-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Schools</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse" id="schools-basic">
                            <ul class="nav flex-column sub-menu">

                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), [
                                        'vendor.schools.index',
                                        'vendor.school.create',
                                        'vendor.staff.index',
                                        'vendor.staff.create',
                                    ])
                                        ? 'active'
                                        : '' }}"
                                        data-toggle="collapse" href="#staff-basic" aria-expanded="false"
                                        aria-controls="staff-basic">
                                        <i class="mdi mdi-folder-account menu-icon"></i>
                                        <span class="menu-title">Staff</span>
                                        <i class="typcn typcn-chevron-right menu-arrow"></i>
                                    </a>
                                    <div class="collapse" id="staff-basic">

                                        <ul class="nav flex-column sub-menu">
                                            <li class="nav-item">
                                                <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.staff.index']) ? 'active' : '' }}"
                                                    href="{{ route('vendor.staff.index') }}">
                                                    <span class="title">All Staff</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.staff.create']) ? 'active' : '' }}"
                                                    href="{{ route('vendor.staff.create') }}">
                                                    <span class="title">New Staff</span>
                                                </a>
                                                {{-- </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('vendor.staff.assign_classes') }}">
                                                    <span class="title">Assign Class</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('vendor.staff.assign_subjects') }}">
                                                    <span class="title">Assign Subject</span>
                                                </a>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('vendor.schools.index') }}">
                                        <span class="title">My Schools</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('vendor.schools.create') }}">
                                        <span class="title">Onboard School</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li
                        class="nav-item {{ in_array(Route::currentRouteName(), [
                            'vendor.pins.collections',
                            'vendor.pins.index',
                            'vendor.pins.collections.payments',
                        ])
                            ? 'active'
                            : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#pins-basic" aria-expanded="false"
                            aria-controls="pins-basic">
                            <i class="mdi mdi-folder-account menu-icon"></i>
                            <span class="menu-title">Pins</span>
                            <i class="typcn typcn-chevron-right menu-arrow"></i>
                        </a>
                        <div class="collapse {{ in_array(Route::currentRouteName(), [
                            'vendor.pins.collections',
                            'vendor.pins.index',
                            'vendor.pins.collections.payments',
                        ])
                            ? 'show'
                            : '' }}"
                            id="pins-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.pins.index']) ? 'active' : '' }}"
                                        href="{{ route('vendor.pins.index') }}">
                                        <span class="title">Buy Pins</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.pins.collections']) ? 'active' : '' }}"
                                        href="{{ route('vendor.pins.collections') }}">
                                        <span class="title">Collections</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.pins.collections.payments']) ? 'active' : '' }}"
                                        href="{{ route('vendor.pins.collections.payments') }}">
                                        <span class="title">Payments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.student_transfer']) ? 'active' : '' }}"
                            href="{{ route('vendor.student_transfer') }}">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Students Transfer</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ in_array(Route::currentRouteName(), ['vendor.account.setting']) ? 'active' : '' }}"
                            href="{{ route('vendor.account.setting') }}">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Account</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vendor.logout') }}">
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
