@extends('layouts.vendor')


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
    <div class="row">
        <div class="col-md-6 offset-md-3 mt-5">
            <div class="card bg-secondary mb-2 mt-5">
                <div class="card-body">
                    <h3 class="text-white">Purchase Pins</h3>
                    <form action="{{ route('vendor.pins.buy') }}" class="form" method="POST">
                        @csrf
                        <div class="form-group">
                            <select name="school" id="school" class="form-control form-control-sm">
                                <option value="">Select School</option>
                                @foreach ($schools as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('school')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="number" name="quantity" min="1" placeholder="Quantity"
                                onkeyup="$('#total').val(this.value * 350)" class="form-control form-control-sm">
                            @error('quantity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="number" id="total" placeholder="Amount" class="form-control form-control-sm"
                                readonly>
                        </div>
                        <button class="btn btn-primary btn-block btn-sm"><i class="entypo-arrows-ccw"></i>
                            Purchase</button>
                    </form>
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
