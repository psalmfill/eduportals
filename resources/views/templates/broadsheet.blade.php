<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            padding: 1px;
            margin: 1px;
            font-size: 0.5em
        }

        #result {
            page-break-after: right;
            width: 100%;
            text-transform: uppercase;
        }

        #result table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
            width: 100%;
            table-layout: auto !important;
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
            border: 1px solid #333;
            margin: 0;
            padding: 10px;
            white-space: nowrap;
            width: auto !important;
        }

        #result table tr:last-child td {
            border-bottom: 1px solid #333;
        }

        #result table tr td:first-child {

            border-left: 1px solid #333;
        }

        .text-center {
            text-align: center
        }
    </style>
</head>

<body>
    <div id="result">

        <table class="table table-bordere table-condensed" border="1" id="table-4">
            <thead>
                <tr>
                    <td class="text-center" colspan="{{ 6 + ($exam->exam_types->count() + 2) * $subjects->count() }}">
                        <div>
                            <div>
                                <img width="140" height="130" class="img-responsive"
                                    src="{{ getSchool()->logo ? public_path(\Storage::url(getSchool()->logo)) : '' }}"
                                    alt="logo">
                            </div>
                            <h2>{{ $exam->school->name }}</h2>
                            <p>{{ $exam->school->address }}, {{ $exam->school->city }}</< /p>
                            <p>{{ $exam->school->state }}, {{ $exam->school->country }}</< /p>
                        </div>
                    </td>

                </tr>
                <tr>

                    <td colspan="5" class="text-center">Students</td>
                    <td class="text-center">Class Average : {{ $classAverage }}</td>
                    @foreach ($subjects as $subject)
                        <th class="text-center" colspan="{{ $exam->exam_types->count() + 2 }}">{{ $subject->name }}
                            ({{ $exam->total_mark }})
                        </th>
                    @endforeach
                </tr>
                <tr>
                    <th rowspan="">S/N</th>
                    <th class="text-center" rowspan="">Reg No</th>
                    <th class="text-center" rowspan="">Name</th>
                    <th class="text-center" rowspan="">Total <br>({{ $exam->total_mark * $subjects->count() }})
                    </th>
                    <th class="text-center" rowspan="">Pos</th>
                    <th class="text-center">Student Average</th>

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
                        <td class="text-center">{{ $loop->index + 1 }}</td>
                        <td class="text-center">{{ $item->reg_no }}</td>
                        <td class="text-center">{{ $item->full_name }}</td>
                        <td class="text-center">{{ $totalScore }}

                        <td class="text-center">{!! getClassPosition($markstore, $item->id) !!} </td>

                        <td class="text-center">
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
                                    {{ $mark && !$mark->absent && !$mark->not_offered ? $mark->score : '-' }}</td>
                            @endforeach
                            <td class="text-center">
                                {{ $total != 0 && $mark && !$mark->absent && !$mark->not_offered ? $total : '-' }}</td>

                            <td class="text-center">{!! $total != 0 && $mark && !$mark->absent && !$mark->not_offered
                                ? getSubjectPosition($markstore, $item->id, $subject->id)
                                : '-' !!}</td>
                        @endforeach

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
