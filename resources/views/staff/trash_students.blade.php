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
        <li>
            <a href="#">
                <i class="entypo-users"></i>
                Trash
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('staff.students.trash.empty') }}" method="post" class="form">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="var c= confirm('Are you sure you want to clear trash?'); if(!c) return false"
                    class="btn btn-danger"><i class="entypo-trash"></i> Clear Trash</button>
                <br><br>
                <small class="alert alert-warning d-block">
                    This action is irreversible and will remove all records concerning a student from the system
                </small>
            </form>
        </div>
    </div>
    @isset($students)
        <div class="row">
            <div class="col-md-12">

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
                            <th>Reg. No</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $item)
                            <tr class="odd gradeX">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $item->reg_no }}</td>
                                <td class="text-center"> <img width="100" height="100" src="{{ $item->avatar }}"
                                        alt="image" class="img-fluid">
                                </td>
                                <td>{{ $item->full_name }}</td>
                                <td>{{ ucwords($item->gender) }}</td>
                                <td>{{ $item->school_class->name }}</td>
                                <td>{{ $item->section->name }}</td>
                                <td class="center">{{ $item->address_1 }}</td>
                                <td class="center">
                                    <div class="btn-group">
                                        <a href="{{ route('students.show', $item->id) }}" class="btn btn-info"><i
                                                class="entypo-eye"></i> View</a>
                                        @if (!(user() instanceof \App\Models\Staff || user() instanceof \App\Models\Student))
                                            <a href="{{ route('students.edit', $item->id) }}" class="btn btn-blue"><i
                                                    class="entypo-pencil"></i> Edit</a>

                                            {{-- <a href="javascript:void()" class="btn btn-danger" onclick="deleteStudent(this)"><i class="entypo-trash"></i> Delete</a> --}}
                                        @endif
                                    </div>
                                    {{-- <form action="{{route('staff.deleteStudent')}}" id="delete-student" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <input type="hidden" name="student_id" value="{{$item->id}}">
                                    </form>
                                </td> --}}
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
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
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
