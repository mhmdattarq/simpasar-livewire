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
        Schema::create('data_los', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_los')->unique();
            $table->string('ukuran_los')->nullable();
            $table->decimal('harga_sewa', 12, 2)->nullable();
            $table->enum('satuan_retribusi', ['hari', 'bulan', 'tahun'])->default('hari');
            $table->enum('status_los', ['tersedia', 'terisi', 'pengajuan'])->default('tersedia');
            $table->string('lokasi_los')->nullable();
            $table->foreignId('pasar_id')->constrained('data_pasars')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_los');
    }
};
