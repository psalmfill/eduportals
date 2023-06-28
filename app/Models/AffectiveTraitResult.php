<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectiveTraitResult extends Model
{
    protected $guarded = [];

    public static function getStudentAffectiveTrait(
        $class_id,
        $section_id = null,
        $exam_id,
        $subject_title,
        $student_id
    ) {
        [
            ['school_id', getSchool()->id],
            ['school_class_id', $class_id],
            ['section_id', $section_id],
            ['exam_id', $exam_id],
            ['section_id', $section_id],
            ['subject', $subject_title],
            ['student_id', $student_id]
        ];
        $result = self::where('school_id', getSchool()->id)
            ->when($class_id, function ($query, $class_id) {
                return $query->where('school_class_id', $class_id);
            })->when($section_id, function ($query, $section_id) {
                return $query->where('section_id', $section_id);
            })->when($exam_id, function ($query, $exam_id) {
                return $query->where('exam_id', $exam_id);
            })->when($section_id, function ($query, $section_id) {
                return $query->where('section_id', $section_id);
            })->when($subject_title, function ($query, $subject_title) {
                return $query->where('subject', $subject_title);
            })->where('student_id', $student_id)
            ->first();

        return $result;
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
