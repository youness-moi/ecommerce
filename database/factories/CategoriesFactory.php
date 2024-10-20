<?php

namespace Database\Factories;

use App\Models\Categories;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categories>
 */
class CategoriesFactory extends Factory
{
    protected $model = Categories::class; // Specify the model for the factory

    public function definition()
    {
        return [
            'name' => $this->faker->word(), // Generate a random name for the category
            'description' => $this->faker->sentence(), // Generate a random description
        ];
    }
}
