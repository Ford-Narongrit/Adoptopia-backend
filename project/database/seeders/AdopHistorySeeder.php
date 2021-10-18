<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdopHistory;

class AdopHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adoptHistory = AdopHistory::first();
        if(!$adoptHistory) {
            $adoptHistory = AdopHistory::factory(10)->create();
        }
    }
}
