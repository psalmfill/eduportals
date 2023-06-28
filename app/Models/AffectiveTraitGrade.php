<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectiveTraitGrade extends Model
{
    protected $guarded = [];

    public function affective_trait()
    {
        return $this->belongsTo(AffectiveTrait::class);
    }
}
