<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Orders;
use App\Models\User;
use App\Models\Products;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // Create a user and authenticate them
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_creates_an_order_with_valid_data()
    {
        // Create products to be added to the order
        $product1 = Products::factory()->create();
        $product2 = Products::factory()->create();

        $response = $this->postJson('/api/orders', [
            'products' => [
                [
                    'product_id' => $product1->products_id,
                    'quantity' => 2,
                    'price' => 50.00,
                ],
                [
                    'product_id' => $product2->products_id,
                    'quantity' => 1,
                    'price' => 30.00,
                ]
            ]
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Commande créée avec succès']);

        // Verify the order is created in the database
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'status' => 'pending',
        ]);

        // Check that products were attached to the order with correct details
        $order = Orders::first();
        $this->assertEquals(2, $order->products()->count());
        $this->assertDatabaseHas('order_product', [
            'order_id' => $order->id,
            'product_id' => $product1->products_id,
            'quantity' => 2,
            'price' => 50.00,
        ]);
        $this->assertDatabaseHas('order_product', [
            'order_id' => $order->id,
            'product_id' => $product2->products_id,
            'quantity' => 1,
            'price' => 30.00,
        ]);
    }

    /** @test */
    public function it_fails_to_create_order_with_invalid_data()
    {
        $response = $this->postJson('/api/orders', [
            'products' => [
                [
                    'product_id' => null, // Missing product_id
                    'quantity' => 0,      // Invalid quantity
                    'price' => -10,       // Invalid price
                ]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'products.0.product_id',
            'products.0.quantity',
            'products.0.price',
        ]);
    }
}
