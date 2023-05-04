<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name','school_id'];
    public function school_classes()
    {
        return $this->belongsToMany(SchoolClass::class,'school_class_section','section_id','school_class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'school_class_section_subject','section_id','subject_id')
        ->withPivot('school_class_id','school_id');
    }
}
