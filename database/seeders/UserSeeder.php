<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        if ($user == null){

            //init Admin
            $user = new User();
            $user->username = 'Admin';
            $user->password = bcrypt('Adm1nPas2worD');
            $user->role = 'admin';
            $user->name = "Admin Adoptopia";
            $user->email = "admin@adoptopia.com";
            $user->email_verified_at = now();
            $user->remember_token = Str::random(10);
            $user->save();

            User::factory()->count(10)->create();
        }
    }
}
