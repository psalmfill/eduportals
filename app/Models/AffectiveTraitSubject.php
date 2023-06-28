<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffectiveTraitSubject extends Model
{
    protected $guarded = [];

    public function affective_trait()
    {
        return $this->belongsTo(AffectiveTrait::class);
    }
}
