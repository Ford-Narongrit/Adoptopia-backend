<?php

namespace Tests\Feature;

use App\Models\Adopt;
use App\Models\Notification;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sale_notification()
    {
        // saleNotification;

        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $adopt = Adopt::factory()->create(['user_id' => $user->id]);
        $trade = Trade::factory()->create(['user_id'=>$user2->id , 'adopt_id' => $adopt->id]);
        // $trade->user_id = $user2->id;
        $response = $this->actingAs($user, 'api')->post("/api/notification/sale-notification/{$trade->id}", [
            'text' => 'test notification',
            'owner_id' => $user->id,
            'user_id' => $trade->user_id,
            'trade_id' => $trade->id,
            'images' => [file_get_contents(storage_path('/app/public/default/adop.jpg'))],
        ]);

        $response->assertStatus(201);
    }
    public function test_update_status()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        Notification::factory()->create(['user_id' =>  $user2->id , 'owner_id' => $user->id]);
        $response = $this->actingAs($user2, 'api')->put("/api/notification/me/updateStatus");

        $response->assertStatus(200);
    }
}
