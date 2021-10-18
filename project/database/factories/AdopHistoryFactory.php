<?php

namespace Database\Factories;

use App\Models\AdopHistory;
use App\Models\Adopt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdopHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdopHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = $this->faker->randomElement(['OTA', 'DTA']);
        if($status == 'DTA') {
            $adopt_id = $this->faker->boolean(50) ? Adopt::get()->pluck('id')->random() : null;
            if($adopt_id)
                $trans_adopt = null;
            else 
                $trans_adopt = Adopt::get()->pluck('id')->random();
        }
        if($status == 'OTA') {
            $adopt_id = Adopt::get()->pluck('id')->random();
            $trans_adopt = Adopt::get()->pluck('id')->random();
        }
        
        return [
            'status' => $status,
            'user_id' => User::get()->pluck('id')->random(),
            'trans_user' => User::get()->pluck('id')->random(),
            'adopt_id' => $adopt_id,
            'trans_adopt' => $trans_adopt,
        ];
    }
}
