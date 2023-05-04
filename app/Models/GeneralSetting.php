<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
