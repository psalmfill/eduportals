<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentResultGroup extends Model
{
    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            $model->topics()->delete();
        });
    }
    public function topics()
    {
        return $this->hasMany(CommentResultItem::class);
    }
}
