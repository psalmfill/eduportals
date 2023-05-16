<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    public function school()
    {
        return $this->belongsTo(School::class);
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

    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'transactable');
    }
}
