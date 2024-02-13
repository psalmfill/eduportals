<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Fee extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactable');
    }

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
        return $this->belongsTo(Student::class);
    }

    public function session()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    public function staff()
    {
        return $this->morphTo('staffable');
    }
    /**
     * Get all of the items for the Fee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(FeePaymentItem::class);
    }

    /**
     * Get all of the fee_items for the Fee
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function fee_items(): HasManyThrough
    {
        return $this->hasManyThrough(FeePaymentItem::class, FeeItem::class);
    }
}
