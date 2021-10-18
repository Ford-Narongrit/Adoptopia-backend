<?php

namespace Database\Factories;

use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $trans_user = $this->faker->boolean(50) ? User::get()->pluck('id')->random() : null;
        if($trans_user){
            $status = $this->faker->randomElement(['earn', 'spend']);
        } else {
            $status = $this->faker->randomElement(['deposit', 'withdraw']);
        }
        return [
            // 'post_id' => Post::get()->pluck('id')->random(),
            'status' => $status,
            'amount' => $this->faker->randomFloat($decimals = 2, $min = 500, $max = 15000),
            'user_id' => User::get()->pluck('id')->random(),
            'trans_user' => $trans_user,
        ];
    }
}
