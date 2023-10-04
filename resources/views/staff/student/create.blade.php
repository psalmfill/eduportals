@extends('layouts.dashboard')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>Student Admission Form</h3>
                    <hr>
                    <form action="{{ route('students.store') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf
                        <fieldset>
                            <legend>Personal Information</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" name="first_name" required class="form-control"
                                            value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" name="last_name" required class="form-control"
                                            value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="other_name">Other Name</label>
                                        <input type="text" name="other_name" value="{{ old('other_name') }}"
                                            class="form-control">
                                        @error('other_name')
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
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="date_of_birth">Date of Birth</label>

                                        <input type="text" name="date_of_birth" class="form-control datepicker"
                                            value="{{ old('date_of_birth') }}" data-start-view="1">
                                        @error('date_of_birth')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood-group" class="form-control">
                                            <option value="A+">A RhD positive (A+)</option>
                                            <option value="A-">A RhD negative (A-)</option>
                                            <option value="B+">B RhD positive (B+)</option>
                                            <option value="B-">B RhD negative (B-)</option>
                                            <option value="O+">O RhD positive (O+)</option>
                                            <option value="O-">O RhD negative (O-)</option>
                                            <option value="AB+">AB RhD positive (AB+)</option>
                                            <option value="AB-">AB RhD negative (AB-) </option>
                                        </select>
                                        @error('blood_group')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="genotype">Genotype</label>
                                        <select name="genotype" id="genotype" class="form-control">
                                            <option value="AA">AA</option>
                                            <option value="AS">AS</option>
                                            <option value="AC">AC</option>
                                            <option value="SS">SS</option>
                                        </select>
                                        @error('genotype')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ old('country') }}" required>
                                        @error('country')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <input type="text" name="state" value="{{ old('state') }}"
                                            class="form-control" required>
                                        @error('state')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" name="city"value="{{ old('city') }}"
                                            class="form-control" required>
                                        @error('city ')
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
                                        <label for="other_name">Passport</label>
                                        {{-- <input type="file" name="passport" class="form-control"> --}}
                                    </div>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px"><img
                                                src="http://placehold.it/200x150?text=Passport" class="h-100 w-100"
                                                alt="..." width="100%">
                                        </div>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address_1">Address 1</label>
                                        <input type="text" name="address_1" value="{{ old('address_1') }}"
                                            class="form-control" required>
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
                                        <label for="address_2">Address 2</label>
                                        <input type="text" name="address_2" value="{{ old('address_2') }}"
                                            class="form-control">
                                        @error('address_2')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
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
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('class')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section">Section</label>
                                        <select name="section" id="section" class="form-control">
                                        </select>
                                    </div>
                                    @error('section')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reg_no">Reg. No.</label>
                                        <Input class="form-control" name="reg_no" value="{{ $new_reg }}"
                                            type="text" readonly>

                                    </div>
                                </div> --}}
                            </div>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend>Parent/Guardian</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_first_name">First Name</label>
                                        <input type="text" name="parent[first_name]"
                                            value="{{ old('parent.first_name') }}" class="form-control" required>
                                        @error('parent.first_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_last_name">Last Name</label>
                                        <input type="text" name="parent[last_name]"
                                            value="{{ old('parent.last_name') }}" class="form-control" required>
                                        @error('parent.last_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_other_name">Other Name</label>
                                        <input type="text" name="parent[other_name]"
                                            value="{{ old('parent.other_name') }}" class="form-control">
                                        @error('parent.other_name')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_username">Username</label>
                                        <input type="text" name="parent[username]"
                                            value="{{ old('parent.username') }}" class="form-control">
                                        @error('parent.username')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_email">Email</label>
                                        <input type="text" name="parent[email]" value="{{ old('parent.email') }}"
                                            class="form-control">
                                        @error('parent.email')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parent_phone_number">Phone Number</label>
                                        <input type="text" name="parent[phone_number]"
                                            value="{{ old('parent.phone_number') }}" class="form-control">
                                        @error('parent.phone_number')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="other_name">Address</label>
                                        <input type="text" name="parent[address]" value="{{ old('parent.address') }}"
                                            class="form-control">
                                        @error('parent.address')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block btn-lg">Submit</button>
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
