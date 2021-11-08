<?php

namespace Tests\Feature;

use App\Models\FollowerUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserTest extends TestCase
{


    protected static $db_init = false;

    /**
     * A basic feature test example.
     *
     * test feature (method)
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        if (!self::$db_init) {
            $this->artisan("migrate:fresh", [
                '--database' => 'mysql_testing',
                '--force' => true,
                '--seed' => true
            ]);
            self::$db_init = true;
        }
    }

    public function test_register()
    {
        $response = $this->post('/api/auth/register', [
            'username' => "test03",
            'password' => "secret123",
            "password_confirmation" => "secret123",
            "name" => "forddd",
            "email" => "user03@webtect.ku"
        ]);

        $response->assertStatus(201);
    }

    public function test_login()
    {
        $user = User::factory()->create(['password' => bcrypt('secret123')]);
        $response = $this->post('/api/auth/login', [
            'validate' => $user->username,
            'password' => "secret123"
        ]);

        $response->assertStatus(200);
    }

    public function test_admin_ban()
    {
        $user = User::factory()->create();
        $admin = User::where('role', 'ADMIN')->first();
        $response = $this->actingAs($admin, 'api')->post('/api/ban', [
            'id' => $user->id
        ]);
        $user = $user->fresh();
        $this->assertNotNull($user->banned);
    }


    public function test_admin_unban()
    {
        $user = User::factory()->create(['banned' => Carbon::now()]);
        $admin = User::where('role', 'ADMIN')->first();
        $response = $this->actingAs($admin, 'api')->post('/api/unban', [
            'id' => $user->id
        ]);
        $user = $user->fresh();
        $this->assertNull($user->banned);
    }

    public function test_user_follow()
    {
        $user = User::factory()->create();
        $user_follow_count = $user->following()->count();
        $user2 = User::factory()->create();
        $response = $this->actingAs($user, 'api')->post("/api/follow/{$user2->id}");


        $this->assertEquals($user_follow_count + 1, User::where('id', $user->id)->with('following')->count());
    }

    public function test_user_unfollow()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $response = $this->actingAs($user, 'api')->post("/api/follow/{$user2->id}");
        $user_follow_count = $user->following()->count();
        $response = $this->actingAs($user, 'api')->delete("/api/follow/{$user2->id}");

        $this->assertEquals($user_follow_count - 1, $user->following()->count());
    }
}
