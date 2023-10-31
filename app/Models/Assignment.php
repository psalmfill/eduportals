<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'submission_date' => 'date',
        'available_date' => 'date',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function staff()
    {
        return $this->morphTo('staffable');
    }
}
