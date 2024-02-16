<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeePaymentItem extends Model
{
    use HasFactory;
    protected $guarded=["id"];

    /**
     * Get the fee that owns the FeePaymentItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    /**
     * Get the fee_item that owns the FeePaymentItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fee_item(): BelongsTo
    {
        return $this->belongsTo(FeeItem::class);
    }
}
