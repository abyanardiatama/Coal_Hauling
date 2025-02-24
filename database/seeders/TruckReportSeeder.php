<?php

namespace Database\Seeders;

use App\Models\TruckReport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TruckReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TruckReport::factory(10)->create();
    }
}
