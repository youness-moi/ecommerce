<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            ['name' => 'Vêtements', 'description' => 'Vêtements pour hommes et femmes'],
            ['name' => 'Accessoires', 'description' => 'Accessoires divers'],
            ['name' => 'Chaussures', 'description' => 'Chaussures pour toutes les occasions'],
        ]);
    }
}
