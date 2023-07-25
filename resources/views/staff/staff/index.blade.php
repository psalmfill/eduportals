@extends('layouts.dashboard')


@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{ route('staff.dashboard') }}">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Staff
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Staff</h3>
            <div class="container-flui d-flex justify-content-end mb-3">

                <a href="{{ route('staff.create') }}" class="btn btn-primary pull-right">New Staff</a>
            </div>
            <div class="container table">
                <div class="row table-head border d-none d-md-flex text-center">


                    <div class="col-md-1 my-md-auto py-2">
                        Passport
                    </div>
                    <div class="col-md-3 my-md-auto py-2">
                        Name
                    </div>
                    <div class="col-md-2 my-md-auto py-2">
                        Phone Number
                    </div>
                    <div class="col-md-2 my-md-auto py-2">
                        Email Address
                    </div>
                    <div class="col-md-2 my-md-auto py-2">
                        Address
                    </div>
                    <div class="col-md-2 my-md-auto py-2">
                        Action
                    </div>
                </div>
                @foreach ($staff as $item)
                    <div class="row striped border py-3 text-center align-middle">
                        <div class="col-md-1 my-md-auto my-1">
                            <img width="100" height="100" src="{{ $item->avatar }}" alt="image" class="rounded">
                        </div>
                        <div class="col-md-3 my-md-auto my-1 ">
                            <div class="text-uppercase">{{ $item->name }}</div>
                        </div>
                        <div class="col-md-2 my-md-auto my-1 ">
                            {{ $item->phone_number }}
                        </div>
                        <div class="col-md-2 my-md-auto my-1">
                            {{ $item->email }}
                        </div>
                        <div class="col-md-2 my-md-auto my-2">
                            {{ $item->address }}
                        </div>
                        <div class="col-md-2 my-md-auto my-1">
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('staff.show', $item->id) }}" class="btn btn-info btn-sm mr-1">
                                    View</a>
                                @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                    <a href="{{ route('staff.edit', $item->id) }}" class="btn btn-secondary btn-sm">
                                        Edit</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="mt-4 d-flex justify-content-center">

                {!! $staff->links() !!}
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
