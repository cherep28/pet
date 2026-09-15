<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'slug' => fake()->unique()->slug(),
            'summary' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'image_url' => null,
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
