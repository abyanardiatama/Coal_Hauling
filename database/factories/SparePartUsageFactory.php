<?php

namespace Database\Factories;

use App\Models\SparePart;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SparePartUsage>
 */
class SparePartUsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'spare_part_id' => SparePart::factory(),
            'truck_id' => Truck::factory(),
            'user_id' => User::factory(['role' => 'driver']),
            'quantity_used' => $this->faker->numberBetween(1, 10),
            'date_used' => $this->faker->date(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
