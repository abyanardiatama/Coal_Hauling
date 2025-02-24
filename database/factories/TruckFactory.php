<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Truck>
 */
class TruckFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'plate_number' => strtoupper($this->faker->bothify('B #### ??')), // ✅ B 1234 XY
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'last_maintenance' => $this->faker->date(),
            'brand' => $this->faker->word,
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
