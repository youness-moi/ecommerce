<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('category')->insert([
            ['id' => 1, 'name' => 'Vêtements'],
            ['id' => 2, 'name' => 'Accessoires'],
            // Add other categories as needed
        ]);
    }
}
