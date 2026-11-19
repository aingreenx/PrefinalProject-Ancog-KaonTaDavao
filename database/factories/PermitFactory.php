<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Permit>
 */
class PermitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id' => Eatery::factory(),
            'permit_no' => 'DVO-' . fake()->unique()->numerify('####-####'),
            'expires_on' => fake()->dateTimeBetween('-6 months', '+2 years'),
        ];
    }
}
