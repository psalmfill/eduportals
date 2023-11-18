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
                Learning Resources
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Resources</h3>
                    <form action="" class="form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="class" id="class" class="form-control input-lg" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($class) && $class->id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="subject" id="subject" class="form-control input-lg" required>
                                        <option value="">Select Subject</option>
                                        @foreach ($subjects as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ isset($subject) && $sub->id == $subject->id ? 'selected' : '' }}>
                                                {{ $sub->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                    @if (!(user() instanceof \App\Models\Student))
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('learning-resources.create') }}" class="btn btn-success">Add New Resource</a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
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
                                Subject
                            </div>
                            <div class="col-md-2 my-md-auto py-2">
                                Action
                            </div>
                        </div>
                        @if ($learningResources->count() > 0)
                            @foreach ($learningResources as $item)
                                <div class="row striped border py-3 align-middle">

                                    <div class="col-md-3 my-md-auto my-1">
                                        <div class="text-uppercase">{{ $item->title }}</div>
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->school_class->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->subject->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-1">
                                        <div class="d-flex">
                                            @if ($item->type == 'text')
                                                <a href="{{ route('learning-resources.show', $item->id) }}"
                                                    class="btn btn-info btn-sm "> View</a>
                                            @else
                                                <a href="{{ route('learning-resources.download', $item->id) }}"
                                                    class="btn btn-info btn-sm ">
                                                    Download</a>
                                            @endif
                                            @if (!(user() instanceof \App\Models\Student))
                                                <a href="{{ route('learning-resources.edit', $item->id) }}"
                                                    class="btn btn-secondary btn-sm mx-2">
                                                    Edit</a>
                                                <button class="btn btn-danger btn-sm mr-4"
                                                    onclick="deleteResource({{ $item->id }})">
                                                    Delete</button>
                                                <form action="{{ route('learning-resources.destroy', $item->id) }}"
                                                    method="POST" id="delete-form-{{ $item->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-md-12 my-md-auto py-2">
                                <h3 class="text-center alert alert-info">
                                    Nothing to show here
                                </h3>

                                @if (!(user() instanceof \App\Models\Student))
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('learning-resources.create') }}" class="btn btn-success">Add New
                                            Resource</a>
                                    </div>
                                @endif
                            </div>
                        @endisset
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection
@section('page_scripts')
<script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>

<script>
    $('#class').change(function(e) {
        const class_id = e.target.value;
        console.log(class_id);
        // show_loading_bar(65);
        //fetch class sections
        $.ajax({

            url: BASE_URL + "/api/classes/" + class_id + '/sections',
        }).done(function(data) {
            let html = '<option>Select Section</option>'
            data.sections.forEach(function(el) {
                html += '<option value="' + el.name + '">' + el.name + '</option>'
            })


            $('#section').html(html);
            // show_loading_bar(100);
        });
    })
    $('#next-class').change(function(e) {
        const class_id = e.target.value;
        console.log(class_id);
        // show_loading_bar(65);
        //fetch class sections
        $.ajax({

            url: BASE_URL + "/api/classes/" + class_id + '/sections',
        }).done(function(data) {
            let html = '<option>Select Next Section</option>'
            data.sections.forEach(function(el) {
                html += '<option value="' + el.id + '">' + el.name + '</option>'
            })


            $('#next-section').html(html);
            // show_loading_bar(100);
        });
    })

    function deleteResource(id) {
        var v = confirm('Are you sure you want to delete');
        if (v) {
            $(document).find('#delete-form-' + id).submit();
        }
    }
</script>
@endsection
