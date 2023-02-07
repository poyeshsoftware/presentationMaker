<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'address' => fake()->imageUrl, //fake()->imageUrl(640, 480, 'sport'),
            'file_name' => fake()->slug . '.jpg', //fake()->imageUrl(640, 480, 'sport'),
            'project_id' => Project::factory(),
            'parent_id' => null,
            'alt' => fake()->name(), //fake()->imageUrl(640, 480, 'sport'),
            'image_dimension_id' => null,
            'width' => fake()->numberBetween(400, 1024),
            'height' => fake()->numberBetween(400, 1024),
            'type' => fake()->randomElement([
                Image::SRC_SLIDES,
                Image::SRC_SLIDE_THUMBNAIL
            ]),
            'format' => 'jpg',
        ];
    }
}
