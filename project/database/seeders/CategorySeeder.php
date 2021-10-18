<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::first();
        if ($category == null){
            Category::create(['name' => "chibi"]);
            Category::create(['name' => "lolita"]);
            Category::create(['name' => "girl"]);
            Category::create(['name' => "boy"]);
            Category::create(['name' => "animal"]);
            Category::create(['name' => "ghost"]);
            Category::create(['name' => "devil"]);
            Category::create(['name' => "angel"]);
            Category::create(['name' => "comic"]);
            Category::create(['name' => "anime"]);
            Category::create(['name' => "queen"]);
            Category::create(['name' => "halloweeen"]);
            Category::create(['name' => "cloth"]);
            Category::create(['name' => "dragon"]);
            Category::create(['name' => "elf"]);
            Category::create(['name' => "game art"]);


        }
    }
}
