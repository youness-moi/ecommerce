<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'products_id')
                    ->withPivot('quantity');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'order_id');
    }
}
