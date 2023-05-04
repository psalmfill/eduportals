<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psychomotor extends Model
{
    protected $guarded = [];

    public function subjects()
    {
        return $this->hasMany(PsychomotorSubject::class);
    }
    public function grades()
    {
        return $this->hasMany(PsychomotorGrade::class);
    }
}
