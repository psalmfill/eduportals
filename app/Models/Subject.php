<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    protected $fillable = [
        'name', 'code', 'school_id'
    ];

    public function learning_resources()
    {
        return $this->hasMany(LearningResources::class);
    }

    public function teachers($class, $section)
    {
        $teachers = DB::table('subject_staff')->select(['staff_id'])
            ->where('subject_id', $this->id)
            ->where('school_class_id', $class)
            ->where('section_id', $section)
            ->where('school_id', getSchool()->id)->pluck('staff_id');
        return Staff::find($teachers);
    }
}
