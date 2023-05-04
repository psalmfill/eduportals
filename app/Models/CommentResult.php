<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentResult extends Model
{
    public static function getMark(
        $school_id,
        $session_id,
        $exam_id,
        $school_class_id,
        $section_id,
        $group_id,
        $topic_id,
        $student_id
    ){

        return self::where('comment_result_group_id',$group_id)
        ->where('comment_result_item_id', $topic_id)
        ->where('student_id', $student_id)
        ->where('exam_id', $exam_id)
        ->where('school_class_id', $school_class_id)
        ->where('section_id', $section_id)
        ->where('academic_session_id', $session_id)
        ->where('school_id', $school_id)->first();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
