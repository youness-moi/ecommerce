<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'category'; // Correct table name here

    // Une catégorie a plusieurs produits
    public function products()
    {
        return $this->hasMany(Products::class);
    }
}

