<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentResultRemark extends Model
{
    protected $fillable = ['teacher', 'headmaster', 'next_term_begins','next_term_fee', 'student_id', 'exam_id', 'school_id', 'school_class_id', 'section_id', 'academic_session_id'];

    public static function getReMark(
        $school_id,
        $session_id,
        $exam_id,
        $school_class_id,
        $section_id,
        $student_id
    ) {

        return self::where('student_id', $student_id)
            ->where('exam_id', $exam_id)
            ->where('school_class_id', $school_class_id)
            ->where('section_id', $section_id)
            ->where('academic_session_id', $session_id)
            ->where('school_id', $school_id)->first();
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
