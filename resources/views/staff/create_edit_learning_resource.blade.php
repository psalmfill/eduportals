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
                Add New Resource
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3>Add Learning Resource</h3>
                    <hr>
                    <form action="{{ route('students.store') }}" method="POST" class="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="first_name">Title <span class="text-danger">*</span></label>
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
                                            <option value="{{ $section->id }}">
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
