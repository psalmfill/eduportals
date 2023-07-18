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
                            <div class="col-md-4">
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

                <form action="{{ route('students.promote') }}" method="POST">
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

                            <div class="table-responsive">
                                <table class="table table-bordered datatable mt-4" id="table-4">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Reg. No</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>
                                                <input type="checkbox" class="check-all" id=""> Check All
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            <tr class="odd gradeX">
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->reg_no }}</td>
                                                <td class="text-center"> <img width="100" height="100"
                                                        src="{{ $item->avatar }}" alt="image" class="img-fluid">
                                                </td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ ucwords($item->gender) }}</td>
                                                <td>{{ $item->school_class->name }}</td>
                                                <td>{{ $item->section->name }}</td>
                                                <td style="padding:18px">
                                                    <input class="check" type="checkbox" name="students[]"
                                                        value="{{ $item->id }}" id="">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Reg. No</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>
                                                <input type="checkbox" class="check-all" id=""> Check All
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row bg-dark pt-3">
                        <div class="col-md-3 text-white">
                            <h4>Promotion to:</h4>
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="next_section" id="next-section" class="form-control" required>
                                    <option value="">Select Next Section</option>
                                </select>
                                @error('next_section')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-sm">Promote to Next</button>
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
