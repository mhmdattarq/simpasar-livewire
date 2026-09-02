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
        Schema::table('data_kios', function (Blueprint $table) {
            $table->enum('satuan_retribusi', ['hari', 'bulan', 'tahun'])->default('hari')->after('harga_sewa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_kios', function (Blueprint $table) {
            $table->dropColumn('satuan_retribusi');
        });
    }
};
