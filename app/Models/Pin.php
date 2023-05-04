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
}
