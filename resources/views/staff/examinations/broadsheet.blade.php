@extends('layouts.dashboard')

@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
    <style>
        #table-4 tr th,
        #table-4 tr td {
            border: 1px solid #000;
            color: #000;
        }
    </style>
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
                Marks Register
            </a>
        </li>
    </ol>
@endsection
@section('content')

    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Result</h3>
                    <form action="{{ route('staff.broadsheet-results.view') }}" method="POST" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="session" id="" class="form-control input-lg">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}"
                                                {{ isset($currentSession) && $currentSession->id == $session->id ? 'selected' : '' }}>
                                                {{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="exam" id="" class="form-control input-lg" required>

                                        <option value="">Select Exam</option>
                                        @foreach ($exams as $type)
                                            <option value="{{ $type->id }}"
                                                {{ isset($exam) && $exam->id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="class" id="class" class="form-control input-lg" required>
                                        <option value="">Select Class</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ isset($currentClass) && $currentClass->id == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="section" id="section" class="form-control input-lg" required>
                                        @isset($sections)
                                            @foreach ($sections as $sec)
                                                <option value="{{ $sec->id }}"
                                                    {{ $sec->id == $currentSection->id ? 'selected' : '' }}>
                                                    {{ $sec->name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="">Select Section</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                <h2>Broadsheet data</h2>
                <hr>
                @if ($students->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-condensed datatable" id="table-4">
                                    <thead>

                                        <tr>
                                            <td class="text-center"
                                                colspan="{{ 6 + ($exam->exam_types->count() + 2) * $subjects->count() }}">
                                                <div>
                                                    <h2>{{ $exam->school->name }}</h2>
                                                    <p>{{ $exam->school->address }}, {{ $exam->school->city }}</< /p>
                                                    <p>{{ $exam->school->state }}, {{ $exam->school->country }}</< /p>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th colspan="5" class="text-center">Students</th>
                                            <th class="text-center">Class Average : {{ $classAverage }}</th>
                                            @foreach ($subjects as $subject)
                                                <th class="text-center" colspan="{{ $exam->exam_types->count() + 2 }}">
                                                    {{ $subject->name }} ({{ $exam->total_mark }})</th>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th rowspan="">S/N</th>
                                            <th rowspan="">Reg No</th>
                                            <th rowspan="">Name</th>
                                            <th>Total</th>
                                            <th>Position</th>
                                            <th>Student Average</th>
                                            <?php $subCount = $subjects->count(); ?>
                                            @while ($subCount > 0)
                                                @foreach ($exam->exam_types as $item)
                                                    <th class="text-center">{{ $item->name }} <br>({{ $item->mark }})</th>
                                                @endforeach
                                                <th>Total <br> ({{ $exam->total_mark }})</th>
                                                <th>Pos</th>
                                                <?php $subCount--; ?>
                                            @endwhile
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            @php
                                                $results = $markstore->where('student_id', $item->id);
                                                $totalScore = $results->sum('score');
                                                $subjectsOffered = $subjects->whereIn('id', $results->pluck('subject_id')->unique())->sortBy('name');
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->reg_no }}</td>
                                                <td>{{ $item->full_name }}</td>

                                                <td>{{ $totalScore }}
                                                </td>
                                                <td>{!! getClassPosition($markstore, $item->id) !!}</td>

                                                <td>
                                                    {{ $totalScore ? number_format($totalScore / $subjectsOffered->count(), 2) : '-' }}
                                                </td>

                                                @foreach ($subjects as $subject)
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($exam->exam_types as $type)
                                                        @php
                                                            $mark = $markstore
                                                                ->where('exam_type_id', $type->id)
                                                                ->where('subject_id', $subject->id)
                                                                ->where('student_id', $item->id)
                                                                ->first();
                                                            $total += $mark ? $mark->score : 0;
                                                        @endphp
                                                        <td class="text-center">
                                                            {{ $mark && !$mark->absent ? $mark->score : '-' }}</td>
                                                    @endforeach
                                                    <td class="text-center">
                                                        {{ $total != 0 && $mark && !$mark->absent && !$mark->not_offered ? $total : '-' }}
                                                    </td>
                                                    <td class="text-center">{!! $total != 0 && $mark && !$mark->absent && !$mark->not_offered
                                                        ? getSubjectPosition($markstore, $item->id, $subject->id)
                                                        : '-' !!}</td>
                                                @endforeach

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <br /> <a
                                href="{{ route('staff.results.download', [
                                    'session_id' => $currentSession->id,
                                    'exam_id' => $exam->id,
                                    'class_id' => $currentClass->id,
                                    'section_id' => $currentSection->id,
                                ]) }}"
                                class="btn btn-success pull-right ">Download as PDF</a>

                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">No Result Available at the moment.</div>
                @endif

            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
    {{-- <script src="{{asset('assets/js/datatables/datatables.js')}}"></script> --}}
    <script>
        $('#class').change(function(e) {
            const class_id = e.target.value;
            console.log(class_id);
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
        $('#section').change(function(e) {
            const section_id = e.target.value;
            const class_id = $('#class').val();
            // show_loading_bar(65);
            //fetch class sections
            $.ajax({

                url: BASE_URL + "/api/classes/" + class_id + '/sections/' + section_id + "/subjects",
            }).done(function(data) {
                console.log(data)
                let html = '<option>Select Subject</option>'
                data.forEach(function(el) {
                    html += '<option value="' + el.id + '">' + el.name + '</option>'
                })


                $('#subject').html(html);
                // show_loading_bar(100);
            });
        })
    </script>
@endsection
