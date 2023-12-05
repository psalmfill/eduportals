<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];
    protected $casts = [
        'date' => 'date'
    ];
    public static function getAttendance(
        $student_id,
        $date
    ) {
        return self::where(
            'student_id',
            $student_id
        )->whereDate('date', Carbon::createFromDate($date))->first();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function studentMonthAttendance(
        $student_id,
        $academic_session_id,
        $term_id,
        $month,
        $day
    ) {
        return self::where([
            ['school_id', '=', getSchool()->id],
            ['academic_session_id', '=', $academic_session_id],
            ['term_id', '=', $term_id],
            ['student_id', '=', $student_id]
        ])
            ->whereMonth('date', date_parse($month)['month'])
            ->get();
    }

    public static function studentDayAttendance(
        $student_id,
        $academic_session_id,
        $term_id,
        $month,
        $day
    ) {
        return self::where([
            ['school_id', '=', getSchool()->id],
            ['academic_session_id', '=', $academic_session_id],
            ['term_id', '=', $term_id],
            ['student_id', '=', $student_id]
        ])
            ->whereMonth('date', date_parse($month)['month'])
            ->whereMonth('date', date_parse($day)['day'])
            ->first();
    }

    public static function getReport(
        $session_id,
        $term_id,
        $class_id,
        $student_id
    ) {
        $totalAttendance =
            Attendance::where([
                ['academic_session_id', $session_id],
                ['term_id', $term_id],
                ['school_id', getSchool()->id],
                ['school_class_id', $class_id],
                ['present', true]
            ])->pluck('date')->unique('date')->count();
        $daysPresent =
            Attendance::where([
                ['academic_session_id', $session_id],
                ['term_id', $term_id],
                ['school_id', getSchool()->id],
                ['school_class_id', $class_id],
                ['present', true],
                ['student_id', $student_id]
            ])->pluck('date')->unique('date')->count();
        $daysAbsent =
            Attendance::where([
                ['academic_session_id', $session_id],
                ['term_id', $term_id],
                ['school_id', getSchool()->id],
                ['school_class_id', $class_id],
                ['present', false],
                ['student_id', $student_id]
            ])->pluck('date')->unique('date')->count();
        return [
            'days_absent' => $daysAbsent,
            'days_present' => $daysPresent,
            'total_days' => $totalAttendance
        ];
    }
}
