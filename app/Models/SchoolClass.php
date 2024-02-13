<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchoolClass extends Model
{
    protected $guarded = [];

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'school_class_section', 'school_class_id', 'section_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'school_class_section_subject', 'school_class_id', 'subject_id')
            ->withPivot('section_id', 'school_id');
    }

    public function learning_resources()
    {
        return $this->hasMany(LearningResource::class);
    }
    /**
     * The fee_items that belong to the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fee_items(): BelongsToMany
    {
        return $this->belongsToMany(FeeItem::class, 'fee_item_section', 'school_class_id', 'fee_item_id');
    }
}
