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
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete(); // Pemasok suku cadang
            $table->string('name'); // Nama suku cadang
            $table->string('part_number')->unique(); // Nomor bagian unik
            $table->string('category'); // Kategori (mesin, rem, ban, dll.)
            $table->integer('stock'); // Stok saat ini
            $table->integer('min_stock'); // Batas minimum stok
            $table->integer('price'); // Harga per unit
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};
