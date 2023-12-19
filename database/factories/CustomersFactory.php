<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
            return [
                'name' => fake()->name(),
                'address' => fake()->streetAddress(),
                'phone_no' => fake()->randomNumber($nbDigits = 9),
                'is_notified' => 0,
                'is_pwd_changed' => 0,
                'is_activated' => 0,
                'country_id' => 2
            ];
    }
}
