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
                @isset($learningResource)
                    <div class="col-md-12">
                        <h3>Edit Learning Resource</h3>
                        <hr>
                        <form action="{{ route('learning-resources.update', $learningResource->id) }}" method="POST"
                            class="form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" required class="form-control"
                                            value="{{ old('title') ?? $learningResource->title }}">
                                        @error('title')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" required class="form-control"
                                            value="{{ old('description') ?? $learningResource->description }}">
                                        @error('description')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="other_name">Resource Type</label>
                                        <select name="type" id="resource-type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="text"
                                                {{ old('type') == 'text' || $learningResource->type == 'text' ? 'selected' : '' }}>
                                                Text</option>
                                            <option value="file"
                                                {{ old('type') == 'file' || $learningResource->type == 'file' ? 'selected' : '' }}>
                                                File</option>
                                        </select>
                                        @error('type')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('subject_id') == $item->id || $learningResource->subject_id == $item->id ? ' selected="selected"' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('subject_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_class_id">Class</label>
                                        <select name="school_class_id" id="school_class_id" class="form-control">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('school_class_id') == $item->id || $learningResource->school_class_id == $item->id ? ' selected="selected"' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('school_class_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="class">Resource Content</label>

                                    <div id="resource-content"
                                        class="{{ old('type') == 'text' || $learningResource->type == 'text' ? '' : 'd-none' }}">
                                        <textarea name="content" id="" cols="30" rows="10" class="form-control ckeditor"
                                            placeholder="Enter your resource content">
                                        {!! old('content') ?? $learningResource->content !!}
                                        </textarea>

                                    </div>
                                    <input type="file" name="file"
                                        class="form-control {{ old('type') == 'file' || $learningResource->type == 'file' ? '' : 'd-none' }}"
                                        id="file">

                                    @error('file')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror

                                    @error('content')
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
                        <h3>Add Learning Resource</h3>
                        <hr>
                        <form action="{{ route('learning-resources.store') }}" method="POST" class="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <input type="text" name="description" required class="form-control"
                                            value="{{ old('description') }}">
                                        @error('description')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="other_name">Resource Type</label>
                                        <select name="type" id="resource-type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                            <option value="file" {{ old('type') == 'file' ? 'selected' : '' }}>File</option>
                                        </select>
                                        @error('type')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subject_id">Subject</label>
                                        <select name="subject_id" id="subject_id" class="form-control">
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('subject_id') == $item->id ? ' selected="selected"' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('subject_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="school_class_id">Class</label>
                                        <select name="school_class_id" id="school_class_id" class="form-control">
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('school_class_id') == $item->id ? ' selected="selected"' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('school_class_id')
                                            <div>
                                                <small class="text-danger">{{ $message }}</small>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="class">Resource Content</label>

                                    <div id="resource-content" class="{{ old('type') == 'text' ? '' : 'd-none' }}">
                                        <textarea name="content" id="" cols="30" rows="10" class="form-control ckeditor"
                                            placeholder="Enter your resource content"></textarea>

                                    </div>
                                    <input type="file" name="file"
                                        class="form-control {{ old('type') == 'file' ? '' : 'd-none' }}" id="file">

                                    @error('file')
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                    @enderror

                                    @error('content')
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
        $("#resource-type").change(function(e) {
            var type = $(e.target).val();
            if (type == 'file') {
                $('#file').removeClass('d-none');
                $('#resource-content').addClass('d-none');
            } else {
                $('#file').addClass('d-none');
                $('#resource-content').removeClass('d-none');

            }
        })
    </script>
@endsection
