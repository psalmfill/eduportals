<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarkStore extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function getTotalMarks(
        $exam_id,
        $academic_session_id,
        $class_id,
        $student_id

    ) {
        return self::where('exam_id', $exam_id)
            ->where('academic_session_id', $academic_session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->sum('score');
    }

    public static function getMark(
        $exam_id,
        $exam_type_id,
        $subject_id,
        $academic_session_id,
        $class_id,
        $student_id,
        $section_id = null
    ) {
        $mark = MarkStore::where('exam_id', $exam_id)
            ->where('exam_type_id', $exam_type_id)
            ->where('subject_id', $subject_id)
            ->where('academic_session_id', $academic_session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->when($section_id, function ($query, $section_id) {
                return $query->where('section_id', $section_id);
            })
            ->first();
        return $mark;
    }

    public static function isAbsent(
        $exam_id,
        $exam_type_id,
        $subject_id,
        $academic_session_id,
        $class_id,
        $student_id,
        $section_id
    ) {
        $mark = self::where('exam_id', $exam_id)
            ->where('exam_type_id', $exam_type_id)
            ->where('subject_id', $subject_id)
            ->where('academic_session_id', $academic_session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->where('section_id', $section_id)
            ->first();
        return $mark ? $mark->absent : 0;
    }
    public static function notOffered(
        $exam_id,
        $exam_type_id,
        $subject_id,
        $academic_session_id,
        $class_id,
        $student_id,
        $section_id
    ) {
        $mark = self::where('exam_id', $exam_id)
            ->where('exam_type_id', $exam_type_id)
            ->where('subject_id', $subject_id)
            ->where('academic_session_id', $academic_session_id)
            ->where('student_id', $student_id)
            ->where('school_class_id', $class_id)
            ->where('section_id', $section_id)
            ->first();
        return $mark ? $mark->not_offered : 0;
    }

    public static function getSubjectPosition(
        $exam_id,
        $subject_id,
        $academic_session_id,
        $class_id,
        $student_id,
        $section_id
    ) {
        $allMarkStoreFromStudents = MarkStore::where([
            ['exam_id', $exam_id],
            ['school_class_id', $class_id],
            ['section_id', $section_id],
            ['academic_session_id', $academic_session_id],
            ['subject_id', $subject_id],
            ['not_offered', 0]
        ])
            // ->whereHas('student', function ($q) {
            //     return $q->active();
            // })
            ->get();
        $studentIds = $allMarkStoreFromStudents->pluck('student_id')->unique();
        $scores = $studentIds->map(function ($e) use ($allMarkStoreFromStudents) {
            return ['student_id' => $e, 'score' => $allMarkStoreFromStudents->where('student_id', $e)->sum('score')];
        })->sortByDesc('score');
        // $position = $scores->pluck('student_id')->search($student_id) + 1;
        $scoresGroup = $scores->groupBy('score');
        $position = $scoresGroup->count();
        $newGroup = [];
        // remove the grouping score
        foreach ($scoresGroup as $group) {
            $newGroup[] = $group;
        }
        foreach ($newGroup as $key => $value) {
            if (strval(collect($value)->pluck('student_id')->search($student_id)) != '') {
                $position = $key + 1;
            }
        }

        return ordinalSuffix($position, 1);
    }

    public static function getClassPosition(
        $exam_id,
        $academic_session_id,
        $class_id,
        $student_id,
        $section_id
    ) {
        $allMarkStoreFromStudents = MarkStore::where([
            ['exam_id', $exam_id],
            ['school_class_id', $class_id],
            ['section_id', $section_id],
            ['not_offered', 0],
            ['academic_session_id', $academic_session_id],
        ])->get();
        $studentIds = $allMarkStoreFromStudents->pluck('student_id')->unique();
        $scores = $studentIds->map(function ($e) use ($allMarkStoreFromStudents) {
            $subject_count =  $allMarkStoreFromStudents->where('student_id', $e)->unique('subject_id')->count();
            $score = $allMarkStoreFromStudents->where('student_id', $e)->sum('score');
            return [
                'student_id' => $e, 'score' => $score,
                'subject_count' => $subject_count,
                'student_average' => '' . $score / $subject_count
            ];
        })->sortByDesc('student_average');
        // $position = $scores->pluck('student_id')->search($student_id) + 1;
        $scoresGroup = $scores->groupBy('student_average');
        $position = $scoresGroup->count();
        $newGroup = [];
        // remove the grouping score
        foreach ($scoresGroup as $group) {
            $newGroup[] = $group;
        }
        foreach ($newGroup as $key => $value) {
            if (strval(collect($value)->pluck('student_id')->search($student_id)) != '') {
                $position = $key + 1;
            }
        }

        return ordinalSuffix($position, 1);
    }


    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
