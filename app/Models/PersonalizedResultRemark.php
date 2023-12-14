<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalizedResultRemark extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
