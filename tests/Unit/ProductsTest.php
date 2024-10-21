<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Products;
use App\Models\Categories;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\ImageProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Categories::factory()->create();
        $product = Products::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Categories::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /** @test */
    public function it_has_many_cart_items()
    {
        $product = Products::factory()->create();
        $cartItem = CartItem::factory()->create(['products_id' => $product->id]); // Keep products_id

        $this->assertInstanceOf(CartItem::class, $product->cartItems->first());
        $this->assertEquals($product->id, $cartItem->products_id); // Keep products_id
    }

    /** @test */
    public function it_has_many_order_items()
    {
        $product = Products::factory()->create();
        $orderItem = OrderItem::factory()->create(['products_id' => $product->id]); // Keep products_id

        $this->assertInstanceOf(OrderItem::class, $product->orderItems->first());
        $this->assertEquals($product->id, $orderItem->products_id); // Keep products_id
    }

    /** @test */
    public function it_has_many_images_products()
    {
        $product = Products::factory()->create();
        $imageProduct = ImageProducts::factory()->create(['products_id' => $product->id]); // Keep products_id

        $this->assertInstanceOf(ImageProducts::class, $product->imagesProducts->first());
        $this->assertEquals($product->id, $imageProduct->products_id); // Keep products_id
    }
}
