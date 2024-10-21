<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Products extends Model
{
    use HasFactory;
    //use SoftDeletes;
    protected $dates=['created_at', 'update_at'];
    protected $fillable = ['name','price','description','stockQuantity',
                           'size','color','material','gender','category_id', ];



     // Un produit appartient à une catégorie
     public function category()
     {
         return $this->belongsTo(Categories::class);
     }

     // Un produit peut être présent dans plusieurs paniers (via cart_items)
     public function cartItems()
     {
        return $this->hasMany(CartItem::class, 'products_id');
     }


     // Un produit peut être présent dans plusieurs commandes (via order_items)
     public function orderItems()
     {
         return $this->hasMany(OrderItem::class);
     }

     // Un produit peut avoir plusieurs images
     public function imagesProducts()
     {
         return $this->hasMany(ImageProducts::class);
     }

     public function getRouteKeyName()
    {
        return 'id'; // Spécifie que Laravel doit utiliser 'idproduct' pour le binding
    }
}
