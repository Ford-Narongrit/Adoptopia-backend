<?php

namespace Tests\Feature;

use App\Models\Trade;
use App\Models\User;
use App\Models\Adopt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdopTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_adop()
    {
        $user = User::find(4);
        $adop_count = Adopt::count();
        $response = $this->actingAs($user, 'api')->post('/api/adopt', [
            'name' => 'cat white',
            'agreement' => 'ห้ามจำหน่าย',
            'category' => ['cat', 'animal'],
            'user_id' => $user->id,
            'images' => [file_get_contents(storage_path('/app/public/default/adop.jpg'))],
        ]);
        $this->assertEquals($adop_count + 1, Adopt::count());
    }

    public function test_transfer_adop()
    {
        $user = User::factory()->create();
        $adopt = Adopt::factory()->create(['user_id' => 3]);
        $response = $this->actingAs($user, 'api')->put("/api/adopt/transfer/{$adopt->id}/{$user->id}");
        $adopt = $adopt->fresh();
        $this->assertEquals($user->id, $adopt->user_id);
    }

    public function test_post_adop()
    {
        $user = User::factory()->create();
        $adopt = Adopt::factory()->create(['user_id' => $user->id]);
        $post_count = Trade::count();
        $response = $this->actingAs($user, 'api')->post('/api/trade', [
            'adopt_id' => $adopt->id,
            'type' => 'sale',
            'status' => 'on',
            'price' => 1000,
        ]);
        $this->assertEquals($post_count + 1, Trade::count());
    }
}
