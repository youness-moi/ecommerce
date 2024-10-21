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
        'products_id',
        'quantity',
        'price',
    ];

     // Un item de commande appartient à une commande
     public function order()
     {
         return $this->belongsTo(Orders::class);
     }

     // Un item de commande est lié à un produit
     public function product()
     {
        return $this->belongsTo(Products::class);
     }

}
