<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
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
            'project_id' => function () {
                return factory(Project::class)->create()->id;
            },
            "type" => fake()->randomElement([Menu::TYPE_SIDEBAR, Menu::TYPE_BOTTOM_MENU]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
