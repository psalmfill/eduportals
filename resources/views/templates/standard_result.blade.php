<!DOCTYPE html>
<html lang="en">

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
            text-transform: uppercase;
            font-size: 0.97em;
            padding: 0;
        }

        #scale {
            width: 100%;
            border: 1px solid #333;
        }

        #scale tr td {
            border: 0;
        }

        #result {
            /* background-image: url({{ getSchool()->logo ? public_path(\Storage::url(getSchool()->logo)) : '' }}); */
            background-repeat: no-repeat;
            background-position: center;
            background-color: rgba(255, 255, 255, 0.8);
            background-blend-mode: lighten;
            background-size: 60%;
            width: 100%;
            border: 1px solid #333;
            color: #333;
            /* font-weight: bold !important; */
            margin: 1%;
            padding: 1%;
            width: 100%;
            font-size: 9pt;
            text-transform: capitalize
                /* white-space: nowrap; */
        }

        #result table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
            width: 100%;
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
            padding: 2px;
        }

        #result table tr:last-child td {
            border-bottom: 1px solid #333;
        }

        #result table tr td:first-child {

            border-left: 1px solid #333;
        }

        #head {
            width: 100%;
            height: 80px;
            border: 1px solid #000;
        }

        #comments-table {
            width: 100%;
        }

        #comments-table td {
            padding: 2px;
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
    </style>
</head>

