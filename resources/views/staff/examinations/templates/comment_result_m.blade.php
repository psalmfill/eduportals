<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $session->name . '' . $exam->name }} Result</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/bootstrap.css')}}"> --}}
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        #scale {
            width: 100%;
            border: 1px solid #333;
        }

        #scale tr td {
            border: 0;
        }

        #result {
            width: 1000px !important;
            border: 1px solid #333;
            color: #333;
            /* font-weight: bold !important; */
            margin: 3% auto;
            padding: 10px;
            width: 100%;
            font-size: 9pt;
            text-transform: capitalize
                /* white-space: nowrap; */
        }

        #result table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
        }

        #result td:first-child {
            border-left: 1px solid #333;
        }

        /* #result tr:first-child{
                border-left: 1px solid #333;
            } */
        #result td,
        #result th {
            font-weight: bold !important;
            border-top: 1px solid #333;
            border-right: 1px solid #333;
            margin: 0;
            padding: 5px;
        }

        #result table tr:last-child td {
            border-bottom: 1px solid #333;
        }

        #result table tr td:first-child {

            border-left: 1px solid #333;
        }

        #head {
            width: 100%;
            height: 100px;
            border: 1px solid #000;
        }

        #comments-table {
            width: 100%;
        }

        #comments-table td {
            padding: 10px;
        }

        #comments-table tr td:first-child {
            width: 400px;
        }

        #foot-logo {
            border: 0;
        }

        .col-8 {
            float: left;
            width: 69%;
        }

        .col-4 {
            width: 30%;
            float: right;
        }

        .text-center {
            text-align: center;
        }

        .row::after {
            content: '';
            display: block;
            clear: both;
        }

        .text-bold {
            font-weight: bold;
        }

        @media print {
            body {
                display: none;
                visibility: hidden;
            }
        }
    </style>
</head>

<body oncopy="return false" oncut="return false" onpaste="return false">
    <div id="result">

        <table id="head">
            <tr>
                <th style="width:20%"><img width="140" height="130" class="img-responsive"
                        src="{{ asset(\Storage::url(getSchool()->logo)) }}" alt="logo"></th>
                <th style="width:60%">
                    <div style="">
                        <h1>{{ $exam->school->name }}</h1>
                        <address>{{ $exam->school->address }}, {{ $exam->school->city }}</address>
                        <p>{{ $exam->school->country }}</p>
                    </div>
                </th>
                <th style="width:20%"><img width="130" height="130" class="img-100"
                        src="{{ asset(\Storage::url($student->image)) }}" alt="student"></th>
            </tr>
        </table>
        <br>
        <table style="width:100%">
            <tr>
                <td class="text-bold">Student Name</td>
                <td colspan="5" style="text-align:left">{{ $student->full_name }}</td>
                <td>Class</td>
                <td>{{ $student->school_class->name }} - {{ $student->section->name }}</td>
            </tr>
            <tr>
                <td>Admission Number</td>
                <td>{{ $student->reg_no }}</td>
                <td>Sex</td>
                <td>{{ $student->gender }}</td>
                <td>Session</td>
                <td>{{ $session->name }}</td>
                <td>Term</td>
                <td>{{ $exam->name }}</td>
            </tr>


        </table>
        <br>
        <h3 class="text-center">COGNITIVE ASSESSMENTS</h3>
        <div class="row">
            <div class="col-8">
                <table class="table table-bordere table-condense text-bold " id="table-4"
                    style="empty-cells:show;width:100%;">
                    <thead>
                        <tr>
                            <th>
                                <h3>KEYS</h3>
                                @foreach ($grades as $item)
                                    <p>{{ $item->name }} = {{ $item->remark }} </p>
                                @endforeach
                            </th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $group_id => $topics)
                            @php
                                $group = App\Models\CommentResultGroup::find($group_id);
                            @endphp
                            <tr>
                                <td>
                                    <h3 class="text-bold">{{ $group->title }}</h3>
                                </td>
                                <td></td>
                            </tr>
                            @foreach ($topics as $topic)
                                @php
                                    $t = App\Models\CommentResultItem::find($topic->comment_result_item_id);
                                @endphp
                                <tr>
                                    <td>{{ $t->title }}</td>
                                    <td class="text-center">{{ $topic->grade }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                @if ($psychomotor)
                    <table>
                        <tr>
                            <td>{{ $psychomotor->title }}</td>
                            <td class="text-center">Scale</td>
                        </tr>
                        @foreach ($psychomotor->subjects->sortBy('title') as $sub)
                            <tr>
                                <td>{{ $sub->title }}</td>
                                <td class="text-center">
                                    {{ App\Models\PsychomotorResult::getStudentPsychomotor($currentClass->id, null, $exam->id, $sub->title, $student->id)->grade }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <br>
                    <table class="table" id="scale">
                        <tr>
                            <td colspan="2" style="border-bottom:1px solid #333">Scale:</td>
                        </tr>
                        @foreach ($psychomotor->grades->chunk(2) as $chunk)
                            <tr>
                                @foreach ($chunk as $g)
                                    <td>{{ $g->name }} = {{ $g->remark }}</td>
                                    @if ($chunk->count() == 1)
                                        <td></td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </table>

                @endif
            </div>
        </div>
        <br>
        <table id="comments-table" style="margin:2px;width:99.5%">
            <tr>
                <td>Teacher Comments</td>
                <td>{{ $remark ? $remark->teacher : '' }}</td>
            </tr>
            <tr>
                <td>Principal/Head Teacher's Comments</td>
                <td>{{ $remark ? $remark->headmaster : '' }}</td>
            </tr>
            <tr>
                <td>Next Term Begins</td>
                <td>{{ $remark ? date('jS F, Y', strtotime($remark->next_term_begins)) : '' }}</td>
            </tr>
            <tr>
                <td>Next Term Fees</td>
                <td>N{{ $remark ? number_format($remark->next_term_fee) : '' }}</td>
            </tr>
        </table>
        <br>
        <table id="foot-logo" style="width:100%; margin:2px">
            <tr style="border:0px">
                <td style="border:0;"><img height="50" class="img-responsive"
                        src="{{ $generalSettings->coat_of_arm ? asset(\Storage::url($generalSettings->coat_of_arm)) : '' }}"
                        alt="coat of arm">
                    <h6>School Stamp</h6>
                </td>
                <td style="border:0;width:50%;text-align:center"><img height="50" class="img-responsive"
                        src="{{ $generalSettings->school_stamp ? asset(\Storage::url($generalSettings->school_stamp)) : '' }}"
                        alt="stamp">
                    <h6>Headmaster/Principal Signature</h6>
                </td>
                <td style="border:0;">
                    <div style="text-align:right">
                        <h5>Verify Result</h5>
                        <img src="data:image/png;base64, {!! $verifyUrlQrCode !!} ">
                    </div>
                </td>
            </tr>
        </table>
        <script>
            document.addEventListener('contextmenu', event => event.preventDefault());
        </script>
    </div>
</body>
