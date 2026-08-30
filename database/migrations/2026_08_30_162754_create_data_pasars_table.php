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
        Schema::create('data_pasars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasar')->unique();
            $table->text('alamat_pasar'); 
            $table->integer('total_kios')->default(0);
            $table->integer('total_los')->default(0);
            $table->integer('total_pelataran')->default(0);
            $table->string('foto_depan');
            $table->string('foto_dalam');
            $table->string('foto_belakang');
            $table->text('lokasi_peta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pasars');
    }
};
