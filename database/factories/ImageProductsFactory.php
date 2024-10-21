<?php

namespace Database\Factories;

use App\Models\ImageProducts;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageProductsFactory extends Factory
{
    protected $model = ImageProducts::class;

    public function definition()
    {
        return [
            'products_id' => Products::factory(), // Create and associate with a product
            'imageUrl' => $this->faker->imageUrl(), // Generate a random image URL
            'altText' => $this->faker->sentence(), // Generate a random alt text
        ];
    }
}
