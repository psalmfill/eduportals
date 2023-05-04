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
            <div class="d-flex justify-content-end">
                <a href="{{ route('staff.cbt.subjects') }}" class="btn btn-secondary">Manage Subjects</a>
            </div>
        </div>
    </div>
    @isset($students)
        <div class="card">
            <div class="card-body">
                <h1>CBT</h1>
                <h3>Subjects</h3>
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
                                            'copyHtml5',
                                            'excelHtml5',
                                            'csvHtml5',
                                            'pdfHtml5'
                                        ]
                                    });
                                });
                            </script>

                            <table class="table table-bordered datatable mt-4" id="table-4">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Subject Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $item)
                                        <tr class="">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td class="center">{!! $item->active
                                                ? '<span class="badge badge-success">Active</span>'
                                                : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                                            <td class="center">
                                                <form
                                                    action="{{ route('staff.hostel_rooms.evictStudent', [$room->hostel->id, $room->id]) }}"
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
                                        <th>Subject Name</th>
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
