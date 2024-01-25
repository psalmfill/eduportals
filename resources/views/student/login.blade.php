<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from themewagon.github.io/celestialAdmin-free-admin-template/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 13:20:40 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Eduportal Admin</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset(\Storage::url(getSchool()->logo)) }}" />

    <style>
        .content-wrapper {
            background-size: cover;
            background-image: url({{ getSettings() ? asset(\Storage::url(getSettings()->backdrop_image)) : '' }}) !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-center  text-left py-5 px-4 px-sm-5 card">
                            <div class="brand-logo">
                                <img src="{{ getSchool()->logo ? asset(\Storage::url(getSchool()->logo)) : asset('images/logo.svg') }}"
                                    alt="logo">

                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            @if (session()->has('error'))
                                <div class="alert alert-danger">
                                    <p>{{ session()->get('error') }}</p>
                                    {{-- <p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p> --}}
                                </div>
                            @endif
                            @if ($errors && $errors->count())
                            @endif
                            <form class="pt-3" action="{{ route('student.login') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <input type="text" name="reg_no" class="form-control form-control-lg"
                                        id="exampleInputEmail1" placeholder="Admission Number">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="mt-3">
                                    <button
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN
                                        IN</button>

                                </div>

                                {{-- <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div> <a href="#" class="auth-link text-black">Forgot password?</a> 
                                </div> --}}
                                {{-- <div class="mb-2">
                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                        <i class="typcn typcn-social-facebook-circular mr-2"></i>Connect using facebook
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Don't have an account? <a href="register.html" class="text-primary">Create</a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>
    <!-- endinject -->
</body>


<!-- Mirrored from themewagon.github.io/celestialAdmin-free-admin-template/pages/samples/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Apr 2023 13:20:40 GMT -->

</html>
