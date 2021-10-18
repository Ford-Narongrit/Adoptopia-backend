<?php

namespace Database\Seeders;

use App\Models\AdoptImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(AdoptSeeder::class);
        $this->call(AdopImageSeeder::class);
        $this->call(PaymentHistorySeeder::class);
        $this->call(AdopHistorySeeder::class);
        $this->call(FollowerUserSeeder::class);
    }
}
