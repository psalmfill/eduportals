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
                General Settings
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card">
        <div class="card-body">

            <h1>Settings</h1>
            <hr>
            <form role="form" method="post" class="form-horizontal form-groups-bordered validate" action=""
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary" data-collapsed="1">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    General Settings
                                </div>

                                {{-- <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                </div> --}}
                            </div>

                            <div class="panel-body">
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label">Name</label>

                                            <input type="text" name="name" class="form-control" id="field-1"
                                                value="{{ $school->name }}">

                                        </div>

                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label">Tagline</label>

                                            <input type="text" class="form-control" id="field-2" value="">
                                            <span class="description">Few words that will describe your site.</span>

                                        </div>

                                        <div class="form-group">
                                            <label for="field-4" class="col-sm-3 control-label">Email address</label>

                                            <input type="text" class="form-control" name="email" id="field-4"
                                                data-validate="required,email" value="{{ $school->email }}">

                                        </div>


                                        <div class="form-group">
                                            <label for="field-3" class="col-sm-3 control-label">Logo</label>
                                            <div class="fileinput-new thumbnail" data-provides="fileinput">

                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                    style="max-width:200px;max-height: 150px">
                                                    <img src="{{ asset(\Storage::url($school->logo)) ?? 'http://placehold.it/150x150' }}"
                                                        class="h-100 w-100" alt="...">
                                                </div>
                                                <div class="mt-5">
                                                    <span class="btn btn-white btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="logo" id="logo"
                                                            accept="image/*">
                                                    </span>
                                                    <a href="#" class="btn btn-sm btn-danger fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label for="field-1" class="col-sm-3 control-label">Phone Number</label>

                                            <input type="text" name="phone_number" class="form-control" id="field-1"
                                                value="{{ $school->phone_number }}">

                                        </div>

                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label">Address</label>

                                            <input type="text" name="address" class="form-control" id="field-2"
                                                value="{{ $school->address }}">

                                        </div>

                                        <div class="form-group">
                                            <label for="field-2" class="col-sm-3 control-label">Slogan</label>

                                            <input type="text" name="slogan" class="form-control" id="field-2"
                                                value="{{ $generalSettings->slogan }}">

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">

                        <div class="panel panel-primary" data-collapsed="1">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    Academics
                                </div>

                                {{-- <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                </div> --}}
                            </div>

                            <div class="panel-body">

                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label class="control-label">Coat of Arm</label>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                    style="max-width: 200px; max-height: 150px">
                                                    <img src="{{ asset(\Storage::url($generalSettings->coat_of_arm)) ?? 'http://placehold.it/150x150' }}"
                                                        class="h-100 w-100" alt="...">
                                                </div>
                                                <div>
                                                    <span class="btn btn-white btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="coat_of_arm" id="coat_of_arm"
                                                            accept="image/*">
                                                    </span>
                                                    <a href="#" class="btn btn-sm btn-danger fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="control-label">School Stamp</label>

                                            <div class="fileinput fileinput-new" data-provides="fileinput">

                                                <div class="fileinput-preview fileinput-exists thumbnail"
                                                    style="max-width: 200px; max-height: 150px">
                                                    <img src="{{ asset(\Storage::url($generalSettings->school_stamp)) ?? 'http://placehold.it/150x150' }}"
                                                        class="h-100 w-100" alt="...">
                                                </div>
                                                <div>
                                                    <span class="btn btn-white btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="stamp" id="stamp"
                                                            accept="image/*">
                                                    </span>
                                                    <a href="#" class="btn btn-sm btn-danger fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>


                    <div class="col-md-6">

                        <div class="panel panel-primary" data-collapsed="1">

                            <div class="panel-heading">
                                <div class="panel-title">
                                    Date and Time
                                </div>

                                {{-- <div class="panel-options">
                                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                    <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
                                </div> --}}
                            </div>

                            <div class="panel-body">
                                <hr>
                                <div class="form-group">
                                    <label for="field-3" class="col-sm-5 control-label">Date format</label>


                                    <div class="radio radio-replace">
                                        <input type="radio" id="rd-1" value="M d, Y" name="date_format"
                                            {{ $generalSettings->date_format == 'M d, Y' ? 'checked' : '' }}>
                                        <label>November 04, 2015</label>
                                    </div>

                                    <div class="radio radio-replace">
                                        <input type="radio" id="rd-2" value="m/D/Y" name="date_format"
                                            {{ $generalSettings->date_format == 'm/D/Y' ? 'checked' : '' }}>
                                        <label>11/04/2015</label>
                                    </div>

                                    <div class="radio radio-replace">
                                        <input type="radio" id="rd-3" value="Y/m/D" name="date_format"
                                            {{ $generalSettings->date_format == 'Y/m/D' ? 'checked' : '' }}>
                                        <label>2015/11/04</label>
                                    </div>

                                    <div class="radio radio-replace">
                                        <input type="radio" id="rd-4" name="date_format"
                                            {{ !collect(['M d, Y', 'Y/m/D', 'm/D/Y'])->contains($generalSettings->date_format) ? 'checked' : '' }}>
                                        <label>
                                            Custom format:
                                            <input type="text" class="form-control input-sm form-inline"
                                                value="{{ $generalSettings->date_format }}"
                                                style="width: 70px; display: inline-block;" />
                                            <p class="description">Read more about <a href="http://php.net/date"
                                                    target="_blank">date format</a></p>
                                        </label>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="field-4" class="col-sm-5 control-label">Current Session</label>
                            <select name="current_session" id="" class="form-control">
                                @foreach (App\Models\AcademicSession::all() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">


                        <div class="form-group">
                            <label for="field-4" class="col-sm-5 control-label">Current Term</label>
                            <select name="current_term" id="" class="form-control">
                                @foreach (App\Models\Term::where('school_id', $school->id)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>

                <div class="form-group default-padding">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>

            </form>

        </div>
    </div>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/fileinput.js') }}"></script>
@endsection
