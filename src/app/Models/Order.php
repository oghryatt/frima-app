<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'status',
        'ordered_at',
        'shipping_address',
        'payment_method',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    
    public function payment()
    {
        return $this->hasOne(Pay::class, 'orders_id'); 
    }
}
