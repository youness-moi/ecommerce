<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relation avec le modèle Order
    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    // Relation avec le modèle Product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

}
