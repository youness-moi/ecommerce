<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'orders_id', // Modifié ici
        'products_id',
        'quantity',
        'price',
        'discount',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'orders_id'); // Modifié ici
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'products_id');
    }
}
