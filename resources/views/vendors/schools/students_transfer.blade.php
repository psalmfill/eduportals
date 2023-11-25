@extends('layouts.vendor')

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
                Students
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Student</h3>
                    <form action="" class="form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="school" id="school" class="form-control input-lg" required>
                                        <option value="">Select School</option>
                                        @foreach ($schools as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($school_id) && $school_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="class" id="class" class="form-control input-lg" required>
                                        <option value="">Select Class</option>
                                        @isset($classes)
                                            @foreach ($classes as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ isset($class_id) && $class_id == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg" required>
                                        <option value="">Select Section</option>
                                        @isset($sections)
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    {{ isset($section_id) && $section_id == $section->id ? 'selected' : '' }}>
                                                    {{ $section->name }}</option>
                                            @endforeach
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
                </div>
            </div>
        </div>
    </div>
    @isset($students)
        <div class="card">
            <div class="card-body">

                {{-- <form action="{{ route('students.promote') }}" method="POST"> --}}
                <form action="" method="POST">
                    @csrf
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
                                        Passport
                                    </div>
                                    <div class="col-md-3 my-md-auto py-2">
                                        Name
                                    </div>
                                    <div class="col-md-2 my-md-auto py-2">
                                        Reg. No
                                    </div>
                                    <div class="col-md-2 my-md-auto py-2">
                                        Class
                                    </div>

                                    <div class="col-md-2 my-md-auto py-2">
                                        Section
                                    </div>
                                    <div class="col-md-2 my-md-auto pt-3">
                                        Check All <br> <input type="checkbox" class="check-all" id="">
                                    </div>
                                </div>
                                @foreach ($students as $item)
                                    <div class="row striped border py-3 text-center align-middle">
                                        <div class="col-md-1 my-md-auto my-1">
                                            <img width="100" height="100" src="{{ $item->avatar }}" alt="image"
                                                class="rounded">
                                        </div>
                                        <div class="col-md-3 my-md-auto my-1">
                                            <div class="text-uppercase">{{ $item->full_name }}</div>
                                        </div>
                                        <div class="col-md-2 my-md-auto my-1">
                                            {{ $item->reg_no }}
                                        </div>
                                        <div class="col-md-2 my-md-auto my-2">
                                            {{ $item->school_class->name }}
                                        </div>
                                        <div class="col-md-2 my-md-auto my-2">
                                            {{ $item->section->name }}
                                        </div>
                                        <div class="col-md-2 my-md-auto my-1">
                                            <input class="check" type="checkbox" name="students[]" value="{{ $item->id }}"
                                                id="">
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row bg-dark pt-3">
                        <div class="col-md-1 text-white">
                            <h4>Transfer to:</h4>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="next_school" id="next-school" class="form-control input-lg" required>
                                    <option value="">Select School</option>
                                    @foreach ($schools as $item)
                                        <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="next_class" id="next-class" class="form-control" required>
                                    <option value="">Select Next Class</option>
                                    @foreach ($classes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('next_class')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="next_section" id="next-section" class="form-control" required>
                                    <option value="">Select Next Section</option>
                                </select>
                                @error('next_section')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-sm">Transfer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>

    <script>
        $('#school').change(function(e) {
            const school_id = e.target.value;
            console.log(school_id);
            // show_loading_bar(65);
            //fetch class sections
            if (school_id) {
                $.ajax({

                    url: BASE_URL + "/api/schools/" + school_id + '/classes',
                }).done(function(data) {
                    console.log(data);
                    let html = '<option>Select Section</option>'
                    data.classes.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#class').html(html);
                    // show_loading_bar(100);
                });
            }
        })
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
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#section').html(html);
                // show_loading_bar(100);
            });
        })
        $('#next-school').change(function(e) {
            const school_id = e.target.value;
            console.log(school_id);
            // show_loading_bar(65);
            //fetch class sections
            if (school_id) {
                $.ajax({

                    url: BASE_URL + "/api/schools/" + school_id + '/classes',
                }).done(function(data) {
                    console.log(data);
                    let html = '<option>Select Next Class</option>'
                    data.classes.forEach(function(el) {
                        html += '<option value="' + el.id + '">' + el.name + '</option>'
                    })


                    $('#next-class').html(html);
                    // show_loading_bar(100);
                });
            }
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
