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
        Schema::create('shipment_permits', function (Blueprint $table) {
            $table->id();
            $table->string('permit_number')->unique();
            $table->foreignId('truck_id')->references('id')->on('trucks')->cascadeOnDelete();
            $table->foreignId('driver_id')->references('id')->on('users')->cascadeOnDelete();

            $table->string('third_party_email');

            $table->dateTime('shipment_date');
            $table->string('shipment_from');
            $table->string('shipment_to');
            $table->string('shipment_type');
            $table->enum('shipment_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_permits');
    }
};
