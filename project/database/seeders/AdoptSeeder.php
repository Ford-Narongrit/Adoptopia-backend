<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Adopt;

class AdoptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adopt = Adopt::first();
        if ($adopt == null){
            $adopt = Adopt::factory()->count(10)->create();
        }
    }
}
