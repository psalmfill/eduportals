<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = [];

    public static function getGrade($grade)
    {
        $grade = self::where('school_id', getSchool()->id)
            ->orderBy('minimum_score', 'desc')
            // ->where('minimum_score','>=',$grade)
            ->where('minimum_score', '<=', $grade)
            ->first();
        return $grade;
    }
}
