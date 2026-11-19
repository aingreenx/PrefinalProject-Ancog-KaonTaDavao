<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'name' => fake()->randomElement(['Tinola', 'Adobo', 'Sinigang', 'Kinilaw', 'Pancit', 'Lumpia', 'Lechon Kawali', 'Ginataang Gulay']),
            'price' => fake()->randomFloat(2, 30, 350),
            'is_bestseller' => fake()->boolean(25),
        ];
    }
}
