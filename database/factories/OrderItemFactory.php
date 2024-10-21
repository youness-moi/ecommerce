<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition()
    {
        return [
            'order_id' => Orders::factory(), // Create and associate with an order
            'products_id' => Products::factory(), // Create and associate with a product
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 1000), // Correctly generates a decimal value between 10 and 1000
            'discount' => $this->faker->randomFloat(2, 0, 10), // Random discount value
        ];
    }
}
