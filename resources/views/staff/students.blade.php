@extends('layouts.dashboard')

@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
@endsection

@section('breadcrum')
    <ol class="breadcrumb bc-3">
        <li>
            <a href="{{ route('staff.dashboard') }}">
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
                                    <select name="class" id="class" class="form-control input-lg">
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $item)
                                            <option value="{{ $item->name }}"
                                                {{ isset($class_id) && $class_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg">
                                        <option value="">Select Section</option>
                                        @isset($sections)
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->name }}"
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
                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            {{-- <br />
                            <script type="text/javascript">
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

                            {{-- <table class="table table-bordered datatable mt-4" id="table-4">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Reg. No</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $item)
                                        <tr class="">
                                            <td class="w-10">{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->reg_no }}</td>
                                            <td class="text-center"> <img width="100" height="100"
                                                    src="{{ $item->avatar }}" alt="image" class="img-fluid">
                                            </td>
                                            <td style="width">{{ $item->full_name }}</td>
                                            <td>{{ ucwords($item->gender) }}</td>
                                            <td>{{ $item->school_class->name }}</td>
                                            <td>{{ $item->section->name }}</td>
                                            <td class="center">{{ $item->address_1 }}</td>
                                            <td class="center">{!! $item->active
                                                ? '<span class="badge badge-success">Active</span>'
                                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                                            <td class="center">
                                                <div class="btn-group">
                                                    <a href="{{ route('students.show', $item->id) }}"
                                                        class="btn btn-info btn-sm"><i class="entypo-eye"></i> View</a>
                                                    @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                                        <a href="{{ route('students.edit', $item->id) }}"
                                                            class="btn btn-secondary btn-sm"><i class="entypo-pencil"></i>
                                                            Edit</a>
                                                    @endif
                                                </div>
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
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table> --}}
                            <div class="container">
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
                                    <div class="col-md-1 my-md-auto py-2">
                                        Gender
                                    </div>
                                    <div class="col-md-2 my-md-auto py-2">
                                        Class
                                    </div>
                                    <div class="col-md-1 my-md-auto py-2">
                                        Status
                                    </div>
                                    <div class="col-md-2 my-md-auto py-2">
                                        Action
                                    </div>
                                </div>
                                @foreach ($students as $item)
                                    <div class="row striped border py-3 text-center align-middle">
                                        <div class="col-md-1 my-md-auto my-1">
                                            <img width="100" height="100" src="{{ $item->avatar }}" alt="image"
                                                class="rounded">
                                        </div>
                                        <div class="col-md-3 my-md-auto my-1 font-weight-bold">
                                            <div class="text-secondary text-uppercase">{{ $item->full_name }}</div>
                                        </div>
                                        <div class="col-md-2 my-md-auto my-1 font-weight-bold">
                                            {{ $item->reg_no }}
                                        </div>
                                        <div class="col-md-1 my-md-auto my-1">
                                            {{ ucwords($item->gender) }}
                                        </div>
                                        <div class="col-md-2 my-md-auto my-2">
                                            {{ $item->school_class->name }} - {{ $item->section->name }}
                                        </div>
                                        <div class="col-md-1 my-md-auto my-1">
                                            {!! $item->active
                                                ? '<span class="badge badge-success">Active</span>'
                                                : '<span class="badge badge-danger">Inactive</span>' !!}
                                        </div>
                                        <div class="col-md-2 my-md-auto my-1">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('students.show', $item->id) }}"
                                                    class="btn btn-info btn-sm mr-1"> View</a>
                                                @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                                    <a href="{{ route('students.edit', $item->id) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        Edit</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="mt-4 d-flex justify-content-center">

                                {!! $students->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
    {{-- <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script> --}}

    <script>
        $('#class').change(function(e) {
            const class_id = e.target.value;
            console.log(class_id);
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections-by-class-name',
            }).done(function(data) {
                let html = '<option>Select Section</option>'
                data.sections.forEach(function(el) {
                    html += '<option value="' + el.name + '">' + el.name + '</option>'
                })


                $('#section').html(html);
                // show_loading_bar(100);
            });
        })

        function deleteStudent(e) {
            let r = confirm('Are you sure you want to delete')
            if (r) {
                $(e).parent().parent().find('#delete-student').submit()
            }
        }
    </script>
@endsection
