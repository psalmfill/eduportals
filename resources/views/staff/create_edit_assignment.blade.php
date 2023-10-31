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
                {{ isset($assignment) ? 'Edit' : 'Add' }} Assignment
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                @isset($assignment)
                    <div class="col-md-12">
                        <h3>Edit Assignment</h3>
                        <hr>
                        <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" class="form"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_class_id">Class <span class="text-danger">*</span></label>
                                        <select name="school_class_id" id="class" class="form-control input-lg" required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ $assignment->school_class_id == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('school_class_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section_id">Section</label>
                                        @php
                                            $sections = $assignment->school_class->sections;
                                        @endphp
                                        <select name="section_id" id="section" class="form-control input-lg" required>

                                            @isset($sections)
                                                <option value="">Select Section</option>

                                                @foreach ($sections as $sec)
                                                    <option value="{{ $sec->id }}"
                                                        {{ $sec->id == $assignment->section_id ? 'selected' : '' }}>
                                                        {{ $sec->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option>Select Section</option>
                                            @endisset
                                        </select>
                                        @error('section_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject" class="form-control input-lg" required>
                                            @isset($subjects)
                                                @foreach ($subjects as $sub)
                                                    <option value="{{ $sub->id }}"
                                                        {{ $sub->id == $assignment->subject_id ? 'selected' : '' }}>
                                                        {{ $sub->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">Select Subject</option>
                                            @endisset
                                        </select>

                                        @error('subject_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" required class="form-control"
                                            value="{{ old('title') ?? $assignment->title }}">
                                        @error('title')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="available_date">Available Date <span class="text-danger">*</span></label>
                                        <small class="d-block">Date it will be made available on the student's
                                            dashboard</small>
                                        <input type="date" name="available_date" required class="form-control"
                                            value="{{ old('available_date') ?? $assignment->available_date->format('m/d/yyyy') }}">
                                        @error('available_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="submission_date">Submission Date <span class="text-danger">*</span></label>
                                        <small class="d-block">Date it will should be submitted</small>
                                        <input type="date" name="submission_date" required class="form-control"
                                            value="{{ old('submission_date') ?? $assignment->submission_date }}">
                                        @error('submission_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="class">Content <span class="text-danger">*</span></label>
                                    <small class="d-block">Enter your assignment</small>

                                    <div id="content">
                                        <textarea name="content" id="" cols="30" rows="10" class="form-control ckeditor" required
                                            placeholder="Enter your content">
                                        {!! $assignment->content !!}</textarea>

                                    </div>


                                    @error('content')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <label for="class">Study Resources</label>
                                    <small class="d-block">Enter assignment learning resources</small>

                                    <div id="resources">
                                        <textarea name="resources" id="" cols="30" rows="10" class="form-control ckeditor"
                                            placeholder="Enter assignment study resources">
                                        {{ $assignment->resources }}</textarea>

                                    </div>


                                    @error('resources')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
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
                @else
                    <div class="col-md-12">
                        <h3>Setup Assignment</h3>
                        <hr>
                        <form action="{{ route('assignments.store') }}" method="POST" class="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_class_id">Class <span class="text-danger">*</span></label>
                                        <select name="school_class_id" id="class" class="form-control input-lg" required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">
                                                    {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('school_class_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="section_id">Section</label>
                                        <select name="section_id" id="section" class="form-control input-lg" required>
                                            @isset($sections)
                                                @foreach ($sections as $sec)
                                                    <option value="{{ $sec->id }}">
                                                        {{ $sec->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option>Select Section</option>
                                            @endisset
                                        </select>
                                        @error('section_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject" class="form-control input-lg" required>
                                            @isset($subjects)
                                                @foreach ($subjects as $sub)
                                                    <option value="{{ $sub->id }}"
                                                        {{ $sub->id == $subject->id ? 'selected' : '' }}>
                                                        {{ $sub->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="">Select Subject</option>
                                            @endisset
                                        </select>

                                        @error('subject_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" required class="form-control"
                                            value="{{ old('title') }}">
                                        @error('title')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="available_date">Available Date <span class="text-danger">*</span></label>
                                        <small class="d-block">Date it will be made available on the student's
                                            dashboard</small>
                                        <input type="date" name="available_date" required class="form-control"
                                            value="{{ old('available_date') }}">
                                        @error('available_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="submission_date">Submission Date <span
                                                class="text-danger">*</span></label>
                                        <small class="d-block">Date it will should be submitted</small>
                                        <input type="date" name="submission_date" required class="form-control"
                                            value="{{ old('submission_date') }}">
                                        @error('submission_date')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="class">Content <span class="text-danger">*</span></label>
                                    <small class="d-block">Enter your assignment</small>

                                    <div id="content">
                                        <textarea name="content" id="" cols="30" rows="10" class="form-control ckeditor" required
                                            placeholder="Enter your content"></textarea>

                                    </div>


                                    @error('content')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 mt-4">
                                    <label for="class">Study Resources</label>
                                    <small class="d-block">Enter assignment learning resources</small>

                                    <div id="resources">
                                        <textarea name="resources" id="" cols="30" rows="10" class="form-control ckeditor"
                                            placeholder="Enter assignment study resources"></textarea>

                                    </div>


                                    @error('resources')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror
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
                @endisset
            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets\js\ckeditor\ckeditor.js') }}"></script>
    <script>
        $('#class').change(function(e) {
            const class_id = e.target.value;
            console.log(class_id);
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
        $('#section').change(function(e) {
            const section_id = e.target.value;
            const class_id = $('#class').val();
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + "/subjects",
            }).done(function(data) {
                let html = '<option>Select Subject</option>'
                data.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#subject').html(html);
                // show_loading_bar(100);
            });
        })
    </script>
@endsection
