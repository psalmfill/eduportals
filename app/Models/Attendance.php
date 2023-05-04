<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    protected $dates = ['dates'];
    public static function getAttendance(
        $student_id,
        $date
    ) {
        return self::where(
            'student_id',
            $student_id
        )->where('date', Carbon::createFromDate($date))->first();
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
}
