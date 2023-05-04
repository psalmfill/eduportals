<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/typicons.font/font/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-icons/entypo/css/entypo.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />


</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                @if (\Session::has('message'))
                    <div class="alert alert-success">
                        {{ \Session::get('message') }}
                    </div>
                @endif
                @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        {{ \Session::get('error') }}
                    </div>
                @endif
            </div>
        </div>
        <form action="{{ route('staff.comment_result.store') }}" method="POST">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <input type="hidden" name="exam_id" value="{{ $exam->id }}">
            <input type="hidden" name="school_class_id" value="{{ $currentClass->id }}">
            <input type="hidden" name="section_id" value="{{ $currentSection->id }}">
            <input type="hidden" name="session_id" value="{{ $session->id }}">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>
                            <h4>Student:</h4>
                        </th>
                        <th colspan="{{ $commentGrades->count() }}" class="text-bold">
                            <h4>{{ $student->full_name }}</h4>
                        </th>
                    <tr>
                        <th>
                            <h4>Class</h4>
                        </th>
                        <th colspan="{{ $commentGrades->count() }}">
                            <h4>{{ $student->school_class->name }}</h4>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">Subject</th>
                        <th colspan="{{ $commentGrades->count() }}">Grade</th>
                    </tr>
                    <tr>
                        @foreach ($commentGrades as $item)
                            <th>{{ $item->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commentGroups as $group)
                        <tr>
                            <td colspan="2">
                                <h4>{{ $group->title }}</h4>
                            </td>
                        </tr>
                        @foreach ($group->topics as $topic)
                            <tr>
                                <td>{{ $topic->title }}</td>
                                @foreach ($commentGrades as $item)
                                    @php
                                        $mark = App\Models\CommentResult::getMark(getSchool()->id, $session->id, $exam->id, $currentClass->id, $currentSection->id, $group->id, $topic->id, $student->id);
                                    @endphp
                                    <td><input type="radio"
                                            name="groups[{{ $group->id }}][topics][{{ $topic->id }}]"
                                            value="{{ $item->id }}" required
                                            {{ $mark && $mark->comment_result_grade_id == $item->id ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            @php
                $remark = App\Models\CommentResultRemark::getRemark(getSchool()->id, $session->id, $exam->id, $currentClass->id, $currentSection->id, $student->id);
            @endphp
            <div class="mt-4">
                <div class="form-group">
                    <label for="teacher">Teacher Remarks</label>
                    <input type="text" name="teacher" value="{{ $remark ? $remark->teacher : '' }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="headmaster">Principal Remarks</label>
                    <input type="text" name="headmaster" value="{{ $remark ? $remark->headmaster : '' }}"
                        class="form-control">
                </div>
                <div class="form-group">
                    <label for="next_term_begins">Next Term Begins</label>
                    <input type="date" name="next_term_begins"
                        value="{{ $remark ? $remark->next_term_begins : '' }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="next_term_fee">Next Term Fee</label>
                    <input type="number" name="next_term_fee" value="{{ $remark ? $remark->next_term_fee : '' }}"
                        class="form-control">
                </div>
            </div>
            <button class="btn btn-primary btn-block">Upload</button>
        </form>
    </div>

</body>

</html>
