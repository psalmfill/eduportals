<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectiveTrait extends Model
{
    protected $guarded = [];

    public function subjects()
    {
        return $this->hasMany(AffectiveTraitSubject::class);
    }
    public function grades()
    {
        return $this->hasMany(AffectiveTraitGrade::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
