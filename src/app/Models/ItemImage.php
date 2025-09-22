<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemImage extends Model
{
    protected $fillable = ['items_id', 'image_url'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'items_id');
    }
}

