<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->lastName() . "'s " . fake()->randomElement(['Carinderia', 'Eatery', 'Kainan', 'Sutukil', 'Grill']);

        return [
            'district_id' => District::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'address' => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty' => fake()->optional()->randomElement(['Tinola', 'Kinilaw', 'Sinuglaw', 'Pochero', 'Inihaw na Panga', 'Durian Shake']),
            'is_open' => true,
        ];
    }

    /** State: a closed eatery (is_open = false). */
    public function closed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_open' => false,
        ]);
    }
}
