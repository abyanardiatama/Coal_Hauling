<?php

namespace Database\Seeders;

use App\Models\RestockRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestockRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestockRequest::factory(10)->create();
    }
}
