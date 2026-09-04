<?php

namespace Database\Seeders;

use App\Models\DataPasar;
use App\Models\DataPelataran;
use Illuminate\Database\Seeder;

class PelataranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasarBunda = DataPasar::where('nama_pasar', 'PASAR BUNDA SRI MERSING')->first();
        $pasarKelakap = DataPasar::where('nama_pasar', 'PASAR KELAKAP TUJUH')->first();

        $pelataranList = [];
        $pelataranCounter = 1;
        $now = now();

        // 1. PASAR BUNDA SRI MERSING (49 Pelataran)
        if ($pasarBunda) {
            for ($i = 1; $i <= 49; $i++) {
                $pelataranList[] = [
                    'nomor_pelataran' => sprintf('P-%02d', $pelataranCounter++),
                    'ukuran_pelataran' => '2x3 m',
                    'harga_sewa' => 5000.00,
                    'satuan_retribusi' => 'hari',
                    'status_pelataran' => 'tetap',
                    'lokasi_pelataran' => 'Pelataran Depan No. '.$i,
                    'pasar_id' => $pasarBunda->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 2. PASAR KELAKAP TUJUH (54 Pelataran)
        if ($pasarKelakap) {
            for ($i = 1; $i <= 54; $i++) {
                $pelataranList[] = [
                    'nomor_pelataran' => sprintf('P-%02d', $pelataranCounter++),
                    'ukuran_pelataran' => '2x3 m',
                    'harga_sewa' => 5000.00,
                    'satuan_retribusi' => 'hari',
                    'status_pelataran' => 'tetap',
                    'lokasi_pelataran' => 'Pelataran Barat No. '.$i,
                    'pasar_id' => $pasarKelakap->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DataPelataran::truncate();

        foreach (array_chunk($pelataranList, 100) as $chunk) {
            DataPelataran::insert($chunk);
        }
    }
}
