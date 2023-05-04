<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = [];

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
