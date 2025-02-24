<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('truck_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')->constrained()->onDelete('cascade');
            //driver id
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade'); // Pengemudi
            //report date datetime
            $table->dateTime('report_date');
            //engine status = good, maintenance, 
            $table->enum('engine_status', ['good', 'maintenance', 'repair']);
            //tires status
            $table->enum('tires_status', ['good', 'maintenance', 'repair']);
            //oil status
            $table->enum('oil_status', ['good', 'maintenance', 'repair']);
            //brakes status
            $table->enum('brakes_status', ['good', 'maintenance', 'repair']);
            //lights status
            $table->enum('lights_status', ['good', 'maintenance', 'repair']);
            //battery status
            $table->enum('battery_status', ['good', 'maintenance', 'repair']);
            //coolant status
            $table->enum('coolant_status', ['good', 'maintenance', 'repair']);
            //transmission status
            $table->enum('transmission_status', ['good', 'maintenance', 'repair']);
            //steering status
            $table->enum('steering_status', ['good', 'maintenance', 'repair']);
            //suspension status
            $table->enum('suspension_status', ['good', 'maintenance', 'repair']);
            //fuel status
            $table->enum('fuel_status', ['full', 'half', 'low']);
            //notes
            $table->text('notes')->nullable();
            //approval status
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null'); // Admin/Manajer yang menyetujui
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_reports');
    }
};
