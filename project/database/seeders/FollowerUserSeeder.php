<?php

namespace Database\Seeders;

use App\Models\FollowerUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FollowerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createCount = 30;
        while ($createCount > 0) {
            $follower = User::get()->pluck('id')->random();
            $following = User::get()->pluck('id')->random();
            if ($following == $follower || $follower == 1 || $following == 1) {
                continue;
            }
            FollowerUser::firstOrCreate([
                'follower_id' => $following,
                'following_id' => $follower,
                'accepted_at' => Carbon::now(),
            ]);
            $createCount--;
        }
    }
}
