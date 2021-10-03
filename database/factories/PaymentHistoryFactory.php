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
        return [
            'description' => $this->faker->realText(30),
            'status' => $this->faker->randomElement(['deposit', 'withdraw']),
            'amount' => $this->faker->randomFloat($decimals = 2, $min = 500, $max = 15000),
            'user_id' => User::get()->pluck('id')->random(),
        ];
    }
}
