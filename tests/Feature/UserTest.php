<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
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

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login()
    {
        $user = User::first();
        $response = $this->post('/api/auth/login', [
            'validate' => $user->username,
            'password' => "secret123"
        ]);

        $response->assertStatus(200);
    }

    public function test_register()
    {
        $response = $this->post('/api/auth/register', [
            'username' => "test03",
            'password' => "Ff_09107832",
            "password_confirmation" => "Ff_09107832",
            "name" => "forddd",
            "email" => "user03@webtect.ku"
        ]);

        $response->assertStatus(201);
    }
}
