<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\SlideCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name;
        return [
            'name' => $name,
            'slug' => fake()->slug($name),
            'slide_collection_id' => function () {
                return factory(SlideCollection::class)->create()->id;
            },
            "parent_id" => 0,
            'image_id' => function () {
                return factory(Image::class)->create()->id;
            },
            "slide_type" => 0,
            "order_num" => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
