<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'school_staff', 'school_id', 'staff_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pins()
    {
        return $this->hasMany(Pin::class);
    }



    public function pin_collections()
    {
        return $this->hasMany(PinCollection::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function school_classes()
    {
        return $this->hasMany(SchoolClass::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function settings()
    {
        return $this->hasMany(GeneralSetting::class);
    }

    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }

    public function hostels()
    {
        return $this->hasMany(Hostel::class);
    }

    public function psychomotor()
    {
        return $this->hasOne(Psychomotor::class);
    }

    public function affectiveTrait()
    {
        return $this->hasOne(AffectiveTrait::class);
    }
}
