<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Orders::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Assuming an order belongs to a user
            'orderDate' => $this->faker->date(), // Random order date
            'total' => $this->faker->randomFloat(2, 50, 500), // Total before discount
            'discount' => $this->faker->randomFloat(2, 0, 50), // Random discount
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']), // Random status
        ];
    }
}
