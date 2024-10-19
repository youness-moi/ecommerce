<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    // Un paiement est lié à une commande
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
}
