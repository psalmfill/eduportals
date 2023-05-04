@extends('layouts.admin')


@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

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
                Pins
            </a>
        </li>
    </ol>
@endsection

@section('content')
    @php
        $pins = App\Models\Pin::all();
    @endphp

    <div class="card bg-secondary mb-2">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Generate Pins</h3>
                    <form action="{{ route('pins.generate') }}" class="form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="school" id="school" class="form-control form-control-sm">
                                        <option value="">Select School</option>
                                        @foreach ($schools as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" name="quantity" min="1" placeholder="Quantity"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="number" name="days" min="1" placeholder="Number of days"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-arrows-ccw"></i>
                                    Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Pins</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $pins->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Used Pins</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $pins->whereNotNull('expiry_date')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Unused Pins</h4>
                    <div class="media">
                        <i class="entypo-users icon-lg text-primary d-flex align-self-start mr-3"></i>
                        <div class="media-body">
                            <h2 class="">{{ $pins->whereNull('expiry_date')->count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
