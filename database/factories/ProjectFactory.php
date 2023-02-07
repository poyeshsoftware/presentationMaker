<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $name = fake()->name;
        $userId = User::factory();

        return [
            'user_id' => $userId,
            'project_user_id' => $userId,
            'name' => $name . " Project",
            'slug' => Str::slug($name, '-'),
        ];
    }
}
