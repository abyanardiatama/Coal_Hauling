<?php

namespace Database\Factories;

use App\Models\SparePart;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestockRequest>
 */
class RestockRequestFactory extends Factory
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
            'spare_part_id' => SparePart::factory(),
            'requested_by' => User::factory(['role' => 'admin']),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'requested_quantity' => $this->faker->numberBetween(1, 100),
            'date_requested' => $this->faker->date(),
        ];
    }
}
