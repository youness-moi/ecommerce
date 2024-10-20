<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   // protected $model = Products::class;
    public function definition()
    {
        return [
            'name' => $this->faker->word(), // Génère un nom de produit aléatoire
            'price' => $this->faker->randomFloat(2, 10, 100), // Prix entre 10 et 100 avec 2 décimales
            'description' => $this->faker->text(200), // Description aléatoire
            'stockQuantity' => $this->faker->numberBetween(0, 100), // Quantité en stock entre 0 et 100
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL']), // Taille aléatoire
            'color' => $this->faker->colorName(), // Couleur aléatoire
            'material' => $this->faker->word(), // Matériau aléatoire
            'gender' => $this->faker->randomElement(['Homme', 'Femme']), // Genre aléatoire
            'category_id' => Categories::factory(), // Utilisation d'une factory pour créer une catégorie associée
        ];
    }
}
