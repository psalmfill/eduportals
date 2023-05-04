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
    @isset($students)
        <div class="card">
            <div class="card-body">
                <h1>Hostel Management</h1>
                <h3>Students in {{ $hostel->name }}
                    @isset($room)
                        {{ $room->name }}
                    @endisset
                </h3>
                @isset($room)
                    <form action="{{ route('staff.hostel_rooms.assignStudent', [$room->hostel->id, $room->id]) }}" method="POST"
                        class="form">
                        @csrf
                        <div class="d-flex justify-content-end">
                            <div class="col-md-3">
                                <input type="text" name="reg_no" class="form-control form-control-sm"
                                    placeholder="Student Admission Number">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block">Assign Student</button>
                            </div>
                        </div>
                    </form>
                @endisset

                <div class="row">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <br />
                            <script type="text/javascript">
                                jQuery(document).ready(function($) {
                                    var $table4 = jQuery("#table-4");

                                    $table4.DataTable({
                                        dom: 'Bfrtip',
                                        buttons: [
                                            // 'copyHtml5',
                                            // 'excelHtml5',
                                            // 'csvHtml5',
                                            // 'pdfHtml5'
                                        ]
                                    });
                                });
                            </script>

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
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $item)
                                        <tr class="">
                                            <td>{{ $loop->index + 1 }}</td>
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
                                                <form
                                                    action="{{ route('staff.hostel_rooms.evictStudent', [$item->hostel_room->hostel_id, $item->hostel_room_id]) }}"
                                                    method="POST" class="form">
                                                    @csrf
                                                    <input type="hidden" name="reg_no" class="form-control form-control-sm"
                                                        value={{ $item->reg_no }}>

                                                    <div class="btn-group">
                                                        <a href="{{ route('students.show', $item->id) }}"
                                                            class="btn btn-info btn-sm"><i class="entypo-eye"></i> View</a>
                                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                                            <button class="btn btn-danger btn-sm"><i class="entypo-trash"></i>
                                                                Evict</button>

                                                            {{-- <a href="javascript:void()" class="btn btn-danger" onclick="deleteStudent(this)"><i class="entypo-trash"></i> Delete</a> --}}
                                                        @endif
                                                    </div>
                                                </form>
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
                            </table>
                        </div>
                    </div>
                </div>
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
