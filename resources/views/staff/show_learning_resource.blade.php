@extends('layouts.dashboard')


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
                {{ $learningResource->title }}
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ $learningResource->title }}</h2>
                    <h4>{{ $learningResource->description }}</h4>
                    <div>
                        {!! $learningResource->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
