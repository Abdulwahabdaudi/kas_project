<?php

namespace Database\Factories;

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
           'name' => fake()->word(),
           'quantity' =>fake()->randomNumber(3),
           'price' =>fake()->randomFloat(2,1000,10000),
           'category' => $this->faker->randomElement(['Fertilizers', 'Seeds', 'Tools', 'Pests']),
           'description' =>fake()->sentence(),
        ];
    }
}
