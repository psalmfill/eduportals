<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            padding: 2px;
            margin: 2px;
        }

        #result {
            page-break-after: right;
        }

        #result table {
            box-sizing: border-box;
            /* border-collapse: collapse; */
            border-spacing: 0px;
            width: 100%
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

        .text-center {
            text-align: center
        }
    </style>
</head>

<body>
    <div id="result">

        <table class="table table-bordere table-condensed" border="1" id="table-4" style="empty-cells:show">
            <thead>
                <tr>
                    <td class="text-center" colspan="{{ 6 + ($exam->exam_types->count() + 2) * $subjects->count() }}">
                        <div>
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
                    <th rowspan="">Reg No</th>
                    <th rowspan="">Name</th>
                    <th rowspan="">Total</th>
                    <th rowspan="">Pos</th>
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

                        <td>{!! getClassPosition($markstore, $item->id) !!} </td>

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
