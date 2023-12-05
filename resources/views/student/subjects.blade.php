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
    <div class="card">
        <div class="card-header">
            <h2>My Subjects</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 table-responsive">

                    <table class="table table-sm  table-bordered datatable dataTable no-footer" id="table-4">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Teacher - Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $item)
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
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($item->teachers(user()->school_class_id, user()->section_id) as $teacher)
                                                <li>{{ $teacher->name }} - {{ $teacher->phone_number }}</li>
                                            @endforeach
                                        </ul>
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
