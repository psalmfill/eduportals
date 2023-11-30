<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends SoftDeleteModel
{
    const PENDING = 'pending';

    const CANCELLED = 'cancelled';

    const FAILED = 'failed';

    const DECLINED = 'declined';

    const COMPLETED = 'completed';


    protected $fillable = ['id', 'user_id', 'paymentable_type', 'paymentable_id', 'amount', 'reference', 'status', 'meta_data', 'school_id'];


    protected $cast = [
        "created_at" => 'datetime:d-m-Y H:i:s',
        "updated_at" => 'datetime:d-m-Y H:i:s',
    ];

    public function paymentable()
    {
        return  $this->morphTo();
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
