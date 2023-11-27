@extends('layouts.vendor')


@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{ route('vendor.dashboard') }}">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Manage {{ $staff->name }} Schools
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Manage {{ $staff->name }} Schools</h3>
            <div class="container-fluid p-3">
                <div class="row">

                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">Manage {{ $staff->name }} Schools</h4>
                            <hr>
                            <form action="{{ route('vendor.staff.updateSchools', $staff->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label class="control-label">Schools</label>

                                    <div class="">

                                        <div class="row">
                                            @foreach ($schools as $item)
                                                <div class="col-md-12">
                                                    <div class="checkbox checkbox-replace">
                                                        <input type="checkbox" name="schools[]" class="mt-1"
                                                            id="schools-{{ $item->id }}" value="{{ $item->id }}"
                                                            {{ $staff->schools->contains($item) ? 'checked' : '' }}>
                                                        <label>{{ $item->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
    @endsection
