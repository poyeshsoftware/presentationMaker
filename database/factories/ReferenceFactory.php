<?php

namespace Database\Factories;

use App\Models\Reference;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reference>
 */
class ReferenceFactory extends Factory
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
            "prefix" => "",
            "text" => fake()->text,
            "type" => Reference::TYPE_TEXT,
            "order_num" => 0
        ];

    }
}
