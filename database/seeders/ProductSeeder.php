<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'T-shirt homme',
                'price' => 19.99,
                'description' => 'Un t-shirt confortable pour homme',
                'stockQuantity' => 100,
                'size' => 'M',
                'color' => 'Bleu',
                'material' => 'Coton',
                'gender' => 'Homme',
                'category_id' => 1 // Supposons que 'Vêtements' ait l'ID 1
            ],
            [
                'name' => 'Robe femme',
                'price' => 49.99,
                'description' => 'Une robe élégante pour femme',
                'stockQuantity' => 50,
                'size' => 'L',
                'color' => 'Rouge',
                'material' => 'Soie',
                'gender' => 'Femme',
                'category_id' => 1
            ],
            [
                'name' => 'Sac à main',
                'price' => 99.99,
                'description' => 'Un sac à main en cuir pour femme',
                'stockQuantity' => 30,
                'size' => 'Unique',
                'color' => 'Noir',
                'material' => 'Cuir',
                'gender' => 'Femme',
                'category_id' => 2 // Supposons que 'Accessoires' ait l'ID 2
            ]
        ]);
    }
}
