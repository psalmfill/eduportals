@extends('layouts.student')


@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="#">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                {{ $assignment->title }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <h5 class="alert alert-info">Submission Date: {{ $assignment->submission_date->format('Y-m-d') }}
                ({{ $assignment->submission_date->diffForHumans() }})
            </h5>
            <h2>{{ $assignment->title }}</h2>
            <div class="card">
                <div class="card-body">
                    <h3>Assignment</h3>
                    <div>
                        {!! $assignment->content !!}
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <h3>Study Resources</h3>
                    <div>
                        {!! $assignment->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
