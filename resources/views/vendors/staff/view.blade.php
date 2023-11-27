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
            <a href="{{ route('vendor.staff.index') }}">
                <i class="entypo-users"></i>
                staff
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                {{ $staff->name }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-eye"></i>
                View
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-7">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2">
                                {{-- <img src="{{asset('assets/images/member-4.jpg')}}" alt="image" class="img-responsiv img-fluid"> --}}
                                <img height="200" class="img-circle" src="{{ asset(\Storage::url($staff->image)) }}"
                                    alt="image" class="img-responsiv img-fluid">
                            </td>
                        </tr>
                        <tr>

                            <td colspan='2'>
                                <h4>Personal Information</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>{{ $staff->name }}</td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>{{ $staff->gender }}</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{ $staff->date_of_birth }}</td>
                        </tr>
                        <tr>
                            <td>Religion</td>
                            <td>{{ $staff->religion }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $staff->country }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $staff->state }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $staff->city }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $staff->state }}</td>
                        </tr>
                        <tr>
                            <td>Address 1</td>
                            <td>{{ $staff->address_1 }}</td>
                        </tr>
                        <tr>
                            <td>Address 2</td>
                            <td>{{ $staff->address_2 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Academic</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Classes</td>
                            <td>
                                @foreach ($staff->school_classes()->wherePivotIn(
                'school_Id',
                user()->vendor->schools()->pluck('id'),
            )->get()->unique() as $item)
                                    {{ $item->name }},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Subjects</td>
                            <td>
                                @foreach ($staff->subjects()->wherePivotIn(
                'school_Id',
                user()->vendor->schools()->pluck('id'),
            )->get() as $item)
                                    {{ $item->name }},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Qualifications</h4>
                            </td>
                        </tr>
                        @foreach ($staff->qualifications as $qualification)
                            <tr class="text-capitalize">
                                <td>{{ $qualification->type }}</td>
                                <td>{{ $qualification->subject }} - {{ $qualification->school }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="">
                                <h4>Schools</h4>

                            </td>
                            <td>
                                <ol>
                                    @foreach ($staff->schools as $school)
                                        <li>{{ $school->name }}</li>
                                    @endforeach
                                </ol>
                            </td>
                        </tr>

                    </table>
                    <br>
                    <div class="d-flex">
                        <a href="{{ route('vendor.staff.edit', $staff->id) }}" class="btn btn-primary mr-2">Edit</a>
                        <a href="{{ route('vendor.staff.manageSchools', $staff->id) }}"
                            class="btn btn-outline-secondary">Manage
                            Schools</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3> Update Password</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vendor.staff.resetPassword', $staff->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="text" placeholder="Enter new password" name="password"
                                        class="form-control">
                                </div>
                                <button class="btn btn-primary">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
