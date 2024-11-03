<?php

namespace App\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Orders;

class OrderItemFactory
{
    public static function create(Orders $order, array $productData): OrderItem
    {
        return new OrderItem([
            'orders_id' => $order->id,
            'products_id' => $productData['product_id'],
            'quantity' => $productData['quantity'],
            'price' => $productData['price'],
            'discount' => $productData['discount'] ?? 0,
        ]);
    }
}
