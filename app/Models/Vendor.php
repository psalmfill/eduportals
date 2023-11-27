<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schools()
    {
        return $this->hasMany(School::class);
    }
}
