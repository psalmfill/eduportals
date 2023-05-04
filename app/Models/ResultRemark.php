<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultRemark extends Model
{
    protected $guarded = [];

    protected $dates = ['next_term_begins'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }
}
