@extends('layouts.dashboard')

@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
    <style>
        #students-table {
            word-wrap: none;
        }

        .table>thead>tr>th {
            border: 1px solid #999;
        }

        .table>tbody>tr>td {
            border: 1px solid #eee;
            white-space: nowrap;
        }

        .table>tbody>tr>td.left-border {
            border-left: 1px solid #999;
        }

        .table>tbody>tr>td.right-border {
            border-right: 1px solid #999;
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
                Comments Result
            </a>
        </li>
    </ol>
@endsection
@section('content')

    <div class="card bg-dark">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-white">Filter Results</h3>
                    <form action="{{ route('staff.comment_results') }}" method="POST" class="form">
                        @csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="session" class="form-control input-lg">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $type)
                                            <option value="{{ $type->id }}"
                                                {{ isset($session) && $session->id == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="exam" class="form-control input-lg" required>

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
                <h2>Students</h2>
                <div class="row">
                    <div class="col-md-7">
                        {{-- <form action="{{route('staff.examination.psychomotor.result.store')}}" id="result" method="POST">
            @csrf --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table border="1" class="table table-borderless table-condensd" id="students-table">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">S/N</th>
                                                <th rowspan="2">Reg No.</th>
                                                <th rowspan="2">Student Name</th>
                                                <th>Action</th>
                                            </tr>
                                            <tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td class="left-border">{{ $loop->index + 1 }}</td>
                                                    <td>{{ $student->reg_no }}</td>
                                                    <td class="right-border">{{ $student->full_name }}</td>
                                                    <td><button
                                                            data-src="{{ route('staff.comment_results.upload', [
                                                                'student_id' => $student->id,
                                                                'session_id' => $session->id,
                                                                'exam_id' => $exam->id,
                                                                'class_id' => $currentClass->id,
                                                                'section_id' => $currentSection,
                                                            ]) }}"
                                                            class="btn btn-primary upload">Upload</a></td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <iframe id="result" style="width:100%;height:100vh;border:0" title="Inline Frame Example">
                        </iframe>

                    </div>
                </div>
            </div>
        </div>
    @endisset
@endsection
@section('page_scripts')
    <script>
        $('#class').change(function(e) {
            // show_loading_bar(30)
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
        });
        $('.upload').click(function(el) {
            // show_loading_bar(30)
            el.preventDefault();
            let src = $(this).data('src');
            $('#result').attr('src', src)

        })
        $('#result').load(function() {
            // show_loading_bar(100);
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 'slow');
        })
    </script>
@endsection
