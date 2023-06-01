@extends('layouts.dashboard')
@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="">
                <i class="entypo-folder"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('students.index') }}">
                <i class="entypo-users"></i>
                Students
            </a>
            <a href="#">
                <i class="entypo-user-plus"></i>
                Add
            </a>
        </li>
    </ol>
    @isset($error)
        {{ $error }}
    @endisset
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="well well-sm">
                <h4>Please fill the details to update staff.</h4>


                <form id="rootwizard-2" method="post" action="{{ route('staff.update', $staff->id) }}"
                    class="form-wizard validate" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="steps-progress">
                        <div class="progress-indicator"></div>
                    </div>

                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab2-1" data-toggle="tab"><span></span>Personal Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab2-2" data-toggle="tab"><span></span>Address</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab2-3" data-toggle="tab"><span></span>Education</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tab2-5" data-toggle="tab"><span></span>Register</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab2-1">

                            <div class="row">

                                <div class="col-md-4">
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

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="last_name">Last Name</label>
                                        <input class="form-control" name="last_name" id="last_name" data-validate="required"
                                            placeholder="Your last name" value="{{ $staff->last_name }}" />
                                        @error('last_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="other_name">Other Name</label>
                                        <input class="form-control" name="other_name" id="other_name"
                                            placeholder="Your other name" value="{{ $staff->other_name }}" />
                                        @error('other_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>



                                {{-- <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="birthdate">Date of Birth</label>
                        <input class="form-control" name="birthdate" id="birthdate" data-validate="required" data-mask="date" placeholder="Pre-formatted birth date" />
                    </div>
                </div> --}}

                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="date_of_birth">Date of Birth</label>
                                        <input class="form-control" name="date_of_birth" id="date_of_birth"
                                            data-validate="required" placeholder="Your full name" data-mask="date"
                                            value="{{ $staff->date_of_birth }}" />
                                        @error('date_of_birth')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email Address</label>
                                        <input class="form-control" name="email" id="email"
                                            placeholder="Your email address" data-mask="email"
                                            value="{{ $staff->email }}" />
                                        @error('email')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="phone_number">Phone number</label>
                                        <input class="form-control" name="phone_number" id="phone_number"
                                            placeholder="Your phone number" value="{{ $staff->phone_number }}" />
                                        @error('phone_number')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane" id="tab2-2">

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address_1">Address 1</label>
                                        <input class="form-control" name="address_1" id="address_1"
                                            data-validate="required" placeholder="Enter your street address"
                                            value="{{ $staff->address_1 }}" />
                                        @error('address_1')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="address_2">Address 2</label>
                                        <input class="form-control" name="address_2" id="address_line_2"
                                            placeholder="(Optional) Secondary Address" value="{{ $staff->address_2 }}" />
                                        @error('address_2')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" for="country">Country</label>
                                        <input class="form-control" name="country" id="country"
                                            data-validate="required" placeholder="Country"
                                            value="{{ $staff->country }}" />
                                        @error('country')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="state">State</label>

                                        <input class="form-control" name="state" id="state"
                                            data-validate="required" placeholder="State" value="{{ $staff->state }}" />
                                        @error('state')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror

                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label" for="city">City</label>
                                        <input class="form-control" name="city" id="city"
                                            data-validate="required" placeholder="City" value="{{ $staff->city }}" />
                                        @error('city')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane" id="tab2-3">

                            <strong>Primary School</strong>
                            <br />
                            <br />

                            <div class="row">
                                @php
                                    $primary = $staff
                                        ->qualifications()
                                        ->where('type', 'primary')
                                        ->first();
                                    $secondary = $staff
                                        ->qualifications()
                                        ->where('type', 'secondary')
                                        ->first();
                                    $university = $staff
                                        ->qualifications()
                                        ->where('type', 'university')
                                        ->first();
                                @endphp
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label" for="prim_subject">Certificate Obtained</label>
                                        <input class="form-control" name="primary[subject]" id="prim_subject"
                                            data-validate="require" placeholder="Graduation Degree"
                                            value="{{ $primary->subject }}" />
                                        @error('primary.subject')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="prim_school">School Name</label>
                                        <input class="form-control" name="primary[school]" id="prim_school"
                                            value="{{ $primary->school }}" />
                                        @error('primary.school')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="prim_start_date">Start Date</label>
                                        <input class="form-control datepicker" name="primary[start_date]"
                                            id="prim_start_date" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $primary->start_date }}" />
                                        @error('primary.start_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="prim_end_date">End Date</label>
                                        <input class="form-control datepicker" name="primary[end_date]"
                                            id="prim_end_date" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $primary->end_date }}" />
                                        @error('primary.end_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <br />

                            <strong>Secondary School</strong>
                            <br />
                            <br />

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="second_subject">Certificate Obtained</label>
                                        <input class="form-control" name="secondary[subject]" id="second_subject"
                                            data-validate="require" placeholder="High School"
                                            value="{{ $secondary->subject }}" />
                                        @error('secondary.subject')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="second_school">School Name</label>
                                        <input class="form-control" name="secondary[school]" id="second_school"
                                            value="{{ $secondary->school }}" />
                                        @error('secondary.school')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="second_date_start">Start Date</label>
                                        <input class="form-control datepicker" name="secondary[start_date]"
                                            id="second_date_start" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $secondary->start_date }}" />
                                        @error('secondary.start_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="second_date_end">End Date</label>
                                        <input class="form-control datepicker" name="secondary[end_date]"
                                            id="second_date_end" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $secondary->end_date }}" />
                                        @error('secondary.end_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <strong>University</strong>
                            <br />
                            <br />

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="second_subject">Certificate Obtained</label>
                                        <input class="form-control" name="university[subject]" id="second_subject"
                                            data-validate="require" placeholder="Gradration degree"
                                            value="{{ $university->subject }}" />
                                        @error('university.subject')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="second_school">School Name</label>
                                        <input class="form-control" name="university[school]" id="second_school"
                                            value="{{ $university->school }}" />
                                        @error('university.school')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="second_date_start">Start Date</label>
                                        <input class="form-control datepicker" name="university[start_date]"
                                            id="second_date_start" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $university->start_date }}" />
                                        @error('university.start_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label" for="second_date_end">End Date</label>
                                        <input class="form-control datepicker" name="secondary[end_date]"
                                            id="second_date_end" data-start-view="2" placeholder="(Optional)"
                                            value="{{ $university->end_date }}" />
                                        @error('university.end_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab-pane" id="tab2-5">

                            <div class="form-group">
                                <label class="control-label">Choose Username</label>

                                <div class="input-group">
                                    {{-- <div class="input-group-addon">
                                        <i class="entypo-user"></i>
                                    </div> --}}

                                    <input type="text" class="form-control" name="username" id="username"
                                        data-validate="required,minlength[5]"
                                        data-message-minlength="Username must have minimum of 5 chars."
                                        placeholder="Could also be your email" value="{{ $staff->username }}" readonly />
                                    @error('username')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        @error('gender')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label class="control-label" for="second_date_end">Passport</label>


                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                style="max-width: 200px; height: 150px">
                                                <img src="{{ $staff->image ? asset($staff->avatar) : 'http://placehold.it/200x150' }}"
                                                    class="h-100" alt="...">
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="btn btn-white btn-file">
                                                    <span class="fileinput-new">Select image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="passport" accept="image/*">
                                                </span>
                                                <button class="btn btn-danger fileinput-exists btn-sm"
                                                    data-dismiss="fileinput">Remove</button>
                                            </div>

                                            @error('passport')
                                                <div>
                                                    <small class="text-danger">{{ $message }}</small>
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary ">Update</button>
                            </div>

                        </div>

                        {{-- <ul class="pager wizard">
                            <li class="previous">
                                <a href="#"><i class="entypo-left-open"></i> Previous</a>
                            </li>

                            <li class="next">
                                <a href="#">Next <i class="entypo-right-open"></i></a>
                            </li>
                        </ul> --}}
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/fileinput.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/selectboxit/jquery.selectBoxIt.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.multi-select.js') }}"></script>
@endsection
