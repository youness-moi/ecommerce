<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition()
    {
        return [
            'cart_id' => Cart::factory(), // Create and associate with a cart
            'products_id' => Products::factory(), // Create and associate with a product
            'quantity' => $this->faker->numberBetween(1, 5), // Quantity of the product in the cart
        ];
    }
}
