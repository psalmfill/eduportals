<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Authenticatable
{
    protected $fillable = ['hostel_room_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }
    public function getFullNameAttribute()
    {
        return " $this->last_name, $this->first_name  $this->other_name";
    }

    public function getAvatarAttribute()
    {
        return asset(Storage::url($this->image));
    }

    public function psychomotor_results()
    {
        return $this->hasMany(PsychomotorResult::class);
    }

    public function comment_results()
    {
        return $this->hasMany(CommentResult::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function mark_stores()
    {
        return $this->hasMany(MarkStore::class);
    }
    public function pins()
    {
        return $this->hasMany(Pin::class);
    }

    public function comment_result_remarks()
    {
        return $this->hasMany(CommentResultRemark::class);
    }

    public function hostel_room()
    {
        return $this->belongsTo(HostelRoom::class);
    }
}
