<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stripe_id',
        'user_id',
        'amount',
        'currency',
        'status',
        'description',
        'checkout_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
