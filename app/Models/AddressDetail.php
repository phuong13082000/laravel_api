<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressDetail extends Model
{
    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'pincode',
        'country',
        'mobile',
        'status',
    ];
}
