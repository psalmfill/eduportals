@extends('layouts.dashboard')
@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{ route('staff.dashboard') }}">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('students.index') }}">
                <i class="entypo-users"></i>
                Students
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                {{ $student->full_name }}
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

                <div class="col-md-8 offset-md-2">
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="2" class="text-center text-md-left">
                                <img width="200" height="200" src="{{ $student->avatar }}" alt="image"
                                    class="img-responsive rounded">
                            </td>
                        </tr>
                        <tr>

                            <td colspan='2'>
                                <h4>Personal Information</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>{{ $student->full_name }}</td>
                        </tr>
                        {{-- <tr>
                    <td>Last Name</td>
                    <td>{{$student->last_name}}</td>
                </tr> --}}
                        <tr>
                            <td>Gender</td>
                            <td>{{ $student->gender }}</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>{{ $student->date_of_birth }}</td>
                        </tr>
                        <tr>
                            <td>Blood Group</td>
                            <td>{{ $student->blood_group }}</td>
                        </tr>
                        <tr>
                            <td>Genotype</td>
                            <td>{{ $student->genotype }}</td>
                        </tr>
                        <tr>
                            <td>Religion</td>
                            <td>{{ $student->religion }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $student->country }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $student->state }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $student->city }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $student->state }}</td>
                        </tr>
                        <tr>
                            <td>Address 1</td>
                            <td>{{ $student->address_1 }}</td>
                        </tr>
                        <tr>
                            <td>Address 2</td>
                            <td>{{ $student->address_2 }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $student->address_2 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Academic</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>Class</td>
                            <td>{{ $student->school_class->name }}</td>
                        </tr>
                        <tr>
                            <td>Section</td>
                            <td>{{ $student->section->name }}</td>
                        </tr>
                        <tr>
                            <td>Registration Number</td>
                            <td>{{ $student->reg_no }}</td>
                        </tr>
                        <tr>
                            <td>Active</td>
                            <td>{{ $student->active ? 'True' : 'False' }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4>Parent/Guardian</h4>
                            </td>
                        </tr>
                        <tr>
                            <td>First Name</td>
                            <td>{{ $student->parent->first_name }}</td>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td>{{ $student->parent->last_name }}</td>
                        </tr>
                        <tr>
                            <td>Other Name</td>
                            <td>{{ $student->parent->other_name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $student->parent->email }}</td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td>{{ $student->parent->phone_number }}</td>
                        </tr>
                    </table>
                    <br>

                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-sm">Edit</a>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
