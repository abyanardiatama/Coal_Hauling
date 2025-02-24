<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SparePart>
 */
class SparePartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'name' => $this->faker->word(),
            'part_number' => $this->faker->unique()->randomNumber(5, true),
            'stock' => $this->faker->numberBetween(1, 100),
            'category' => $this->faker->randomElement(['engine', 'tires', 'oil', 'brakes', 'lights', 'battery', 'coolant', 'transmission', 'steering', 'suspension']),
            'stock' => $this->faker->numberBetween(50, 100),
            'min_stock' => $this->faker->numberBetween(1, 50),
            'price' => $this->faker->randomFloat(2, 2000, 10000),
        ];
    }
}
