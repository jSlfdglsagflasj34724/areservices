<?php

namespace Database\Factories;

use App\Models\AssetType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'brand_name' => Str::studly(fake()->word()),
            'asset_type_id' => AssetType::factory(),
            'serial_number' => fake()->numberBetween($min = 10000, $max = 90000),
            'model' => fake()->sentence(1),
            'barcode_url' => fake()->url(),
            'year' => fake()->year($max = 'now'),
            'other_asset_type' => null,
            'company_name' => fake()->company(),
            'location' => fake()->city(),
            'landmark' => fake()->sentence(1),
            'asset_tag' => fake()->randomNumber($nbDigits = 6),
        ];
    }
}
