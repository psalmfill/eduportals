<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
    <title></title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-icons/entypo/css/entypo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/neon.css') }}">

    @yield('page_styles')
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
 <![endif]-->


</head>

<body>

    <div class="wrap">
        <!-- Logo and Navigation -->
        <div class="site-header-container container">

            <div class="row">

                <div class="col-md-12">

                    <header class="site-header">

                        <section class="site-logo">

                            <a href="{{ url('') }}">
                                {{-- {{dd(getSchool())}} --}}
                                {{-- <img src="{{asset('assets/images/logo-light@2x.png')}}" width="120" /> --}}
                                {{-- <img src="{{ asset(\Storage::url(getSchool()->logo)) }}" width="50" /> --}}
                                {{-- {{getSchool()!=null?getSchool()->name:''}} --}}
                            </a>

                        </section>

                        <nav class="site-nav">

                            <ul class="main-menu hidden-xs" id="main-menu">
                                <li class="active">
                                    <a href="{{ url('') }}">
                                        <span>Home</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="about.html">
                                        <span>Pages</span>
                                    </a>

                                    <ul>
                                        <li>
                                            <a href="about.html">
                                                <span>About Us</span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="#">
                                                <span>Active Menu Item</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="gallery.html">
                                                <span>Gallery</span>
                                            </a>

                                            <ul>
                                                <li>
                                                    <a href="index.html?2">
                                                        <span>Sub 1</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="about.html">
                                                        <span>Sub 2</span>
                                                    </a>

                                                    <ul>
                                                        <li>
                                                            <a href="contact.html">
                                                                <span>Sub of sub 1</span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="portfolio.html">
                                                                <span>Sub of sub 2</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <span>Sub 3</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="blog-post.html">
                                                <span>Blog Post</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="portfolio-single.html">
                                                <span>Portfolio Item</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="portfolio.html">
                                        <span>Portfolio</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="blog.html">
                                        <span>Blog</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="contact.html">
                                        <span>Contact</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="contact.html">
                                        <span>Login</span>
                                    </a>

                                    <ul>
                                        {{-- <li>
                                            <a href="{{ route('student.login.form', getSchool()->code) }}">
                                                <span>Student</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('staff.login.form', getSchool()->code) }}">
                                                <span>Staff</span>
                                            </a>
                                        </li> --}}
                                    </ul>
                                </li>
                                <li class="search">
                                    <a href="#">
                                        <i class="entypo-search"></i>
                                    </a>

                                    <form method="get" class="search-form" action=""
                                        enctype="application/x-www-form-urlencoded">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Type to search..." />
                                    </form>
                                </li>
                            </ul>


                            <div class="visible-xs">

                                <a href="#" class="menu-trigger">
                                    <i class="entypo-menu"></i>
                                </a>

                            </div>
                        </nav>

                    </header>

                </div>

            </div>

        </div>
        @yield('content')
        <!-- Site Footer -->
        <footer class="site-footer">

            <div class="container">

                <div class="row">

                    <div class="col-sm-6">
                        Copyright &copy; Neon - All Rights Reserved.
                    </div>

                    <div class="col-sm-6">

                        <ul class="social-networks text-right">
                            <li>
                                <a href="#">
                                    <i class="entypo-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="entypo-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="entypo-facebook"></i>
                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </footer>
    </div>


    <!-- Bottom scripts (common) -->
    <script src="{{ asset('assets/js/gsap/TweenMax.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/joinable.js') }}"></script>
    <script src="{{ asset('assets/js/resizeable.js') }}"></script>
    <script src="{{ asset('assets/js/neon-slider.js') }}"></script>
    <script src="{{ asset('assets/js/neon-api.js') }}"></script>


    <!-- JavaScripts initializations and stuff -->
    <script src="{{ asset('assets/js/neon-custom-fe.js') }}"></script>

</body>

</html>
