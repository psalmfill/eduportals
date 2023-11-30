<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinCollection extends Model
{
    protected $fillable = [
        'reference', 'school_id', 'quantity', 'delivered'
    ];

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
