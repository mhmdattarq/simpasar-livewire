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
        Schema::create('data_pelatarans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pelataran')->unique();
            $table->string('ukuran_pelataran')->nullable();
            $table->decimal('harga_sewa', 12, 2)->nullable();
            $table->enum('satuan_retribusi', ['hari', 'bulan', 'tahun'])->default('hari');
            $table->enum('status_pelataran', ['tetap', 'tidaktetap', 'insidentil'])->default('tetap');
            $table->string('lokasi_pelataran')->nullable();
            $table->foreignId('pasar_id')->constrained('data_pasars')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pelatarans');
    }
};
