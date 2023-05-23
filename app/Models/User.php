<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'other_name', 'address', 'phone_number', 'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return "$this->last_name, $this->first_name $this->other_name";
    }
    public function getFullNameAttribute()
    {
        return "$this->last_name, $this->first_name $this->other_name";
    }
    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
    public function getAvatarAttribute()
    {
        return  asset(Storage::url($this->image));
    }
}
