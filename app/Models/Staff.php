<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Staff extends Authenticatable
{

    protected $fillable = [
        'first_name', 'last_name', 'other_name', 'username', 'password', 'gender', 'date_of_birth', 'email', 'image', 'address_1', 'address_2', 'phone_number', 'religion', 'country', 'state', 'city', 'active'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_staff', 'staff_id', 'school_id');
    }


    public function qualifications()
    {
        return $this->hasMany(Qualification::class);
    }

    public function school_classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'school_class_staff', 'staff_id', 'school_class_id')
            ->using(SchoolClassStaff::class)
            ->withPivot('section_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_staff', 'staff_id', 'subject_id')
            ->withPivot(
                'school_id'
            )->withPivot('section_id')
            ->withPivot(
                'school_class_id'
            );
    }

    public function getNameAttribute()
    {
        return "$this->first_name $this->other_name $this->last_name";
    }

    public static function classSections($staff, $class, $school_id)
    {
        $sections = DB::table('school_class_staff')->select(['section_id'])
            ->where('school_class_id', $class)
            ->where('staff_id', $staff)
            ->where('school_id', $school_id)->pluck('section_id');
        $sections = Section::find($sections);
        return $sections;
    }
    public function getAvatarAttribute()
    {
        return $this->image ? Storage::url($this->image) : 'http://placehold.it/150x150?text=Passport';
    }
}
