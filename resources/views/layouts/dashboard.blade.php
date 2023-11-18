<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themewagon.github.io/celestialAdmin-free-admin-template/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 13:20:12 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ getSchool()->name }}</title>
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
    <link rel="shortcut icon" href="{{ asset(\Storage::url(getSchool()->logo)) }}" />

    <style>
        .container.table .border {
            border-top: 1px solid #ccc !important;
            border-left: 1px solid #ccc !important;
            border-right: 1px solid #ccc !important;

        }

        .container.table .border:last-child {
            border-bottom: 1px solid #ccc !important;
        }
    </style>
    @yield('page_styles')
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center bg-md-dark">
                <a class="navbar-brand brand-logo" href="{{ route('staff.dashboard') }}"><img
                        src="{{ asset(\Storage::url(getSchool()->logo)) }}" alt="logo" class="w-auto" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{ route('staff.dashboard') }}">
                    <img src="{{ asset(\Storage::url(getSchool()->logo)) }}" alt="logo" class="w-auto" /></a>
                <button class="navbar-toggler navbar-toggler align-self-center d-none " type="button"
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
                            <a class="dropdown-item" href="{{ route('settings.index') }}">
                                <i class="typcn typcn-cog text-primary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('staff.logout') }}">
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
            @include('partials.staff_side_bar')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="d-flex ">
                        @if (\Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ \Session::get('message') }}
                                <button type="button" class="close btn text-danger" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (\Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ \Session::get('error') }}
                                <button type="button" class="close btn text-danger" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close btn text-danger" data-dismiss="alert"
                                    aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    Distributed By: <a href="{{ env('BASE_URL') }}" target="_blank">Eduportals</a>
                    </span>

            </div>
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
