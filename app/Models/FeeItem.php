<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FeeItem extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    /**
     * Get the school that owns the FeeItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * The sections that belong to the FeeItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'fee_item_section');
    }

    /**
     * The school_classes that belong to the FeeItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function school_classes(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'fee_item_section', 'fee_item_id', 'school_class_id');
    }

    /**
     * Get the fee that owns the FeeItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

}
