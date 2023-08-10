<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
            //
            'name' => fake()->name,
            'description' => fake()->paragraph,
            'price' => fake()->randomFloat(2, 100, 9999.99),
            'image' => fake()->imageUrl(),
            'city_id' => City::all()->random()->id,
            'rooms' => fake()->numberBetween(1,6),
        ];
    }
}
