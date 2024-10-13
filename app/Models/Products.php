<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ImageProducts::class, 'product_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Orders::class, 'orders_id')
                    ->withPivot('quantity');
    }
}
