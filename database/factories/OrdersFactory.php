<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Orders;
use App\Models\User; // Make sure to import the User model
use Illuminate\Database\Eloquent\Factories\Factory;

class OrdersFactory extends Factory
{
    protected $model = Orders::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Create a user instance for the foreign key
            'orderDate' => $this->faker->dateTimeBetween('-1 month', 'now'), // Random date within the last month
            'total' => $this->faker->decimal(10, 2), // Random total amount
            'discount' => $this->faker->randomFloat(2, 0, 100), // Random discount between 0 and 100
            'status' => $this->faker->randomElement(['pending', 'completed', 'canceled']), // Random status
        ];
    }
}
