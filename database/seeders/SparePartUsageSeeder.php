<?php

namespace Database\Seeders;

use App\Models\SparePartUsage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SparePartUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SparePartUsage::factory(10)->create();
    }
}
