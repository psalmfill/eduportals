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
                View Attendance
            </a>
        </li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3>Filter Result</h3>
            <form action="" method="GET" class="form">
                {{-- @csrf --}}
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

                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="term" id="" class="form-control input-lg">
                                <option value="">Select Term</option>
                                @foreach ($terms as $term)
                                    <option value="{{ $term->id }}"
                                        {{ isset($currentTerm) && $currentTerm->id == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }}</option>
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
                                            {{ $sec->id == $currentSection->id ? 'selected' : '' }}>{{ $sec->name }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Select Section</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="month" id="" class="form-control input-lg">

                                @foreach ($months as $item)
                                    <option value="{{ $item }}"
                                        @isset($month) {{ $month == $item ? 'selected' : '' }}@endisset>
                                        {{ $item }}</option>
                                @endforeach

                            </select>
                            @error('month')
                                <div>
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <h2>Attendance</h2>
            <hr>
            @isset($students)
                @if ($students->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table-condensed datatable" id="table-4"
                                    style="empty-cells:show">
                                    <thead>
                                        <tr>
                                            <th rowspan="">S/N</th>
                                            <th rowspan="">Reg No</th>
                                            <th rowspan="">Name</th>

                                            @php
                                                $attend = App\Models\Attendance::where([['school_id', '=', getSchool()->id], ['academic_session_id', '=', $currentSession->id], ['term_id', '=', $currentTerm->id]])
                                                    ->whereMonth('date', date_parse($month)['month'])
                                                    ->first();
                                                $days = \Carbon\Carbon::createFromDate($attend->date)->daysInMonth;
                                            @endphp

                                            @for ($i = 1; $i <= $days; $i++)
                                                <td>{{ $i }}</td>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $item->reg_no }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                {{-- <td>
                                                    @php
                                                        $attendances = App\Models\Attendance::studentMonthAttendance($item->id, $currentSession->id, $currentTerm->id, $month);
                                                    @endphp>
                                            </td> --}}
                                                @for ($i = 1; $i <= $days; $i++)
                                                    @php
                                                        // $attendance = App\Models\Attendance::studentDayAttendance($item->id, $currentSession->id, $currentTerm->id, $month, $i);
                                                        // dd($attendance);
                                                        $at = App\Models\Attendance::getAttendance($item->id, date('m/d/Y', strtotime($month . ' ' . $i . ' ' . $attend->created_at->year)));
                                                    @endphp
                                                    @if ($at)
                                                        <td
                                                            class="{{ $at->present ? 'bg-success' : ($at->holiday ? 'bg-info' : 'bg-danger') }}">
                                                            {{ $at->present ? 'P' : ($at->holiday ? 'H' : 'A') }}</td>
                                                    @else
                                                        <td>NA</td>
                                                    @endif
                                                @endfor
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <br />
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">No Result Available at the moment.</div>
                @endif
            @endisset
        </div>
    </div>
@endsection
@section('page_scripts')
    <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
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
    </script>
@endsection
