<?php

namespace Database\Factories;

use App\Models\MenuCategory;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name,
            'link_slide_id' => function () {
                return factory(Slide::class)->create()->id;
            },
            'type' => 0,
            'style' => "",
            'menu_category_id' => function () {
                return factory(MenuCategory::class)->create()->id;
            },
            "order_num" => 0,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
