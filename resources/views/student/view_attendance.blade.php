@extends('layouts.student')

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
    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Result</h3>
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
                            {{-- <div class="col-md-2">
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
                    </div> --}}
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
                                <button class="btn btn-primary btn-block btn-sm"><i class="entypo-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @isset($student)
        <div class="card">
            <div class="card-body">

                <h2>Attendance ({{ $month }} {{ $currentSession->name }})</h2>
                <div class="d-flex justify-content-end">
                    <div class="card badge-warning p-4 border">
                        Holiday
                    </div>
                    <div class="card badge-success p-4 border">
                        Present
                    </div>
                    <div class="card  p-4 border">
                        Absent
                    </div>

                    <div class="card badge-light p-4 border">
                        Weekend
                    </div>
                </div>
                <hr>
                @php
                    $dat = \Carbon\Carbon::createFromDate($month);
                    $s = $dat->firstOfMonth()->format('l');
                    $days = $dat->daysInMonth;
                    $attend = $attendances->first();
                    $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                @endphp
                <div class="row text-center">

                    {{-- @foreach ($daysOfWeek as $d)
                        <div class="col-md-2 border p-4">
                            <h3>{{ $d }}</h3>
                        </div>
                    @endforeach --}}

                    @for ($i = 1; $i <= $days; $i++)
                        @php
                            // $attendance = App\Models\Attendance::studentDayAttendance($item->id, $currentSession->id, $currentTerm->id, $month, $i);
                            $at = $attend ? App\Models\Attendance::getAttendance($student->id, date('m/d/Y', strtotime($month . ' ' . $i . ' ' . $attend->created_at->year))) : null;
                            
                        @endphp

                        <div
                            class="col-md-2 border p-4 {{ in_array(date('l', strtotime($month . ' ' . $i)), ['Saturday', 'Sunday']) ? 'bg-light' : '' }} {{ ($at and $at->present) ? 'bg-success' : (($at and $at->holiday) ? 'bg-warning' : '') }}">
                            <div class=" pointer">

                                <h3>{{ $i }}</h3>
                                <div>{{ date('l', strtotime($month . ' ' . $i)) }}</div>
                            </div>
                        </div>
                    @endfor

                </div>
            </div>
        </div>
    @endisset
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
