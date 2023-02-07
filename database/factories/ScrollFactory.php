<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scroll>
 */
class ScrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slide_id' => function () {
                return factory(Slide::class)->create()->id;
            },
            "left" => fake()->numberBetween(1, 1024),
            "top" => fake()->numberBetween(1, 1024),
            "width" => fake()->numberBetween(50, 200),
            "height" => fake()->numberBetween(50, 200),
            'image_id' => function () {
                return factory(Image::class)->create()->id;
            }
        ];
    }
}
