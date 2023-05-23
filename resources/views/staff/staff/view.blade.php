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
            <a href="{{ route('staff.index') }}">
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
                        {{-- <tr>
                    <td>Last Name</td>
                    <td>{{$staff->last_name}}</td>
                </tr> --}}
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
                                @foreach ($staff->school_classes()->wherePivot('school_Id', getSchool()->id)->get()->unique() as $item)
                                    {{ $item->name }},
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Subjects</td>
                            <td>
                                @foreach ($staff->subjects()->wherePivot('school_id', getSchool()->id)->get() as $item)
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
                    </table>
                    <br>
                    <a href="{{ route('staff.edit', $staff->id) }}" class="btn btn-primary">Edit</a>
                </div>
                @if (auth()->user()->role_id == 3)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h3> Update Password</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('staff.resetPassword', $staff->id) }}" method="POST">
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
                @endif
            </div>
        </div>
    </div>
@endsection