<body>
    <div id="result">

        <table id="head">
            <tr>
                <th style="width:20%"><img width="140" height="130" class="img-responsive"
                        src="{{ getSchool()->logo ? public_path(\Storage::url(getSchool()->logo)) : '' }}"
                        alt="logo">
                </th>
                <th style="width:60%">
                    <div>
                        <h1 style="font-size:18px">{{ $exam->school->name }}</h1>
                        <address>{{ $exam->school->address }}, {{ $exam->school->city }}</address>
                        <p>{{ $exam->school->country }}</p>
                    </div>
                </th>
                <th style="width:20%"><img width="130" height="130" class="img-100"
                        src="{{ $student->image ? public_path(\Storage::url($student->image)) : '' }}" alt="student">
                </th>
            </tr>
        </table>
        <br>
        <table style="width:100%">
            <tr>
                <td class="text-bold">Student Name</td>
                <td colspan="5" style="text-align:left">{{ $student->full_name }}</td>
                <td>Class</td>
                <td>{{ $currentClass->name }} - {{ $section->name }}</td>
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

            <tr>
                <td>Total Marks Obtained</td>
                <td>{{ $total_mark }}/{{ $exam->total_mark * $subjects->count() }}</td>
                <td colspan="2">Student Average</td>
                <td colspan="2">{{ $studentAverage }}</td>
                <td>Class Average</td>
                <td>{{ $classAverage }}</td>
            </tr>

            <tr>
                <td>Number in class</td>
                <td>{{ $total_students }}</td>
                <td colspan="2">Class position</td>
                <td colspan="2">{!! ordinalSuffix($position, 1) !!}</td>
                <td>Decision</td>
                <td>{{ $remark ? $remark->decision : '' }}</td>
            </tr>
        </table>
        <br>
        <div class="row">
            <div class="col-8">
                <table class="table table-bordere table-condense text-bold " id="table-4" style="empty-cells:show">
                    <tr>
                        <td rowspan="">Subject</td>
                        @foreach ($exam->exam_types as $item)
                            <td class="text-center">{{ $item->name }} <br>({{ $item->mark }}%)</td>
                        @endforeach
                        <td class="text-center">Total <br>({{ $exam->total_mark }}%)</td>
                        <td class="text-center">Grade</td>
                        <td class="text-center">Position</td>
                        {{-- <td class="text-center">Remark</td> --}}
                    </tr>
                    @foreach ($subjects as $subject)
                        <?php
                        $total = 0;
                        $isAbsent = true;
                        $notOffered = true;
                        ?>

                        <tr>
                            <td>{{ $subject->name }}</td>
                            {{-- <td>{{$item->full_name}}</td> --}}
                            @foreach ($exam->exam_types as $type)
                                @php
                                    $mark = App\Models\MarkStore::getMark($exam->id, $type->id, $subject->id, $session->id, $currentClass->id, $student->id, $section->id);
                                    $total += $mark ? $mark->score : 0;
                                    if ($mark) {
                                        $isAbsent = $mark->absent;
                                        $notOffered = $mark->not_offered;
                                    }
                                    $grade = App\Models\Grade::getGrade($total);
                                    
                                @endphp
                                <td class="text-center">{{ $mark && !$mark->absent ? $mark->score : '-' }}</td>
                            @endforeach
                            @php
                                $subPosition = App\Models\MarkStore::getSubjectPosition($exam->id, $subject->id, $session->id, $currentClass->id, $student->id, $section->id);
                            @endphp
                            <td class="text-center">{{ $isAbsent || $notOffered ? '' : $total }}</td>
                            <td class="text-center">{{ $grade && !$isAbsent && !$notOffered ? $grade->name : '' }}
                            </td>
                            <td class="text-center">{!! !$isAbsent && !$notOffered ? $subPosition : '' !!}</td>
                            {{-- <td class="text-center">{{ $grade && !$isAbsent ? $grade->remark : '-' }}</td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <br><br>

                <table class="table" style="width:50%">
                    <tr>
                        <td style="border-bottom:1px solid #333">Grading</td>
                        <td style="border-bottom:1px solid #333">Interpretation</td>
                    </tr>
                    @foreach ($grades->chunk(2) as $chunk)
                        @foreach ($chunk as $g)
                            <tr>
                                <td>{{ $g->name }} = {{ $g->minimum_score }} - {{ $g->maximum_score }}</td>

                                <td>{{ $g->remark }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
            <div class="col-4">
                @if ($affectiveTrait)
                    <table>
                        <tr>
                            <td>{{ $affectiveTrait->title }}</td>
                            <td class="text-center">Scale</td>
                        </tr>
                        @foreach ($affectiveTrait->subjects->sortBy('title') as $sub)
                            <tr>
                                <td>{{ $sub->title }}</td>
                                <td class="text-center">
                                    @php
                                        // $ps = App\Models\PsychomotorResult::getStudentPsychomotor($currentClass->id, null, $exam->id, $sub->title, $student->id);
                                        $ps = $affectiveTraitResult
                                            ->where('student_id', $student->id)
                                            ->where('subject', $subject->title)
                                            ->first();
                                        
                                    @endphp
                                    {{ $ps ? $ps->grade : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <br>
                    <table class="table" id="scale">
                        <tr>
                            <td colspan="2">{{ $affectiveTrait->title }} Scale:
                            </td>
                        </tr>
                        @foreach ($affectiveTrait->grades->chunk(2) as $chunk)
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
                <br>
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
                                    @php
                                        // $ps = App\Models\PsychomotorResult::getStudentPsychomotor($currentClass->id, null, $exam->id, $sub->title, $student->id);
                                        $ps = $psychomotorResult
                                            ->where('student_id', $student->id)
                                            ->where('subject', $subject->title)
                                            ->first();
                                        
                                    @endphp
                                    {{ $ps ? $ps->grade : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <br>
                    <table class="table" id="scale">
                        <tr>
                            <td colspan="2">{{ $psychomotor->title }} Scale:
                            </td>
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
            <tr style="border:0px;width:25%; text-align:center ">
                <td style="border:0;"><img height="50" class="img-responsive"
                        src="{{ $generalSettings->coat_of_arm ? public_path(\Storage::url($generalSettings->coat_of_arm)) : '' }}"
                        alt="coat of arm">
                    <h6>School Stamp</h6>

                </td>
                <td style="border:0;width:50%;text-align:center">
                    <img height="50" class="img-responsive"
                        src="{{ $generalSettings->school_stamp ? public_path(\Storage::url($generalSettings->school_stamp)) : '' }}"
                        alt="stamp">
                    <h6>Headmaster/Principal Signature</h6>
                </td>
                <td style="border:0; text-align:center; max-height: 100px; width:25%">
                    <div>
                        <h5>Verify Result</h5>
                        <img src="data:image/png;base64, {!! $verifyUrlQrCode !!} ">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
