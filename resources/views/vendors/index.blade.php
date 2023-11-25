@extends('layouts.vendor')
@section('content')
    <div class="row">
        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Schools</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $schools }}</h2>
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
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $students }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Staff</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $staff }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">pins</h4>
                    <div class="media">
                        <i class="entypo-key icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $pins }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
