<?php

namespace Database\Factories;

use App\Models\Adopt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdoptFactory extends Factory
{
    //TODO catagory
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
        $img =$this->faker->imageUrl($width = 200, $height = 200);
        $img2 = $this->faker->imageUrl($width = 200, $height = 200);
        $url =  $img.",".$img2;


        return [
            //
            'name' => $name,
            'image' => json_encode([
                $url
            ])
                ,
            'agreement' => $this->faker->realText(),
            'user' => User::get()->pluck('id')->random(),
            'category' => 1,

        ];
    }
}
