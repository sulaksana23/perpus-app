<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => 'BK-'.fake()->unique()->numerify('####'),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'publisher' => fake()->company(),
            'category_id' => Category::factory(),
            'rack' => 'R'.fake()->randomDigitNotNull().'-'.fake()->randomDigitNotNull(),
            'description' => fake()->paragraph(),
            'isbn' => fake()->isbn13(),
            'stock' => fake()->numberBetween(1, 20),
            'status' => 'tersedia',
            'price' => fake()->numberBetween(30000, 100000),
            'published_year' => fake()->numberBetween(2014, 2026),
            'avg_rating' => fake()->randomFloat(1, 3, 5),
            'popular_score' => fake()->numberBetween(1, 500),
        ];
    }
}
