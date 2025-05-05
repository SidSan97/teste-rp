<?php

namespace Database\Factories;

use App\Utils\GenerateSkuUtility;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(100),
            'quantity' => fake()->numberBetween(0, 1000),
            'price' => fake()->randomFloat(2, 51, 500),
            'category' => fake()->word(),
            'sku' => GenerateSkuUtility::generateSKU(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
