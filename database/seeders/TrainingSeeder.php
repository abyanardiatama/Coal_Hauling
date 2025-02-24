<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Training;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $training = Training::factory()->create();
        $drivers = User::where('role', 'driver')->get();

        foreach ($drivers as $driver) {
            $training->drivers()->attach($driver->id, ['status' => 'null']);
        }
    }
}
