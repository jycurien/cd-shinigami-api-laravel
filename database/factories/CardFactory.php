<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => 'material',
            'center_code' => 124,
            'card_code' => $this->faker->unique()->numberBetween(100000, 200000),
            'check_sum' => $this->faker->numberBetween(0, 9), // TODO replace with checksum calculation
            'activated_at' => null,
        ];
    }
}
