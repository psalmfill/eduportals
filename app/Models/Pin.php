<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    protected $guarded = [];
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function collection()
    {
        return $this->belongsTo(PinCollection::class);
    }

    public function getHasExpiredAttribute()
    {
        return Date($this->expiry_date) < now();
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
