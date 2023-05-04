<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsychomotorGrade extends Model
{
    protected $guarded = [];

    public function psychomotor()
    {
        return $this-> belongsTo(Psychomotor::class);
    }
}
