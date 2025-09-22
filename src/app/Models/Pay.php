<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    protected $fillable = ['orders_id', 'method', 'amount', 'paid_at'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id');
    }
}