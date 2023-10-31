<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name', 'code', 'school_id'
    ];

    public function learning_resources()
    {
        return $this->hasMany(LearningResources::class);
    }
}
