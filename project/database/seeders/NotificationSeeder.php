<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $noti = Notification::first();
        if ($noti == null){
            $noti = Notification::factory()->count(10)->create();
        }
    }
}
