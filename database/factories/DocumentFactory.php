<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->word,
            "format" => Document::FORMAT_PDF, // $faker->mimeType,
            "project_id" => Project::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
