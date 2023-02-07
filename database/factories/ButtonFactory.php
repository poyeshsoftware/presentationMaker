<?php

namespace Database\Factories;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Button>
 */
class ButtonFactory extends Factory
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
            "type" => 0,
            "link_slide_id" => Slide::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
