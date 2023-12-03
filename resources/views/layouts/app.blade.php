<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- title -->
    <title>Eduportals E-SIMS</title>
    <meta content="Eduportals" name="author" />
    <meta content="Best School information management system" name="description" />

    <!-- theme favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">


    <!-- third party plugins -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.min.css') }}" type="text/css" />

    <!-- theme css -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" type="text/css" />
</head>

<body>


    <div class="header-2 primary">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light zindex-10">
                <div class="container">
                    <a class="navbar-brand logo" href="/">
                        <img src="/images/logo.svg" height="30" class="align-top" alt="" />
                        {{-- <img src="/images/logo-light.png" height="30" class="align-top logo-light"
                            alt="" /> --}}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#topnav-menu-content" aria-controls="topnav-menu-content" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav align-items-lg-center d-flex me-auto">

                        </ul>


                        <ul class="navbar-nav align-items-lg-center ">
                            <li class="nav-item nav-link">
                                <a class="btn btn-primary btn-sm" target="_blank"
                                    href="{{ route('get_started') }}">Create a Free
                                    Account</a>
                            </li>
                            <li class="nav-item nav-link">
                                <a class="btn btn-outline-primary btn-sm"
                                    href="{{ route('vendor.login.form') }}">Login</a>
                            </li>

                            {{-- <li class="nav-item ms-2">
                                <a class="btn btn-primary btn-sm" target="_blank"
                                    href="https://api.whatsapp.com/send?phone=2348188631121&text=I%20want%20to%20setup%20eduportals%20E-SIMS%20for%20my%20school">GET
                                    STARTED</a>
                            </li> --}}


                        </ul>



                    </div>
                </div>
            </nav>

        </header>

        @yield('content')
        <section class="position-relative overflow-hidden hero-13 pt-7 pt-lg-5 pb-6">
            <div class="container">
                <div class="row align-items-center text-center text-sm-start">
                    <div class="col-lg-6">
                        <div class="mb-lg-0">
                            <h1 class="hero-title">A modern school infomation management system for your <br>
                                <span class="highlight highlight-success d-inline-block" data-toggle="typed"
                                    data-strings='["nursery school^500","primary school^500", "secondary school^500", "creche school^500"]'></span>
                            </h1>

                            <p class="fs-18 text-muted pt-3">
                                Make your school stand out with an advances school infomation management system designed
                                and developed by professionals.
                            </p>

                            <div class="pt-3 pt-sm-5 mb-4 mb-lg-0">
                                <a href="https://api.whatsapp.com/send?phone=2348188631121&text=I%20want%20to%see%a%demo%20of%20eduportals%20E-SIMS"
                                    class="btn btn-primary" target="_blank">
                                    Request Demo
                                    <span class="ms-2 icon icon-xxs" data-feather="arrow-down"></span>
                                </a>
                                {{-- <a href="docs/index.html"
                                    class="btn btn-link text-primary fw-semibold ms-2">Documentation</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1 hero-right">
                        <div class="img-container" data-aos="fade-left" data-aos-duration="1000">
                            <div class="slider">
                                <div class="swiper-container" data-toggle="swiper"
                                    data-swiper='{"slidesPerView":1, "loop":true, "spaceBetween": 0, "autoplay": {"delay": 5000}, "breakpoints": {"576": {"slidesPerView": 1.2 }, "768": { "slidesPerView": 1 } }, "roundLengths":true}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="swiper-slide-content">
                                                <div
                                                    class="video-overlay d-flex align-items-center justify-content-center">
                                                    <a href="#" class="btn-play success"></a>
                                                </div>
                                                <img src="{{ asset('assets/images/hero/hero1.png') }}" alt=""
                                                    class="img-fluid rounded-lg" />
                                            </div>
                                        </div>
                                        <!-- swiper-slide End -->

                                        <div class="swiper-slide">
                                            <div class="swiper-slide-content">
                                                <div
                                                    class="video-overlay d-flex align-items-center justify-content-center">
                                                    <a href="#" class="btn-play success"></a>
                                                </div>
                                                <img src="{{ asset('assets/images/hero/hero2.png') }}" alt=""
                                                    class="img-fluid rounded-lg" />
                                            </div>
                                        </div>
                                        <!-- swiper-slide End -->

                                        <div class="swiper-slide">
                                            <div class="swiper-slide-content">
                                                <div
                                                    class="video-overlay d-flex align-items-center justify-content-center">
                                                    <a href="#" class="btn-play success"></a>
                                                </div>
                                                <img src="{{ asset('assets/images/hero/hero3.png') }}" alt=""
                                                    class="img-fluid rounded-lg" />
                                            </div>
                                        </div>
                                        <!-- swiper-slide End -->
                                    </div>
                                    <!-- swiper-wrapper End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- footer start -->
    <section class="pt-5 pb-4 bg-gradient3 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a class="navbar-brand me-lg-4 mb-4 me-auto d-flex align-items-center pt-0" href="#">
                        <img src="{{ asset('images/logo.svg') }}" height="30" alt="" />
                    </a>
                    <p class="text-muted w-75">
                        Make your school stand out with E-SIMS
                    </p>
                </div>
                <div class="col-md-auto col-sm-6">
                    <div class="ps-md-5">
                        <h6 class="mb-4 mt-5 mt-sm-2 fs-14 fw-semibold text-uppercase">
                            Platform</h6>
                        <ul class="list-unstyled">
                            <li class="my-3"><a href="#" class="text-muted">Demo</a></li>
                            <li class="my-3"><a href="#" class="text-muted">Documentation</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-auto col-sm-6">
                    <div class="ps-md-5">
                        <h6 class="mb-4 mt-5 mt-sm-2 fs-14 fw-semibold text-uppercase">
                            Knowledge Base</h6>
                        <ul class="list-unstyled">
                            <li class="my-3"><a href="#" class="text-muted">Blog</a></li>
                            <li class="my-3"><a href="#" class="text-muted">Help Center</a></li>
                            <li class="my-3"><a href="#" class="text-muted">API</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-auto col-sm-6">
                    <div class="ps-md-5">
                        <h6 class="mb-4 mt-5 mt-sm-2 fs-14 fw-semibold text-uppercase">
                            Company</h6>
                        <ul class="list-unstyled">
                            <li class="my-3"><a href="#" class="text-muted">About Us</a></li>
                            <li class="my-3"><a
                                    href="https://api.whatsapp.com/send?phone=2348188631121&text=I%20want%20to%20know%20more%20about%20eduportals%20E-SIMS"
                                    class="text-muted">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-auto col-6">
                    <div class="ps-md-5">
                        <h6 class="mb-4 mt-5 mt-sm-2 fs-14 fw-semibold text-uppercase">
                            Legal
                        </h6>
                        <ul class="list-unstyled">
                            <li class="my-3"><a href="#" class="text-muted">Usage Policy</a></li>
                            <li class="my-3"><a href="#" class="text-muted">Privacy Policy</a></li>
                            <li class="my-3"><a href="#" class="text-muted">Terms of Service</a></li>
                            <li class="my-3"><a href="#" class="text-muted">Trust</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row text-md-start text-center">
                <div class="col-md-6">
                    <p class="pb-0 mb-0 text-muted">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Eduportals. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="align-items-end mt-md-0 mt-4">
                        <ul class="list-unstyled mb-0">
                            <li class="d-inline-block me-4">
                                <a href="#"><i data-feather="facebook" class="icon icon-xs"></i></a>
                            </li>
                            <li class="d-inline-block me-4">
                                <a href="#"><i data-feather="twitter" class="icon icon-xs"></i></a>
                            </li>
                            <li class="d-inline-block">
                                <a href="#"><i data-feather="linkedin" class="icon icon-xs"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- footer end -->

    <!-- back to top -->
    <a class="btn btn-soft-primary shadow-none btn-icon btn-back-to-top" href='#'><i class="icon-xxs"
            data-feather="arrow-up"></i></a>

    <!-- javascript -->
    <!-- vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>


    <!-- theme js -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>


</body>

</html>
