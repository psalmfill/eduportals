@extends('layouts.student')

@section('page_styles')
    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/datatables.css') }}">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #result,
            #result * {
                visibility: visible;
            }

            #result {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        #scale tr td {
            border: 0;
        }

        #result {
            width: 900px;
            border: 1px solid #000;
            color: #000;
            font-weight: bold !important;
        }

        #result table {
            box-sizing: border-box;
        }

        #result td,
        #result th {
            border-top: 1px solid #000000;
            font-weight: bold !important;
            border-bottom: 1px solid #000000;
        }

        .col-8 {
            width: 580px;
            float: left;
            margin-left: 1.8%;
            box-sizing: border-box;
        }

        .col-4 {
            width: 300px;
            float: left;
            margin-left: 1%;
            margin-right: 1%
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
                    <h3 class="text-white">Select Result</h3>
                    <form action="{{ route('student.result.fetch') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" name="section" value="{{ user()->section_id }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="session" class="form-control input-lg">
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->name }}</option>
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
                                    <select name="type" id="type" class="form-control input-lg" required>
                                        <option value="">Select Result Type</option>
                                        @foreach ($resultTypes as $type)
                                            <option value="{{ $type }}">{{ ucwords($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="pin_code" class="form-control form-control-sm"
                                    placeholder="Pin Code">
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-block btn-sm">Check Result</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 table-responsive">

                    <table class="table table-sm  table-bordered datatable dataTable no-footer" id="table-4">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Session</th>
                                <th>Term</th>
                                <th>Class</th>
                                <th>Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pins as $item)
                                {{-- @php
                                    dd(
                                        $item,
                                        $item->update([
                                            'academic_session_id' => null,
                                            'exam_id' => null,
                                            'trial' => 1,
                                            'student_id' => null,
                                            'school_class_id' => null,
                                            'section_id' => null,
                                            'result_type' => null,
                                        ]),
                                    );
                                @endphp --}}
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $item->session ? $item->session->name : '' }}</td>
                                    <td>{{ $item->exam ? $item->exam->name : '' }}</td>
                                    <td>{{ $item->school_class ? $item->school_class->name : '' }}</td>
                                    <td>
                                        <form action="{{ route('student.result.fetch') }}" method="POST" class="form">
                                            @csrf
                                            <input type="hidden" name="pin_code" value="{{ $item->code }}">
                                            <input type="hidden" name="exam" value="{{ $item->exam_id }}">
                                            <input type="hidden" name="type" value="{{ $item->result_type }}">
                                            <input type="hidden" name="session" value="{{ $item->academic_session_id }}">
                                            <input type="hidden" name="class" value="{{ $item->school_class_id }}">
                                            <input type="hidden" name="section" value="{{ $item->section_id }}">
                                            <button class="btn btn-primary">Download</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
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
    </script>
@endsection
