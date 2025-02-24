<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Truck;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TruckReport>
 */
class TruckReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'truck_id' => Truck::factory(),
            'driver_id' => User::factory(['role' => 'driver']),
            'report_date' => $this->faker->date(),
            'engine_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'tires_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'oil_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'brakes_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'lights_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'battery_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'coolant_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'transmission_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'steering_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'suspension_status' => $this->faker->randomElement(['good', 'maintenance', 'repair']),
            'fuel_status' => $this->faker->randomElement(['full', 'half', 'low']),
            'notes' => $this->faker->sentence,
            'approval_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'approved_by' => User::factory(['role' => 'admin']),
        ];
    }
}
