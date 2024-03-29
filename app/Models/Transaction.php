<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }


    public function staff()
    {
        return $this->morphTo('staffable');
    }

    public function transactable()
    {
        return $this->morphTo('transactable');
    }

    public function items(): HasMany
    {
        return $this->hasMany(FeePaymentItem::class);
    }
}
