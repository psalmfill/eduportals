@extends('layouts.dashboard')

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="#">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Staffs</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $staffCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Students</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-info d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $studentCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Subjects</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-success d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $subjectCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Classes</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $classCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sections</h4>
                    <div class="media">
                        <i class="entypo-gauge icon-lg text-danger d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $sectionCount }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
