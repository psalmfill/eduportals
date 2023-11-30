@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3>Fill in the following information to get started</h3>
                <form action="{{ route('vendors.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Vendor Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Code <span class="text-danger">*</span> ( <small>Use as your domain
                                    name</small> )</label>
                            <input type="text" name="code" value="{{ old('code') }}" class="form-control" required>
                            @error('code')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Country</label>
                            <input type="text" name="country" value="{{ old('country') ?? 'Nigeria' }}"
                                class="form-control" required>
                            @error('country')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                            @error('state')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Category <span class="text-danger">*</span></label>
                            <select name="category" id="" class="form-control">
                                <option value="">Select Category</option>
                                @foreach ($vendorCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <h4 class="mt-4">Your Admin Infomation</h4>
                    <hr>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">First name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_first_name" value="{{ old('admin_first_name') }}"
                                class="form-control">
                            @error('admin_first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Last name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_last_name" value="{{ old('admin_last_name') }}"
                                class="form-control">
                            @error('admin_last_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Other name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_other_name" value="{{ old('admin_other_name') }}"
                                class="form-control">
                            @error('admin_other_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Address <span class="text-danger">*</span></label>
                            <input type="text" name="admin_address" value="{{ old('admin_address') }}"
                                class="form-control">
                            @error('admin_address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Email <span class="text-danger">*</span></label>
                            <input type="text" name="admin_email" value="{{ old('admin_email') }}"
                                class="form-control">
                            @error('admin_email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="admin_phone_number" value="{{ old('admin_phone_number') }}"
                                class="form-control">
                            @error('admin_phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mt-2 ">
                            <button class="btn btn-primary btn-block" type="submit">Create a Free
                                Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
