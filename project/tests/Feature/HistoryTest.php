<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_adop_histories()
    {
        $user = User::factory()->create();
         $response = $this->actingAs($user, 'api')->post("/api/adop-histories/search",[
             'status' => "all",
             'dateFrom' => Carbon::now(),
             'dateTo' => '2021-11-9'

         ]);


        $response->assertStatus(200);
    }
    public function test_payment_histories()
    {
        $user = User::factory()->create();
         $response = $this->actingAs($user, 'api')->post("/api/payment-histories/search",[
             'status' => "All",
             'dateFrom' => Carbon::now(),
             'dateTo' => '2021-11-9'

         ]);


        $response->assertStatus(200);
    }
}
