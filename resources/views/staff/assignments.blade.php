@extends('layouts.dashboard')

@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

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
                Marks Register
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Result</h3>
                    <form action="{{ route('assignments.index') }}" method="get" class="form">
                        <input type="hidden" name="session" value="{{ getSettings()->current_session_id }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="class" id="class" class="form-control input-lg" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ isset($currentClass) && $currentClass->id == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg" required>
                                        @isset($sections)
                                            @foreach ($sections as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ $sec->id == $currentSection->id ? 'selected' : '' }}>
                                                    {{ $sec->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option>Select Section</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="subject" id="subject" class="form-control input-lg" required>
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
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('assignments.create') }}" class="btn btn-success">Setup Assignment</a>
                </div>
            </div>
        </div>
    </div>
    @isset($assignments)
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">

                    <div class="container table">
                        <div class="row table-head border d-none d-md-flex font-weight-bold">
                            <div class="col-md-3 my-md-auto py-2">
                                Title
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Class
                            </div>

                            <div class="col-md-2 my-md-auto py-2">
                                Section
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Subject
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Action
                            </div>
                        </div>
                        @if ($assignments->count() > 0)
                            @foreach ($assignments as $item)
                                <div class="row striped border py-3 align-middle">

                                    <div class="col-md-3 my-md-auto my-1">
                                        <div class="text-uppercase">{{ $item->title }}</div>
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->school_class->name }}
                                    </div>

                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->section->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->subject->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-1">
                                        <div class="d-flex">

                                            <a href="{{ route('assignments.show', $item->id) }}" class="btn btn-info btn-sm ">
                                                View</a>
                                            @if (!(user() instanceof \App\Models\Student))
                                                <a href="{{ route('assignments.edit', $item->id) }}"
                                                    class="btn btn-secondary btn-sm mx-2">
                                                    Edit</a>
                                                <button class="btn btn-danger btn-sm mr-4"
                                                    onclick="deleteAssignment({{ $item->id }})">
                                                    Delete</button>
                                                <form action="{{ route('assignments.destroy', $item->id) }}" method="POST"
                                                    id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                {!! $assignments->links() !!}
                            </div>
                        @else
                            <div class="col-md-12 my-md-auto py-2">
                                <h3 class="text-center alert alert-info">
                                    Nothing to show here
                                </h3>

                                @if (!(user() instanceof \App\Models\Student))
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('assignments.create') }}" class="btn btn-success">Setup
                                            Assignment</a>
                                    </div>
                                @endif
                            </div>
                        @endisset
                </div>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
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
                console.log(data)
                let html = '<option>Select Subject</option>'
                data.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#subject').html(html);
                // show_loading_bar(100);
            });
        })

        function deleteAssignment(id) {
            var v = confirm('Are you sure you want to delete');
            if (v) {
                $(document).find('#delete-form-' + id).submit();
            }
        }
    </script>
@endsection
