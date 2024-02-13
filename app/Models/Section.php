<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Section extends Model
{
    protected $fillable = ['name','school_id'];
    public function school_classes()
    {
        return $this->belongsToMany(SchoolClass::class,'school_class_section','section_id','school_class_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'school_class_section_subject','section_id','subject_id')
        ->withPivot('school_class_id','school_id');
    }

    /**
     * The fee_items that belong to the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fee_items(): BelongsToMany
    {
        return $this->belongsToMany(FeeItem::class, 'fee_item_section', 'section_id', 'fee_item_id');
    }
}
