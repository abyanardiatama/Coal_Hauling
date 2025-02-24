<?php

namespace Database\Seeders;

use App\Models\RestockRequest;
use App\Models\SparePart;
use App\Models\SparePartUsage;
use App\Models\Supplier;
use App\Models\Training;
use App\Models\TrainingUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Truck::factory(10)->create();
        \App\Models\TruckReport::factory(10)->create();
        \App\Models\ShipmentPermit::factory(10)->create();

        SparePart::factory(10)->create();
        Supplier::factory(10)->create();
        SparePartUsage::factory(10)->create();
        RestockRequest::factory(10)->create();

        Training::factory(10)->create();
        TrainingUser::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Driver',
            'email' => 'driver@mail.com',
            'role' => 'driver',
        ]);
    }
}
