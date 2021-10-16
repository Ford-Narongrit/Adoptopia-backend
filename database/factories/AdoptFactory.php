<?php

namespace Database\Factories;

use App\Models\Adopt;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdoptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Adopt::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [

            'name' => $name,
            'agreement' => $this->faker->realText(),
            'user_id' => User::get()->pluck('id')->random(),
            'status' => 0

        ];
    }
}
