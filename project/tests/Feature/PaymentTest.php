<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_deposit()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'api')->put("/api/deposit", [
            'amount' =>  1000
        ]);

        $response->assertStatus(200);
    }

    public function test_withdraw()
    {
        $user = User::factory()->create(['coin' => 1000]);
        $response = $this->actingAs($user, 'api')->put("/api/withdraw", [
            'amount' =>  1000
        ]);

        $response->assertStatus(200);
    }

}
