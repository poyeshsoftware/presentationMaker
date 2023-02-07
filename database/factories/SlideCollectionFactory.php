<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SlideCollection>
 */
class SlideCollectionFactory extends Factory
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
            'project_id' => function () {
                return factory(Project::class)->create()->id;
            },
            "order_num" => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
