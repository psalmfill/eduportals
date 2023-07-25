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
            <a href="{{ route('schools.index') }}">
                <i class="fa fa-building"></i>
                Schools
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="well">
                        <h3 class="margin">{{ isset($school) ? 'Edit' : 'Onboard' }} School</h3>
                        <p class="text-danger">All fields are required</p>
                        <hr>
                        @isset($school)
                            <form action="{{ route('schools.update', $school->id) }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name </label>
                                            <input type="text" value="{{ $school->name }}" name="name"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Code</label>
                                            <input type="text" value="{{ $school->code }}" name="code"
                                                class="form-control">
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" value="{{ $school->email }}" name="email"
                                                class="form-control">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" value="{{ $school->address }}" name="address"
                                                class="form-control">
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <input type="text" value="{{ $school->country }}" name="country"
                                                class="form-control">
                                            @error('country')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <input type="text" value="{{ $school->state }}" name="state"
                                                class="form-control">
                                            @error('state')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" value="{{ $school->city }}" name="city"
                                                class="form-control">
                                            @error('city')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Category</label>
                                            <select name="category" id="" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ $cat->id == $school->school_category_id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Vendor</label>
                                            <select name="vendor" id="" class="form-control">
                                                <option value="">Select Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}"
                                                        {{ $vendor->id == $school->vendor_id ? 'selected' : '' }}>
                                                        {{ $vendor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vendor')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="active" id="" class="form-control">
                                                <option value="1" {{ $school->active ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ !$school->active ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                            @error('active')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <h4>Admin Infomation</h4>
                                        <hr>

                                        <input type="hidden" name="user_id" value="{{ $school->user->id }}">
                                        <div class="form-group">
                                            <label for="">First name</label>
                                            <input type="text" value="{{ $school->user->first_name }}"
                                                name="admin_first_name" class="form-control">
                                            @error('admin_first_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Last name</label>
                                            <input type="text" value="{{ $school->user->last_name }}"
                                                name="admin_last_name" class="form-control">
                                            @error('admin_last_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Other name</label>
                                            <input type="text" name="admin_other_name"
                                                value="{{ $school->user->other_name }}" class="form-control">
                                            @error('admin_other_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" value="{{ $school->user->address }}" name="admin_address"
                                                class="form-control">
                                            @error('admin_address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" name="admin_email" value="{{ $school->user->email }}"
                                                class="form-control">
                                            @error('admin_email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone Number</label>
                                            <input type="text" name="admin_phone_number"
                                                value="{{ $school->user->phone_number }}" class="form-control">
                                            @error('admin_phone_number')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit">Update</button>
                                </div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-md-6"></div>
                            </div>
                        @else
                            <form action="{{ route('schools.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">

                                        <h4>School Infomation</h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" value="{{ old('name') }}" name="name"
                                                class="form-control">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Code</label>
                                            <input type="text" value="{{ old('code') }}" name="code"
                                                class="form-control">
                                            @error('code')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" value="{{ old('email') }}" name="email"
                                                class="form-control">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" value="{{ old('address') }}" name="address"
                                                class="form-control">
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <input type="text" value="{{ old('country') }}" name="country"
                                                class="form-control">
                                            @error('country')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <input type="text" name="state" value="{{ old('state') }}"
                                                class="form-control">
                                            @error('state')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" value="{{ old('city') }}" name="city"
                                                class="form-control">
                                            @error('city')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Category</label>
                                            <select name="category" id="" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Vendor</label>
                                            <select name="vendor" id="" class="form-control">
                                                <option value="">Select Vendor</option>
                                                @foreach ($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}"
                                                        {{ old('vendor') == $vendor->id ? 'selected' : '' }}>
                                                        {{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('vendor')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Admin Infomation</h4>
                                        <hr>

                                        <div class="form-group">
                                            <label for="">First name</label>
                                            <input type="text" value="{{ old('admin_first_name') }}"
                                                name="admin_first_name" class="form-control">
                                            @error('admin_first_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Last name</label>
                                            <input type="text" value="{{ old('admin_last_name') }}"
                                                name="admin_last_name" class="form-control">
                                            @error('admin_last_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Other name</label>
                                            <input type="text" value="{{ old('admin_other_name') }}"
                                                name="admin_other_name" class="form-control">
                                            @error('admin_other_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" value="{{ old('admin_address') }}" name="admin_address"
                                                class="form-control">
                                            @error('admin_address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" value="{{ old('admin_email') }}" name="admin_email"
                                                class="form-control">
                                            @error('admin_email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Phone Number</label>
                                            <input type="text" value="{{ old('admin_phone_number') }}"
                                                name="admin_phone_number" class="form-control">
                                            @error('admin_phone_number')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-primary btn-sm" type="submit">Create</button>
                                </div>
                            </form>
                        @endisset

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
