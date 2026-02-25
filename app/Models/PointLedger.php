<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLedger extends Model
{
    protected $fillable = ['user_id', 'amount', 'used_amount', 'balance', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
