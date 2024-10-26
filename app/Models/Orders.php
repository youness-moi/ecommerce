<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;


    // Une commande appartient à un produit


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



    public function calculateTotal(array $products)
    {
        $total = 0;
        foreach ($products as $productData) {
            $total += $productData['price'] * $productData['quantity'];
        }
        return $total;
    }
    // Boot the model when creating a new one
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->orderDate = $model->orderDate ?? now();
        });
    }


}
