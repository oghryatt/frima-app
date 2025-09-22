<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'postal_code', 'address_line'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}