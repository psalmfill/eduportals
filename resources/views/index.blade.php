@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">

@section('content')

    <!-- features start -->
    <section class="position-relative overflow-hidden pt-lg-6 py-4 pb-lg-7">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col text-center">
                    <span class="badge rounded-pill badge-soft-primary px-2 py-1">Features</span>
                    <h1 class="display-5 fw-medium">Better Management. Better Performance</h1>
                    <p class="text-muted mx-auto">
                        Start working with <span class="text-primary fw-bold">E-SIMS</span> to manage your school
                        better
                    </p>
                </div>
            </div>

            <div class="row pt-5 align-items-center features-3">
                <div class="col-lg-6">
                    <div class="img-content position-relative">
                        <div class="img-up mb-lg-0 mb-6">
                            <img src="{{ asset('assets/images/hero/hero3.png') }}" alt="app img"
                                class="img-fluid d-block rounded" data-aos="fade-right" data-aos-duration="200" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="accordion" id="features-list" data-aos="fade-up" data-aos-duration="300">
                        <div class="d-flex border-bottom pb-4">
                            <span
                                class="bg-soft-primary avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-primary me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Communication / Group</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Communication-/-Group" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                        <path
                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            id="Combined-Shape" fill="#335EEA"></path>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature1ex" role="button" aria-expanded="false"
                                    aria-controls="feature1ex">Full Customization
                                </a>

                                <div class="collapse show" id="feature1ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        Customize E-SIMS tailored to your school curriculum/standard
                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-4">
                            <span
                                class="bg-soft-success avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-success me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Communication / Add-user</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Communication-/-Add-user" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                        <path
                                            d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            id="Mask-Copy" fill="#335EEA"></path>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature2ex" role="button" aria-expanded="false"
                                    aria-controls="feature2ex">Customizable results format
                                </a>

                                <div class="collapse" id="feature2ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        E-SIMS offers customizations for results. Support for Standard results and
                                        Comment results
                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex pt-4">
                            <span
                                class="bg-soft-orange avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-orange me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Shopping / Chart-bar#3</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Shopping-/-Chart-bar#3" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <rect id="Rectangle-62-Copy" fill="#335EEA" opacity="0.3" x="7" y="4"
                                            width="3" height="13" rx="1.5"></rect>
                                        <rect id="Rectangle-62-Copy-2" fill="#335EEA" opacity="0.3" x="12" y="9"
                                            width="3" height="8" rx="1.5"></rect>
                                        <path
                                            d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                            id="Path-95" fill="#335EEA"></path>
                                        <rect id="Rectangle-62-Copy-4" fill="#335EEA" opacity="0.3" x="17" y="11"
                                            width="3" height="6" rx="1.5"></rect>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature3ex" role="button" aria-expanded="false"
                                    aria-controls="feature3ex">People Data &amp;
                                    Analytics
                                </a>

                                <div class="collapse" id="feature3ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        Finding committed employees is one of public and private organizations’ top
                                        priorities.
                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative overflow-hidden py-7 features-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="mb-5 mb-lg-0" data-aos="fade-up" data-aos-duration="200">
                        <span
                            class="bg-soft-primary avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-primary me-3 mb-4">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                <title>Stockholm-icons / Shopping / MC</title>
                                <desc>Created with Sketch.</desc>
                                <g id="Stockholm-icons-/-Shopping-/-MC" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                    <path
                                        d="M10.8226874,8.36941377 L12.7324324,9.82298668 C13.4112512,8.93113547 14.4592942,8.4 15.6,8.4 C17.5882251,8.4 19.2,10.0117749 19.2,12 C19.2,13.9882251 17.5882251,15.6 15.6,15.6 C14.5814697,15.6 13.6363389,15.1780547 12.9574041,14.4447676 L11.1963369,16.075302 C12.2923051,17.2590082 13.8596186,18 15.6,18 C18.9137085,18 21.6,15.3137085 21.6,12 C21.6,8.6862915 18.9137085,6 15.6,6 C13.6507856,6 11.9186648,6.9294879 10.8226874,8.36941377 Z"
                                        id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                    <path
                                        d="M8.4,18 C5.0862915,18 2.4,15.3137085 2.4,12 C2.4,8.6862915 5.0862915,6 8.4,6 C11.7137085,6 14.4,8.6862915 14.4,12 C14.4,15.3137085 11.7137085,18 8.4,18 Z"
                                        id="Oval-14-Copy" fill="#335EEA"></path>
                                </g>
                            </svg>
                        </span>
                        <h1 class="text-dark">Students Management</h1>
                        <p class="text-muted my-4">Use E-SIMS to access student information, record attendance,
                            manage grades and assessments, communicate with parents, and access curriculum and teaching
                            resources</p>
                        {{-- <a href="#" class="h6 text-primary pt-3">Learn more <i class="ms-1 icon-xxs"
                                data-feather="arrow-right"></i></a> --}}
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-1">
                    <div class="img-content2 position-relative">
                        <div class="img-up">
                            <img src="{{ asset('assets/images/hero/hero2.png') }}" alt="app img"
                                class="img-fluid d-block rounded" data-aos="fade-left" data-aos-duration="300" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- features start -->
    <section class="position-relative overflow-hidden pt-lg-6 py-4 pb-lg-7">
        <div class="container">

            <div class="row pt-5 align-items-center features-3">
                <div class="col-lg-6">
                    <div class="img-content position-relative">
                        <div class="img-up mb-lg-0 mb-6">
                            <img src="{{ asset('assets/images/hero/hero3.png') }}" alt="app img"
                                class="img-fluid d-block rounded" data-aos="fade-right" data-aos-duration="200" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="accordion" id="features-list" data-aos="fade-up" data-aos-duration="300">
                        <div class="d-flex border-bottom pb-4">
                            <span
                                class="bg-soft-primary avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-primary me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Communication / Group</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Communication-/-Group" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                        <path
                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            id="Combined-Shape" fill="#335EEA"></path>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature1ex" role="button" aria-expanded="false"
                                    aria-controls="feature1ex">Improve Staff Experience
                                </a>

                                <div class="collapse show" id="feature1ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        By digitizing and centralizing data, E-SIMS reduces manual paperwork and
                                        eliminates the need for duplicate data entry. This improves efficiency and
                                        productivity for both administrative staff and teachers, as they can access and
                                        update information easily, track progress, and generate reports quickly.

                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-4">
                            <span
                                class="bg-soft-success avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-success me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Communication / Add-user</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Communication-/-Add-user" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                        <path
                                            d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                            id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                        <path
                                            d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                            id="Mask-Copy" fill="#335EEA"></path>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature2ex" role="button" aria-expanded="false"
                                    aria-controls="feature2ex">Improved Results Management
                                </a>

                                <div class="collapse" id="feature2ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        E-SIMS's reporting and analytics capabilities enable administrators and
                                        teachers to analyze data and generate comprehensive reports on various aspects,
                                        such as attendance, academic performance, fee collection, and library
                                        utilization.
                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex pt-4">
                            <span
                                class="bg-soft-orange avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-orange me-3 flex-shrink-0">
                                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                    <title>Stockholm-icons / Shopping / Chart-bar#3</title>
                                    <desc>Created with Sketch.</desc>
                                    <g id="Stockholm-icons-/-Shopping-/-Chart-bar#3" stroke="none" stroke-width="1"
                                        fill="none" fill-rule="evenodd">
                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                        <rect id="Rectangle-62-Copy" fill="#335EEA" opacity="0.3" x="7" y="4"
                                            width="3" height="13" rx="1.5"></rect>
                                        <rect id="Rectangle-62-Copy-2" fill="#335EEA" opacity="0.3" x="12" y="9"
                                            width="3" height="8" rx="1.5"></rect>
                                        <path
                                            d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                            id="Path-95" fill="#335EEA"></path>
                                        <rect id="Rectangle-62-Copy-4" fill="#335EEA" opacity="0.3" x="17" y="11"
                                            width="3" height="6" rx="1.5"></rect>
                                    </g>
                                </svg>
                            </span>
                            <div class="flex-grow-1">
                                <a href="#" class="text-dark h4" data-bs-toggle="collapse"
                                    data-bs-target="#feature3ex" role="button" aria-expanded="false"
                                    aria-controls="feature3ex">School and Students Data Analytics
                                </a>

                                <div class="collapse" id="feature3ex" data-bs-parent="#features-list">
                                    <p class="text-muted mt-1 mb-4">
                                        E-SIMS data-driven approach facilitates evidence-based decision-making,
                                        strategic
                                        planning, and identifying areas for improvement.

                                    </p>
                                    {{-- <a href="#" class="h6 text-primary">Learn more
                                        <i class="ms-1 icon-xxs" data-feather="arrow-right"></i></a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative overflow-hidden py-7 features-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="mb-5 mb-lg-0" data-aos="fade-up" data-aos-duration="200">
                        <span
                            class="bg-soft-primary avatar avatar-sm rounded-lg icon icon-with-bg icon-xs text-primary me-3 mb-4">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <!-- Generator: Sketch 52.2 (67145) - http://www.bohemiancoding.com/sketch -->
                                <title>Stockholm-icons / Shopping / MC</title>
                                <desc>Created with Sketch.</desc>
                                <g id="Stockholm-icons-/-Shopping-/-MC" stroke="none" stroke-width="1" fill="none"
                                    fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                    <path
                                        d="M10.8226874,8.36941377 L12.7324324,9.82298668 C13.4112512,8.93113547 14.4592942,8.4 15.6,8.4 C17.5882251,8.4 19.2,10.0117749 19.2,12 C19.2,13.9882251 17.5882251,15.6 15.6,15.6 C14.5814697,15.6 13.6363389,15.1780547 12.9574041,14.4447676 L11.1963369,16.075302 C12.2923051,17.2590082 13.8596186,18 15.6,18 C18.9137085,18 21.6,15.3137085 21.6,12 C21.6,8.6862915 18.9137085,6 15.6,6 C13.6507856,6 11.9186648,6.9294879 10.8226874,8.36941377 Z"
                                        id="Combined-Shape" fill="#335EEA" opacity="0.3"></path>
                                    <path
                                        d="M8.4,18 C5.0862915,18 2.4,15.3137085 2.4,12 C2.4,8.6862915 5.0862915,6 8.4,6 C11.7137085,6 14.4,8.6862915 14.4,12 C14.4,15.3137085 11.7137085,18 8.4,18 Z"
                                        id="Oval-14-Copy" fill="#335EEA"></path>
                                </g>
                            </svg>
                        </span>
                        <h1 class="text-dark">Staff Management</h1>
                        <p class="text-muted my-4">With real-time data updates, E-SIMS provides accurate and up-to-date
                            information on Staff records.</p>
                        {{-- <a href="#" class="h6 text-primary pt-3">Learn more <i class="ms-1 icon-xxs"
                                data-feather="arrow-right"></i></a> --}}
                    </div>
                </div>

                <div class="col-lg-6 offset-lg-1">
                    <div class="img-content2 position-relative">
                        <div class="img-up">
                            <img src="{{ asset('assets/images/hero/hero9.png') }}" alt="app img"
                                class="img-fluid d-block rounded" data-aos="fade-left" data-aos-duration="300" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>




    <section class="position-relative pb-6 pt-lg-6 pt-4 features-3 bg-light">
        <div class="container" data-aos="fade-up" data-aos-duration="200">
            <div class="row justify-content-center">
                <div class="col text-center">
                    <h3 class="fw-medium mb-5">More powerful features</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Student Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Class Scheduling</h6>

                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Promotion Management</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Subject Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Examinations Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Attendance Management</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Hostel Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Account Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Reports and Analytics</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Results Verification</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Pin Management</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Fees Management</h6>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <div class="col-auto">
                    <a href="https://api.whatsapp.com/send?phone=2348188631121&text=I%20want%20to%20know%20more%20about%20eduportals%20E-SIMS"
                        class="btn btn-primary mb-2">
                        Contact us now <i class="icon-xs ms-2" data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative pb-6 pt-lg-6 pt-4 features-3">
        <div class="container" data-aos="fade-up" data-aos-duration="200">
            <div class="row justify-content-center">
                <div class="col text-center">
                    <h3 class="fw-medium mb-5">Benefits of using the E-SIMS</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Streamlined Administrative Processes</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Improved Efficiency and Productivity</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Enhanced Communication and Collaboration</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Accurate and Timely Information</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Personalized Learning and Academic Tracking</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Data Analysis and Insights</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Enhanced Parent Engagement</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Secure Data Management</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Results Verification</h6>
                    <h6 class="fw-medium fs-16 mb-4"><i class="icon-sm icon-dual-success me-2"
                            data-feather="check"></i>Affordable</h6>
                </div>
            </div>
            <div class="row mt-5 justify-content-center">
                <div class="col-auto">
                    <a href="https://api.whatsapp.com/send?phone=2348188631121&text=I%20want%20to%20know%20more%20about%20eduportals%20E-SIMS"
                        class="btn btn-primary mb-2">
                        Contact us now <i class="icon-xs ms-2" data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- features end -->

    @if ($schools->count())
        <!-- clients start -->
        <section class="section pt-8 pb-6 bg-gradient3 position-relative">
            <div class="divider top d-none d-sm-block"></div>
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-duration="200">
                    <div class="col text-center">
                        <span class="badge rounded-pill badge-soft-primary px-2 py-1">Clients</span>
                        <h1 class="display-5 fw-medium">The smart school management you need</h1>
                        <p class="text-muted mx-auto">
                            {{ $schools->count() }}+ schools trust <span class="text-primary fw-bold">E-SIMS</span>
                            to drive
                            perfomance
                        </p>

                        <ul class="list-inline mt-5">
                            @foreach ($schools as $school)
                                @if (!$school->logo)
                                    @continue
                                @endif
                                <li class="list-inline-item mx-4 mx-xl-5 mb-3 ">
                                    <img src="{{ $school->image }}" alt="" height="62" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- client ends -->
    @endif
    {{-- 
    <!-- testimonials start -->
    <section class="section pt-5 pb-7 py-sm-9 position-relative features-4">
        <div class="container">
            <div class="row testimonials-2" data-aos="fade-up" data-aos-duration="200">
                <div class="col-lg-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <span class="badge rounded-pill badge-soft-primary px-2 py-1">Feedback</span>
                            <h1 class="display-5 fw-medium">What people say</h1>
                            <p class="text-muted mx-auto">Few valuables words from our customers</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-auto text-sm-right pt-2 pt-sm-0">
                            <div class="navigations mb-4 mb-lg-0">
                                <button class="btn btn-link text-normal p-0 swiper-custom-prev">
                                    <svg class="bi bi-arrow-left" width="1.75em" height="1.75em" viewBox="0 0 16 16"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M5.854 4.646a.5.5 0 010 .708L3.207 8l2.647 2.646a.5.5 0 01-.708.708l-3-3a.5.5 0 010-.708l3-3a.5.5 0 01.708 0z"
                                            clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd"
                                            d="M2.5 8a.5.5 0 01.5-.5h10.5a.5.5 0 010 1H3a.5.5 0 01-.5-.5z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <button class="btn btn-link text-normal p-0 swiper-custom-next">
                                    <svg class="bi bi-arrow-right" width="1.75em" height="1.75em"
                                        viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10.146 4.646a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708-.708L12.793 8l-2.647-2.646a.5.5 0 010-.708z"
                                            clip-rule="evenodd"></path>
                                        <path fill-rule="evenodd"
                                            d="M2 8a.5.5 0 01.5-.5H13a.5.5 0 010 1H2.5A.5.5 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 offset-lg-1">
                    <div class="slider">
                        <div class="swiper-container" data-toggle="swiper"
                            data-swiper='{"loop":true, "spaceBetween": 24, "autoplay": {"delay": 5000}, "breakpoints": {"576": {"slidesPerView": 1 }, "768": { "slidesPerView": 1 } }, "roundLengths":true, "navigation": {"nextEl": ".swiper-custom-next","prevEl": ".swiper-custom-prev"}}'>

                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="card mb-0 border rounded">
                                        <div class="card-body testimonial-body shadow">
                                            <p class="quotation-mark text-muted mb-0">“</p>
                                            <h4 class="fw-normal mb-3 mt-0">
                                                This app is a truly blessing for all professionals! A day to day project
                                                management was never easy for me. But with prompt, I can manage more
                                                than 100 projects easily.
                                            </h4>
                                            <hr />
                                            <div class="d-flex pt-2">
                                                <img class="me-2 flex-shrink-0 rounded-circle"
                                                    src="{{ asset('assets/images/avatars/img-8.jpg')}}" alt=""
                                                    height="36" />
                                                <div class="flex-grow-1">
                                                    <h6 class="m-0">Cersei Lannister</h6>
                                                    <p class="my-0 text-muted fs-13">Senior Project Manager</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="card mb-0 border rounded">
                                        <div class="card-body testimonial-body shadow">
                                            <p class="quotation-mark text-muted mb-0">“</p>
                                            <h4 class="fw-normal mb-3 mt-0">
                                                It is one of the very convenient to use project manager ever! I have
                                                tried many project management apps for my daily tasks, but this one is
                                                far better than others. Simply loved it!
                                            </h4>
                                            <hr />
                                            <div class="d-flex pt-2 text-align-start">
                                                <img class="me-2 flex-shrink-0 rounded-circle"
                                                    src="{{ asset('assets/images/avatars/img-5.jpg')}}" alt=""
                                                    height="36" />
                                                <div class="flex-grow-1">
                                                    <h6 class="m-0">John Stark</h6>
                                                    <p class="my-0 text-muted fs-13">Engineering Director</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- testimonials end -->

    <!-- faq start -->
    <section class="section py-6 pt-sm-6 position-relative">
        <div class="container" data-aos="fade-up" data-aos-duration="2000">
            <div class="row">
                <div class="col text-center">
                    <span class="badge rounded-pill badge-soft-primary px-2 py-1">FAQs</span>
                    <h1 class="display-5 fw-medium">Frequently Asked Questions</h1>
                    <p class="text-muted mx-auto">
                        Here are some of the basic types of questions for our customers
                    </p>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-md-10 col-lg-8">
                    <div id="faqContent">
                        <div class="accordion custom-accordionwitharrow" id="accordionExample">
                            <div class="card mb-2 border rounded-sm">
                                <a href="#" class="text-dark" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="my-1 fw-medium">Can I use this template for my client?
                                            <i class="icon-xs accordion-arrow" data-feather="chevron-down"></i>
                                        </h5>
                                    </div>
                                </a>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="card-body text-muted pt-1">
                                        Yup, the marketplace license allows you to use this theme in any end products.
                                        For more information on licenses, please refere license terms on marketplace.
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2 border rounded-sm">
                                <a href="#" class="text-dark collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="my-1 fw-medium">Can this theme work with WordPress?
                                            <i class="icon-xs accordion-arrow" data-feather="chevron-down"></i>
                                        </h5>
                                    </div>
                                </a>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="card-body text-muted pt-1">
                                        No. This is a HTML template. It won't directly with WordPress, though you can
                                        convert this into WordPress compatible theme.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2 border rounded-sm">
                                <a href="#" class="text-dark collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                    <div class="card-header" id="headingThree">
                                        <h5 class="my-1 fw-medium">How do I get help with the theme?
                                            <i class="icon-xs accordion-arrow" data-feather="chevron-down"></i>
                                        </h5>
                                    </div>
                                </a>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-bs-parent="#accordionExample">
                                    <div class="card-body text-muted pt-1">
                                        Use our dedicated support email (support@coderthemes.com) to send your issues or
                                        feedback. We are here to help anytime.
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-2 border rounded-sm">
                                <a href="#" class="text-dark collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    <div class="card-header" id="headingFour">
                                        <h5 class="my-1 fw-medium">Will you regularly give updates of Prompt ?
                                            <i class="icon-xs accordion-arrow" data-feather="chevron-down"></i>
                                        </h5>
                                    </div>
                                </a>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="card-body text-muted pt-1">
                                        Yes, We will update the Prompt regularly. All the future updates would be
                                        available without any cost.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-auto">
                    <div class="rounded d-inline-block py-2 px-3 alert bg-light">
                        <div class="align-items-center">
                            <div class="text-dark">
                                Still have unanswered questions? <a href="#">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq end --> --}}
@endsection
