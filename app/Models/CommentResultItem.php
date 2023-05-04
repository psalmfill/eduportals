<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentResultItem extends Model
{
    public function topics()
    {
        return $this->hasMany(CommentResultGroup::class);
    }
}
