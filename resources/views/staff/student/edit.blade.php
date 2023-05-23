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
            <a href="{{ route('students.index') }}">
                <i class="entypo-users"></i>
                Students
            </a>
        </li>
        <li>

            <a href="{{ route('students.show', $student->id) }}">
                <i class="entypo-user"></i>
                {{ $student->full_name }}
            </a>
        </li>
        <li>
            <a href="#">
                <i class="entypo-pencil"></i>
                Edit
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">

            @isset($error)
                {{ $error }}
            @endisset
            <div class="row">
                <div class="col-md-12">
                    <h3>Student Update Form</h3>
                    <hr>
                    <form action="{{ route('students.update', $student->id) }}" method="POST" class="form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <fieldset>
                            <legend>Personal Information</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" required class="form-control"
                                            value="{{ $student->first_name }}">
                                        @error('first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" required class="form-control"
                                            value="{{ $student->last_name }}">
                                        @error('last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="other_name">Other Name</label>
                                        <input type="text" name="other_name" class="form-control"
                                            value="{{ $student->other_name }}">
                                        @error('other_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth</label>

                                        <input type="text" name="date_of_birth" value="{{ $student->date_of_birth }}"
                                            class="form-control datepicker" data-start-view="1">
                                        @error('date_of_birth')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood-group" class="form-control">
                                            <option value="A+" {{ $student->blood_group == 'A+' ? 'selected' : '' }}>A
                                                RhD
                                                positive
                                                (A+)</option>
                                            <option value="A-" {{ $student->blood_group == 'A-' ? 'selected' : '' }}>A
                                                RhD
                                                negative
                                                (A-)</option>
                                            <option value="B+" {{ $student->blood_group == 'B+' ? 'selected' : '' }}>B
                                                RhD
                                                positive
                                                (B+)</option>
                                            <option value="B-" {{ $student->blood_group == 'B-' ? 'selected' : '' }}>B
                                                RhD
                                                negative
                                                (B-)</option>
                                            <option value="O+" {{ $student->blood_group == 'O+' ? 'selected' : '' }}>O
                                                RhD
                                                positive
                                                (O+)</option>
                                            <option value="O-" {{ $student->blood_group == 'O-' ? 'selected' : '' }}>O
                                                RhD
                                                negative
                                                (O-)</option>
                                            <option value="AB+ {{ $student->blood_group == 'AB+' ? 'selected' : '' }}">AB
                                                RhD
                                                positive (AB+)</option>
                                            <option value="AB-" {{ $student->blood_group == 'AB-' ? 'selected' : '' }}>
                                                AB
                                                RhD
                                                negative (AB-) </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="genotype">Genotype</label>
                                        <select name="genotype" id="genotype" class="form-control">
                                            <option value="AA" {{ $student->genotype == 'AA' ? 'selected' : '' }}>AA
                                            </option>
                                            <option value="AS" {{ $student->genotype == 'AS' ? 'selected' : '' }}>AS
                                            </option>
                                            <option value="AC" {{ $student->genotype == 'AC' ? 'selected' : '' }}>AC
                                            </option>
                                            <option value="SS" {{ $student->genotype == 'SS' ? 'selected' : '' }}>SS
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" value="{{ $student->country }}"
                                            class="form-control" required>
                                        @error('country')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" name="state" value="{{ $student->state }}"
                                            class="form-control" required>
                                        @error('state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city" value="{{ $student->city }}"
                                            class="form-control" required>
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="other_name">Passport</label>
                                    </div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                            data-trigger="fileinput">
                                            <img src="{{ asset($student->avatar) }}" alt="..."
                                                class="img-responsive" style="height: 100%">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px"></div>
                                        <div>
                                            <span class="btn btn-white btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="passport" accept="image/*">
                                            </span>
                                            <a href="#" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput">Remove</a>
                                        </div>
                                    </div>
                                    @error('passport')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address_1">Address 1</label>
                                        <input type="text" name="address_1" value="{{ $student->address_1 }}"
                                            class="form-control" required>
                                        @error('address_1')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address_2">Address 2</label>
                                        <input type="text" name="address_2" value="{{ $student->address_2 }}"
                                            class="form-control">
                                        @error('address_2')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Academics</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="class">Class</label>
                                        <select name="class" id="class" class="form-control">
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $student->school_class_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section">Section</label>
                                        <select name="section" id="section" class="form-control">
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ $student->section_id == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reg_no">Reg. No.</label>
                                        <Input class="form-control" name="reg_no" value="{{ $student->reg_no }}"
                                            type="text" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="active">Active</label>
                                        <div class="make-switch">
                                            <input name="active" type="checkbox"
                                                {{ $student->active ? 'checked' : '' }}>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Parent/Guardian</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parent_first_name">First Name</label>
                                        <input type="text" name="parent[first_name]"
                                            value="{{ $student->parent->first_name }}" class="form-control" required>
                                        @error('parent_first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parent_last_name">Last Name</label>
                                        <input type="text" name="parent[last_name]"
                                            value="{{ $student->parent->last_name }}" class="form-control" required>
                                        @error('parent_last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parent_other_name">Other Name</label>
                                        <input type="text" name="parent[other_name]"
                                            value="{{ $student->parent->other_name }}" class="form-control">
                                        @error('parent_other_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parent_email">Email</label>
                                        <input type="text" name="parent[email]" value="{{ $student->parent->email }}"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="parent_phone_number">Phone Number</label>
                                        <input type="text" name="parent[phone_number]"
                                            value="{{ $student->parent->phone_number }}" class="form-control">
                                        @error('parent_phone_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="other_name">Address</label>
                                        <input type="text" name="parent[address]"
                                            value="{{ $student->parent->address }}" class="form-control">
                                        @error('parent_address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block btn-lg">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/fileinput.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>

    <!-- Imported scripts on this page -->
    <script src="{{ asset('assets/js/bootstrap-switch.min.js') }}"></script>
    <script>
        $('#class').change(function(e) {
            const class_id = e.target.value;
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections',
            }).done(function(data) {
                let html = '<option>Select Section</option>'
                data.sections.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#section').html(html);
                // show_loading_bar(100);
            });
        })
        $(document).load(function(e) {
            const class_id = $('#class').val;
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections',
            }).done(function(data) {
                let html = '<option>Select Section</option>'
                data.sections.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#section').html(html);
                // show_loading_bar(100);
            });
        })
    </script>
@endsection
