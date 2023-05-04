<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $guarded = [];

    public function sections()
    {
        return $this->belongsToMany(Section::class,'school_class_section','school_class_id','section_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'school_class_section_subject','school_class_id','subject_id')
        ->withPivot('section_id','school_id');
    }
}
