<?php

namespace Database\Seeders;

use App\Models\AdoptImage;
use Illuminate\Database\Seeder;

class AdopImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adopt = AdoptImage::first();
        if ($adopt == null){
            $adopt = AdoptImage::factory()->count(10)->create();
        }
    }
}
