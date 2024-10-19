<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    // Une commande appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Une commande a plusieurs items (order_items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Une commande a un paiement (relation un-à-un)
    public function payment()
    {
        return $this->hasOne(Payments::class);
    }
}
