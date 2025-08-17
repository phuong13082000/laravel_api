<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stripeId',
        'user_id',
        'amount',
        'currency',
        'status',
        'description',
        'checkoutUrl',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
