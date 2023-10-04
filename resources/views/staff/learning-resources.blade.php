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
                                                {{ isset($class_id) && $class_id == $item->id ? 'selected' : '' }}>
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
                                        @isset($subjects)
                                            @foreach ($subjects as $sub)
                                                <option value="{{ $sub->id }}"
                                                    {{ isset($subject) and ($sub->id == $subject->id ? 'selected' : '') }}>
                                                    {{ $sub->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">Select Subject</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('learning-resources.create') }}" class="btn btn-success">Add New Resource</a>
                    </div>
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
                        <div class="row table-head border d-none d-md-flex font-weight-bold text-center">


                            <div class="col-md-1 my-md-auto py-2">
                                id
                            </div>
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
                        @isset($learnedResources)
                            @foreach ($students as $item)
                                <div class="row striped border py-3 text-center align-middle">
                                    <div class="col-md-1 my-md-auto my-1">

                                    </div>
                                    <div class="col-md-3 my-md-auto my-1">
                                        <div class="text-uppercase">{{ $item->title }}</div>
                                    </div>
                                    <div class="col-md-2 my-md-auto my-1">
                                        {{ $item->type }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->school_class->name }}
                                    </div>
                                    <div class="col-md-2 my-md-auto my-2">
                                        {{ $item->section->name }}
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
