<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProducts extends Model
{
    use HasFactory;

    // Une image appartient à un produit
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
