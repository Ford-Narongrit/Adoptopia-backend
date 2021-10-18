<?php

namespace Database\Factories;

use App\Models\Adopt;
use App\Models\AdoptImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AdoptImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdoptImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $path = "/storage/default/adop.jpg";

        return [
            //
            'adopt_id' =>  Adopt::get()->pluck('id')->random(),
            'path' => $path,
            'type' => "image/jpeg",
            'size' => 15972,
            'width' => 453,
            'height' => 350,

        ];
    }
}
