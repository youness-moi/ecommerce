<?php

namespace App\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Orders;

class OrderFactory
{
    public static function create(array $validatedFields): Orders
    {
        // Création de la commande
        $order = new Orders();
        $order->user_id = auth()->id();
        $order->total = $order->calculateTotal($validatedFields['products']);
        $order->status = 'pending';
        $order->save();

        // Utilisation de OrderItemFactory pour créer chaque item
        $orderItems = collect($validatedFields['products'])->map(function ($productData) use ($order) {
            return OrderItemFactory::create($order, $productData);
        });

        // Associe les items de commande avec la commande
        $order->orderItems()->saveMany($orderItems);


        return $order;
    }
}
