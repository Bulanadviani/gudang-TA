<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->date('tanggal_masuk')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('masuk');
    }
};
