<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    public function exam()
    {
        return  $this->belongsTo(Exam::class,'exam_id');
    }
}
