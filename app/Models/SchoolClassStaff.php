<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SchoolClassStaff extends Pivot
{
    protected $table = 'school_class_staff';
    public function school()
    {
        return $this->hasOne(School::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
}
