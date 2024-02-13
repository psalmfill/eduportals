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
                Vendors
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Vendors</h3>
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <h4 class="margin">{{ isset($vendor) ? 'Edit' : 'Create New' }} Vendor</h4>
                            <p class="text-danger">All fields are required</p>
                            <hr>
                            @isset($vendor)
                                <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" value="{{ $vendor->name }}" name="name" class="form-control">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" value="{{ $vendor->code }}" name="code" class="form-control">
                                        @error('code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" value="{{ $vendor->email }}" name="email" class="form-control">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" value="{{ $vendor->address }}" name="address"
                                            class="form-control">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <input type="text" value="{{ $vendor->country }}" name="country"
                                            class="form-control">
                                        @error('country')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">State</label>
                                        <input type="text" value="{{ $vendor->state }}" name="state" class="form-control">
                                        @error('state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <input type="text" value="{{ $vendor->city }}" name="city" class="form-control">
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Category</label>
                                        <select name="category" id="" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($vendorCategories as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $vendor->vendor_category_id ? 'selected' : '' }}>{{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <h4>Admin Infomation</h4>
                                    <hr>

                                    <input type="hidden" name="user_id" value="{{ $vendor->user->id }}">
                                    <div class="form-group">
                                        <label for="">First name</label>
                                        <input type="text" value="{{ $vendor->user->first_name }}" name="admin_first_name"
                                            class="form-control">
                                        @error('admin_first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last name</label>
                                        <input type="text" value="{{ $vendor->user->last_name }}" name="admin_last_name"
                                            class="form-control">
                                        @error('admin_last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Other name</label>
                                        <input type="text" name="admin_other_name" value="{{ $vendor->user->other_name }}"
                                            class="form-control">
                                        @error('admin_other_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" value="{{ $vendor->user->address }}" name="admin_address"
                                            class="form-control">
                                        @error('admin_address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="admin_email" value="{{ $vendor->user->email }}"
                                            class="form-control">
                                        @error('admin_email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" name="admin_phone_number"
                                            value="{{ $vendor->user->phone_number }}" class="form-control">
                                        @error('admin_phone_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Update</button>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('vendors.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" name="code" value="{{ old('code') }}"
                                            class="form-control">
                                        @error('code')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" value="{{ old('email') }}"
                                            class="form-control">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            class="form-control">
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <input type="text" name="country" value="{{ old('country') }}"
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
                                        <input type="text" name="city" value="{{ old('city') }}"
                                            class="form-control">
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Category</label>
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
                                    <h4>Admin Infomation</h4>
                                    <hr>

                                    <div class="form-group">
                                        <label for="">First name</label>
                                        <input type="text" name="admin_first_name" value="{{ old('admin_first_name') }}"
                                            class="form-control">
                                        @error('admin_first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Last name</label>
                                        <input type="text" name="admin_last_name" value="{{ old('admin_last_name') }}"
                                            class="form-control">
                                        @error('admin_last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Other name</label>
                                        <input type="text" name="admin_other_name" value="{{ old('admin_other_name') }}"
                                            class="form-control">
                                        @error('admin_other_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" name="admin_address" value="{{ old('admin_address') }}"
                                            class="form-control">
                                        @error('admin_address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="admin_email" value="{{ old('admin_email') }}"
                                            class="form-control">
                                        @error('admin_email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone Number</label>
                                        <input type="text" name="admin_phone_number"
                                            value="{{ old('admin_phone_number') }}" class="form-control">
                                        @error('admin_phone_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-block" type="submit">Create</button>
                                    </div>
                                </form>
                            @endisset

                        </div>
                    </div>
                    <div class="col-md-8">
                        <script type="text/javascript"></script>

                        <div class="table-responsive">
                            <table class="text-uppercase text-center table table-bordered table-condensed " id="table-4"
                                style="white-space:nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">S/N</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Code</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Phone Number</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Country</th>
                                        <th class="text-center">State</th>
                                        <th class="text-center">City</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vendors as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td><a
                                                    href="https://api.whatsapp.com/send?phone={{ $item->phone_number }}">{{ $item->phone_number }}</a>
                                            </td>
                                            <td>{{ $item->address }}</td>
                                            <td>{{ $item->country }}</td>
                                            <td>{{ $item->state }}</td>
                                            <td>{{ $item->city }}</td>
                                            <td>


                                                <div class="btn-group">
                                                    <form action="{{ route('vendors.destroy', $item->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    {{-- <a href="/a" class="btn btn-success"><i class="entypo-eye"></i> view</a> --}}
                                                    <a href="{{ route('vendors.edit', $item->id) }}"
                                                        class="btn btn-info btn-sm"><i class="entypo-pencil"></i>
                                                        Edit</a>
                                                    <button onclick="$('#password-reset').submit()"
                                                        class="btn btn-danger btn-sm ml-2">Reset Password</button>

                                                    <form action="{{ route('vendors.resetPassword', $item->user->id) }}"
                                                        method="POST" id="password-reset">
                                                        @method('PUT')
                                                        @csrf
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('page_scripts')
        <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
    @endsection
