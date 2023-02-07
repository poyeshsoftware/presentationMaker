<?php

namespace Database\Factories;

use App\Models\Button;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Project;
use App\Models\Slide;
use App\Models\SlideCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrackingCode>
 */
class TrackingCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'slide_id' => Slide::factory(),
            "slide_collection_id" => null,
            "button_id" => null,
            "menu_category_id" => null,
            "menu_item_id" => null,
            "name" => fake()->slug,
        ];


    }

    /**
     * Indicate that the model's tracking code is for slide collection
     *
     * @return static
     */
    public function forCollection(): static
    {
        return $this->state(fn(array $attributes) => [
            'slide_id' => null,
            'slide_collection_id' => SlideCollection::factory(),
        ]);
    }

    /**
     * Indicate that the model's tracking code is for slide Button
     *
     * @return static
     */
    public function forButton(): static
    {
        return $this->state(fn(array $attributes) => [
            'slide_id' => null,
            'button_id' => Button::factory(),
        ]);
    }

    /**
     * Indicate that the model's tracking code is for MenuCategory
     *
     * @return static
     */
    public function forMenuCategory(): static
    {
        return $this->state(fn(array $attributes) => [
            'slide_id' => null,
            'menu_category_id' => MenuCategory::factory(),
        ]);
    }


    /**
     * Indicate that the model's tracking code is for MenuItem
     *
     * @return static
     */
    public function forMenuItem(): static
    {
        return $this->state(fn(array $attributes) => [
            'slide_id' => null,
            'menu_item_id' => MenuItem::factory(),
        ]);
    }
}
