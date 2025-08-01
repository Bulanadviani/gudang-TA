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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_rak')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('kode_material')->nullable();
            $table->foreignId('merk_id')->nullable()->constrained('merk')->onDelete('set null');
            $table->string('spesifikasi')->nullable();
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('set null');
            $table->foreignId('keadaan_id')->nullable()->constrained('keadaan')->onDelete('set null');
            $table->foreignId('lokasi_id')->nullable()->constrained('lokasi')->onDelete('set null');
            $table->foreignId('status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
