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
                    <form action="{{ route('staff.marks_register') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" name="session" value="{{ getSettings()->current_session_id }}">
                        <div class="row">
                            {{-- <div class="col-md-2">
                                <div class="form-group">
                                    <select name="session" id="" class="form-control input-lg" required>
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}"
                                                {{ isset($currentSession) && $currentSession->id == $session->id ? 'selected' : '' }}>
                                                {{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                                            <option>Select Section</option>
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="subject" id="subject" class="form-control input-lg" required>
                                        @isset($subjects)
                                            @foreach ($subjects as $sub)
                                                <option value="{{ $sub->id }}"
                                                    {{ $sub->id == $subject->id ? 'selected' : '' }}>
                                                    {{ $sub->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="">Select Subject</option>
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
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('staff.marks_register.postmarks') }}" method="post">
                            @csrf
                            <input type="hidden" name="subject" value="{{ $subject->id }}">
                            <input type="hidden" name="exam" value="{{ $exam->id }}">
                            <input type="hidden" name="class" value="{{ $currentClass->id }}">
                            <input type="hidden" name="section" value="{{ $currentSection->id }}">
                            <input type="hidden" name="subject" value="{{ $subject->id }}">
                            <input type="hidden" name="session" value="{{ $currentSession->id }}">
                            {{-- <input type="hidden" name="session" value="1"> --}}
                            <br>
                            <fieldset>
                                <div class="table-responsive">
                                    <table class="table table-bordered" border="0" id="table-4" style="empty-cells:show">
                                        <thead>
                                            <tr>
                                                <th rowspan="">S/N</th>
                                                <th rowspan="">Reg No</th>
                                                <th rowspan="">Student</th>
                                                <th class="text-center" colspan="{{ $exam->exam_types->count() }}">
                                                    {{ $subject->name }} ({{ $exam->total_mark }})</th>
                                                <th rowspan="">Was Absent</th>
                                                <th rowspan="">Not Offered</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3"></td>
                                                @foreach ($exam->exam_types as $item)
                                                    <th>{{ $item->name }} ({{ $item->mark }})</th>
                                                @endforeach
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $item)
                                                <tr>
                                                    <td>{{ $loop->index + 1 }}</td>
                                                    <td>{{ $item->reg_no }}</td>
                                                    <td>{{ $item->full_name }}</td>
                                                    @foreach ($exam->exam_types as $type)
                                                        @php
                                                            $mark = App\Models\MarkStore::getMark($exam->id, $type->id, $subject->id, $currentSession->id, $currentClass->id, $item->id, $currentSection->id);
                                                        @endphp
                                                        <td>
                                                            <input type="number"
                                                                name="students[{{ $item->id }}][mark][{{ $type->id }}]"
                                                                min="0" max="{{ $type->mark }}" class="form-control"
                                                                value="{{ $mark ? $mark->score : '' }}">
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="checkbox color-green checkbox-replace">
                                                                <input type="checkbox" class="mt-1"
                                                                    name="students[{{ $item->id }}][absent]"
                                                                    {{ App\Models\MarkStore::isAbsent($exam->id, $type->id, $subject->id, $currentSession->id, $currentClass->id, $item->id, $currentSection->id) ? 'checked' : '' }}
                                                                    id="">
                                                                <label>Absent</label>
                                                            </div>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="checkbox color-green checkbox-replace">
                                                                <input type="checkbox" class="mt-1"
                                                                    name="students[{{ $item->id }}][not_offered]"
                                                                    {{ App\Models\MarkStore::notOffered($exam->id, $type->id, $subject->id, $currentSession->id, $currentClass->id, $item->id, $currentSection->id) ? 'checked' : '' }}
                                                                    id="">
                                                                <label>Not Offered</label>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="{{ 4 + $exam->exam_types->count() }}">
                                                    <a href="javascript:void()" class="btn btn-light"
                                                        onclick="clearMarks(this)"><i class="entypo-trash"></i> Clear Mark</a>

                                                    <button class="btn btn-success pull-right ">Save Result</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <form id="clear-marks-form" action="{{ route('staff.marks_register.clearmarks') }}" method="POST">
                        @csrf
                        <input type="hidden" name="subject" value="{{ $subject->id }}">
                        <input type="hidden" name="exam" value="{{ $exam->id }}">
                        <input type="hidden" name="class" value="{{ $currentClass->id }}">
                        <input type="hidden" name="section" value="{{ $currentSection->id }}">
                        <input type="hidden" name="subject" value="{{ $subject->id }}">
                        <input type="hidden" name="session" value="{{ $currentSession->id }}">
                    </form>
                </div>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
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

        function clearMarks(e) {
            let r = confirm('Are you sure you want to clear marks. \nThis action is irreversible')
            if (r) {
                $(document).find('#clear-marks-form').submit()
            }
        }
    </script>
@endsection
