<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Eatery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'user_id' => User::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'body' => fake()->sentence(12),
            'created_at' => fake()->dateTimeBetween('-6 months', '-1 day'),
        ];
    }
}
