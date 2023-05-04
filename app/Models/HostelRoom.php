<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HostelRoom extends Model
{
    protected $guarded = [];

    public function hostel()
    {
        return $this->belongsTo(Hostel::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function getAvailableSpacesAttribute()
    {
        return $this->space - $this->students()->count();
    }
}
