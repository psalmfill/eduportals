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
                Remarks
            </a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>All Remarks</h3>
            <div class="container-fluid p-3">


                <div class="row">
                    <div class="col-md-4">
                        <div class="well">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab2-1" data-toggle="tab"><span></span>
                                        {{ isset($section) ? 'Edit' : 'Create' }} Result Remarks
                                    </a>
                                </li>
                                @if (!isset($resultRemark))
                                    <li class="nav-item">
                                        <a class="nav-link" href="#tab2-2" data-toggle="tab"><span></span>Use
                                            Existing
                                            Data</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab2-1">

                                    @isset($resultRemark)
                                        <form action="{{ route('staff.result_remarks.update', $resultRemark->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="form-group">
                                                <label for="academic_session_id">Session</label>
                                                <select name="academic_session_id" id="academic_session_id"
                                                    class="form-control">
                                                    <option value="">Select Session</option>
                                                    @foreach ($academicSessions as $academicSession)
                                                        <option value="{{ $academicSession->id }}"
                                                            {{ $academicSession->id == $resultRemark->academic_session_id ? 'selected' : '' }}>
                                                            {{ $academicSession->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('academic_session_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exam_id">Exam</label>
                                                <select name="exam_id" id="exam" class="form-control">'
                                                    <option value="">Select Exam</option>
                                                    @foreach ($exams as $exam)
                                                        <option value="{{ $exam->id }}"
                                                            {{ $exam->id == $resultRemark->exam->id ? 'selected' : '' }}>
                                                            {{ $exam->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('exam_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="school_class_id">Classes</label>
                                                <select name="school_class_id" id="class" class="form-control">'
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $class)
                                                        <option value="{{ $class->id }}"
                                                            {{ $class->id == $resultRemark->school_class_id ? 'selected' : '' }}>
                                                            {{ $class->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('school_class_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="min_average">Min Average</label>

                                                <input type="number" value="{{ $resultRemark->min_average }}"
                                                    name="min_average" class="form-control">
                                                @error('min_average')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="max_average">Max Average</label>

                                                <input type="number" value="{{ $resultRemark->max_average }}"
                                                    name="max_average" class="form-control">
                                                @error('max_average')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="decision">Decision</label>

                                                <input type="text" value="{{ $resultRemark->decision }}" name="decision"
                                                    class="form-control">
                                                @error('decision')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="next_term_begins">Next Term Begins</label>

                                                <input type="date" value="{{ strtotime($resultRemark->next_term_begins) }}"
                                                    name="next_term_begins" class="form-control">
                                                @error('next_term_begins')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="next_term_fee">Next Term Fee</label>

                                                <input type="number" value="{{ $resultRemark->next_term_fee }}"
                                                    name="next_term_fee" class="form-control">
                                                @error('next_term_fee')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="headmaster">Principal/Head Teacher's Remark</label>

                                                <textarea class="form-control" name="headmaster" id="" cols="30" rows="4">{{ $resultRemark->headmaster }}</textarea>
                                                @error('headmaster')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="teacher">Teacher's Remark</label>

                                                <textarea class="form-control" name="teacher" id="" cols="30" rows="4">{{ $resultRemark->teacher }}</textarea>
                                                @error('teach
                                                    er')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit">Update</button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('staff.result_remarks.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="academic_session_id">Session</label>
                                                <select name="academic_session_id" value="{{ old('academic_session_id') }}"
                                                    id="" class="form-control">'
                                                    <option value="">Select Session</option>
                                                    @foreach ($academicSessions as $academicSession)
                                                        <option value="{{ $academicSession->id }}">
                                                            {{ $academicSession->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('academic_session_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exam_id">Exam</label>
                                                <select name="exam_id" id="exam" class="form-control">'
                                                    <option value="">Select Exam</option>
                                                    @foreach ($exams as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="school_class_id">Classes</label>
                                                <select name="school_class_ids[]" id="class" class="form-control"
                                                    multiple>
                                                    <option value="">Select Class</option>
                                                    @foreach ($classes as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('school_class_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="min_average">Min Average</label>

                                                <input type="number" name="min_average" class="form-control">
                                                @error('min_average')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="max_average">Max Average</label>

                                                <input type="number" name="max_average" class="form-control">
                                                @error('max_average')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="decision">Decision</label>

                                                <input type="text" name="decision" class="form-control">
                                                @error('decision')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="next_term_begins">Next Term Begins</label>

                                                <input type="date" name="next_term_begins" class="form-control">
                                                @error('next_term_begins')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="next_term_fee">Next Term Fee</label>

                                                <input type="number" name="next_term_fee" class="form-control">
                                                @error('next_term_fee')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="headmaster">Principal/Head Teacher's Remark</label>

                                                <textarea class="form-control" name="headmaster" id="" cols="30" rows="4"></textarea>
                                                @error('headmaster')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="teacher">Teacher's Remark</label>

                                                <textarea class="form-control" name="teacher" id="" cols="30" rows="4"></textarea>
                                                @error('teacher')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit">Create</button>
                                            </div>
                                        </form>
                                    @endisset
                                </div>

                                @if (!isset($resultRemark))
                                    <div class="tab-pane" id="tab2-2">
                                        <form action="{{ route('staff.result_remarks.existing') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="academic_session_id">Session</label>
                                                <select name="academic_session_id"
                                                    value="{{ old('academic_session_id') }}" id=""
                                                    class="form-control">'
                                                    <option value="">Select Session</option>
                                                    @foreach ($academicSessions as $academicSession)
                                                        <option value="{{ $academicSession->id }}">
                                                            {{ $academicSession->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('academic_session_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="current_academic_session_id">Current Session</label>
                                                <select name="current_academic_session_id"
                                                    value="{{ old('current_academic_session_id') }}" id=""
                                                    class="form-control">'
                                                    <option value="">Select Session</option>
                                                    @foreach ($academicSessions as $academicSession)
                                                        <option value="{{ $academicSession->id }}">
                                                            {{ $academicSession->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('current_academic_session_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="exam_id">Exam</label>
                                                <select name="exam_id" id="exam" class="form-control">'
                                                    <option value="">Select Exam</option>
                                                    @foreach ($exams as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="current_exam_id">Current Exam</label>
                                                <select name="current_exam_id" id="current_exam" class="form-control">'
                                                    <option value="">Select Exam</option>
                                                    @foreach ($exams as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="next_term_begins">Next Term Begins</label>

                                                <input type="date" name="next_term_begins" class="form-control">
                                                @error('next_term_begins')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="next_term_fee">Next Term Fee</label>

                                                <input type="number" name="next_term_fee" class="form-control">
                                                @error('next_term_fee')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-block" type="submit">Create From
                                                    Existing
                                                    Data</button>
                                            </div>
                                        </form>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        {{-- <script type="text/javascript">
                            jQuery(document).ready(function($) {
                                var $table4 = jQuery("#table-4");

                                $table4.DataTable();
                            });
                        </script> --}}
                        <div class="table-responsive">

                            <table class="table  table-bordered datatable dataTable no-footer" id="table-4"
                                style="white-space:nowrap">
                                <thead>
                                    <tr>
                                        <th>Session</th>
                                        <th>Exam</th>
                                        <th>Class</th>
                                        <th>Min Average</th>
                                        <th>Max Average</th>
                                        <th>Next Term Begins</th>
                                        <th>Next Term Fee</th>
                                        <th>Headmaster/Principal Remark</th>
                                        <th>Teacher's Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($resultRemarks as $item)
                                        <tr>
                                            <td>{{ $item->session->name }}</td>
                                            <td>{{ $item->exam->name }}</td>
                                            <td>{{ $item->school_class->name }}</td>
                                            <td>{{ $item->min_average }}</td>
                                            <td>{{ $item->max_average }}</td>
                                            <td>{{ $item->next_term_begins }}</td>
                                            <td>{{ $item->next_term_fee }}</td>
                                            <td>{{ $item->headmaster }}</td>
                                            <td>{{ $item->teacher }}</td>
                                            <td>
                                                <form action="{{ route('staff.result_remarks.destroy', $item->id) }}"
                                                    method="post" class="form-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <div>

                                                        <a href="{{ route('staff.result_remarks.edit', $item->id) }}"
                                                            class="btn btn-primary btn-sm icon-left  pull-left">
                                                            <i class="entypo-pencil"></i>
                                                            Edit
                                                        </a>
                                                        <button class="btn btn-danger btn-sm icon-left">
                                                            <i class="entypo-trash"></i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Session</th>
                                        <th>Exams</th>
                                        <th>Class</th>
                                        <th>Min Average</th>
                                        <th>Max Average</th>
                                        <th>Next Term Begins</th>
                                        <th>Next Term Fee</th>
                                        <th>Headmaster/Principal Remark</th>
                                        <th>Teacher's Remark</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div>
                                {{ $resultRemarks->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page_scripts')
    <script src="{{ asset('assets/js/datatables/datatables.js') }}"></script>
@endsection
