<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuCategory>
 */
class MenuCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => fake()->name,
            'type' => 0,
            'style' => "",
            'link_slide_id' => function () {
                return factory(Slide::class)->create()->id;
            },
            'menu_id' => function () {
                return factory(Menu::class)->create()->id;
            },
            "order_num" => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
