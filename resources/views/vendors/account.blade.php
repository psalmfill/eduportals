@extends('layouts.vendor')


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
                Account
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-7 mb-4" style="border-right:1px solid #eeeeee">

                <h3>Profile</h3>
                <div class="card">
                    <div class="card-body">
                        {{-- <form action="" method="post">
                            @csrf
                            <img width="200" height="200" class="img-circle"
                                src="{{ user()->image ? asset(user()->avatar) : 'http://placehold.it/200x150' }}"
                                alt="image" class="img-responsiv img-fluid">
                            <input class="custom-control-input" name="image" id="image" data-validate="required"
                                    type="file" />
                            <br>
                            <button class="btn btn-primary">update</button>
                            @error('image')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </form>
                        <hr> --}}
                        <form action="{{ route('vendor.account.setting.update') }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="first_name">First Name</label>
                                        <input class="form-control" name="first_name" id="first_name"
                                            data-validate="required" placeholder="Your first name"
                                            value="{{ $user->first_name }}" />
                                        @error('first_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="last_name">Last Name</label>
                                        <input class="form-control" name="last_name" id="last_name" data-validate="required"
                                            value="{{ $user->last_name }}" placeholder="Your last name" />
                                        @error('last_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="other_name">Other Name</label>
                                        <input class="form-control" name="other_name" id="other_name"
                                            value="{{ $user->other_name }}" placeholder="Your other name" />
                                        @error('other_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email Address</label>
                                        <input class="form-control" name="email" id="email"
                                            placeholder="Your email address" disabled data-mask="email"
                                            value="{{ $user->email }}" />
                                        @error('email')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="phone_number">Phone number</label>
                                        <input class="form-control" name="phone_number" id="phone_number"
                                            value="{{ $user->phone_number }}" placeholder="Your phone number" />
                                        @error('phone_number')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-5 ">
                <h3>Update Password</h3>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('vendor.change-password') }}" method="post">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="old_password">Old Password</label>
                                <input type="password" class="form-control" name="old_password">
                                @error('old_password')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" name="password">
                                @error('password')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                                @error('password_confirmation')
                                    <div>
                                        <small class="text-danger">{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary">Update Password</button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
