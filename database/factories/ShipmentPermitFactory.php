<?php

namespace Database\Factories;

use App\Models\Truck;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentPermit>
 */
class ShipmentPermitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permit_number' => 'CH-'. $this->faker->unique()->randomNumber(5, true),
            'truck_id' => Truck::factory(),
            'driver_id' => User::factory(['role' => 'driver']),
            'third_party_email' => $this->faker->email(),
            'shipment_date' => $this->faker->date(),
            'shipment_from' => $this->faker->city(),
            'shipment_to' => $this->faker->city(),
            'shipment_type' => $this->faker->randomElement(['export', 'import']),
            'shipment_status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'file_path' => 'storage/shipment_permits/' . $this->faker->uuid . '.pdf',
        ];
    }
}
