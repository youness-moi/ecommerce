<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // Un item dans le panier appartient à un panier
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Un item dans le panier est lié à un produit
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
