<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SoftDeleteModel extends Model
{

    use SoftDeletes;

    protected $casts = [
        "created_at" => 'datetime:d-m-Y H:i:s',
        "updated_at" => 'datetime:d-m-Y H:i:s',
        "pickup_date" => 'datetime:d-m-Y H:i:s',
    ];
}
