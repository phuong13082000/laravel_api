<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'addressLine',
        'city',
        'state',
        'pinCode',
        'country',
        'mobile',
        'status',
    ];
}
