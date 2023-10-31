@extends('layouts.student')

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
                    @error('students')
                        <div class=" text-center alert alert-danger">{{ $message }}</div>
                    @enderror
                    <br />
                    {{-- <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            var $table4 = jQuery("#table-4");

                            $table4.DataTable({
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ]
                            });
                        });
                    </script> --}}

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
                        @isset($learningResources)
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
                                                <a href="{{ route('student.learning-resources.show', $item->id) }}"
                                                    class="btn btn-info btn-sm "> View</a>
                                            @else
                                                <a href="{{ route('student.learning-resources.download', $item->id) }}"
                                                    class="btn btn-info btn-sm ">
                                                    Download</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset

                    </div>
                </div>
            </div>
            <br>
        </div>
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
        $(".check-all").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
