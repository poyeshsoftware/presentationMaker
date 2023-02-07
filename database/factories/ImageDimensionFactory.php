<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\ImageDimension;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImageDimension>
 */
class ImageDimensionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'type' => fake()->randomElement([
                Image::SRC_SLIDE_THUMBNAIL,
                Image::SRC_SLIDES
            ]),
            "dimension_value" => 600,
            "second_dimension_value" => null,
            'mode' => ImageDimension::IMAGE_SCALE_BY_WIDTH // 0 > width , 1 > height , 2 > both dimensionImages
        ];
    }
}
