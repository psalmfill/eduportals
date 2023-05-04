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
                Classes
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
                        @if ($staff instanceof App\Models\Staff)
                            <form action="" method="post">
                                @csrf
                                <img width="200" height="200" class="img-circle"
                                    src="{{user()->image?asset(user()->avatar):'http://placehold.it/200x150'}}" alt="image"
                                    class="img-responsiv img-fluid">
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
                            <hr>
                            <form action="{{ route('account.setting.update') }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="first_name">First Name</label>
                                            <input class="form-control" name="first_name" id="first_name"
                                                data-validate="required" placeholder="Your first name"
                                                value="{{ $staff->first_name }}" />
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
                                            <input class="form-control" name="last_name" id="last_name"
                                                data-validate="required" value="{{ $staff->last_name }}"
                                                placeholder="Your last name" />
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
                                                value="{{ $staff->other_name }}" placeholder="Your other name" />
                                            @error('other_name')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="date_of_birth">Date of Birth</label>
                                            <input class="form-control" name="date_of_birth" id="date_of_birth"
                                                value="{{ $staff->date_of_birth }}" data-validate="required"
                                                placeholder="Your full name" data-mask="date" />
                                            @error('date_of_birth')
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
                                                value="{{ $staff->email }}" />
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
                                                value="{{ $staff->phone_number }}" placeholder="Your phone number" />
                                            @error('phone_number')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="address_1">Address 1</label>
                                            <input class="form-control" name="address_1" id="address_1"
                                                data-validate="required" value="{{ $staff->address_1 }}"
                                                placeholder="Enter your street address" />
                                            @error('address_1')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="address_2">Address 2</label>
                                            <input class="form-control" name="address_2" id="address_line_2"
                                                value="{{ $staff->address_2 }}"
                                                placeholder="(Optional) Secondary Address" />
                                            @error('address_2')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="country">Country</label>
                                            <input class="form-control" name="country" id="country" data-validate="required"
                                                value="{{ $staff->country }}" placeholder="Country" />
                                            @error('country')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="state">State</label>

                                            <input class="form-control" name="state" id="state" data-validate="required"
                                                value="{{ $staff->state }}" placeholder="State" />
                                            @error('state')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="city">City</label>
                                            <input class="form-control" name="city" id="city" data-validate="required"
                                                value="{{ $staff->city }}" placeholder="City" />
                                            @error('city')
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
                        @else
                            {{-- <form action="">
                                <img width="200" height="200" class="img-circle"
                                
                                    src="{{ asset(\Storage::url($staff->image)) }}" alt="image"
                                    class="img-responsiv img-fluid">
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

                            <form action="{{ route('account.setting.update') }}" method="post">
                                @method('PUT')
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="first_name">First Name</label>
                                            <input class="form-control" name="first_name" id="first_name"
                                                data-validate="required" placeholder="Your first name"
                                                value="{{ $staff->first_name }}" />
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
                                            <input class="form-control" name="last_name" id="last_name"
                                                data-validate="required" value="{{ $staff->last_name }}"
                                                placeholder="Your last name" />
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
                                                value="{{ $staff->other_name }}" placeholder="Your other name" />
                                            @error('other_name')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="date_of_birth">Date of Birth</label>
                                        <input class="form-control" name="date_of_birth" id="date_of_birth"
                                            value="{{ $staff->date_of_birth }}" data-validate="required"
                                            placeholder="Your full name" data-mask="date" />
                                        @error('date_of_birth')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="email">Email Address</label>
                                            <input class="form-control" name="email" id="email"
                                                placeholder="Your email address" disabled data-mask="email"
                                                value="{{ $staff->email }}" />
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
                                                value="{{ $staff->phone_number }}" placeholder="Your phone number" />
                                            @error('phone_number')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address_1">Address 1</label>
                                        <input class="form-control" name="address_1" id="address_1"
                                            data-validate="required" value="{{ $staff->address_1 }}"
                                            placeholder="Enter your street address" />
                                        @error('address_1')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address_2">Address 2</label>
                                        <input class="form-control" name="address_2" id="address_line_2"
                                            value="{{ $staff->address_2 }}"
                                            placeholder="(Optional) Secondary Address" />
                                        @error('address_2')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="country">Country</label>
                                        <input class="form-control" name="country" id="country" data-validate="required"
                                            value="{{ $staff->country }}" placeholder="Country" />
                                        @error('country')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="state">State</label>

                                        <input class="form-control" name="state" id="state" data-validate="required"
                                            value="{{ $staff->state }}" placeholder="State" />
                                        @error('state')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="city">City</label>
                                        <input class="form-control" name="city" id="city" data-validate="required"
                                            value="{{ $staff->city }}" placeholder="City" />
                                        @error('city')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}

                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-5 bg-secondary">
                <h3>Update Password</h3>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('staff.change-password') }}" method="post">
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
