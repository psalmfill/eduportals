<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{

    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->exam_types()->delete();
        });
    }
    public function exam_types()
    {
        return $this->hasMany(ExamType::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
