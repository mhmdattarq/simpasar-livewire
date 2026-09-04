<?php

namespace Database\Seeders;

use App\Models\DataKios;
use App\Models\DataPasar;
use Illuminate\Database\Seeder;

class KiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasarBunda = DataPasar::where('nama_pasar', 'PASAR BUNDA SRI MERSING')->first();
        $pasarKelakap = DataPasar::where('nama_pasar', 'PASAR KELAKAP TUJUH')->first();
        $pasarLepin = DataPasar::where('nama_pasar', 'PASAR TAMAN LEPIN')->first();

        $kiosList = [];
        $kiosCounter = 1;
        $now = now();

        // 1. PASAR BUNDA SRI MERSING (46 Kios)
        if ($pasarBunda) {
            for ($i = 1; $i <= 46; $i++) {
                $kiosList[] = [
                    'nomor_kios' => sprintf('K-%02d', $kiosCounter++),
                    'ukuran_kios' => '3x4 m',
                    'harga_sewa' => 1200000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_kios' => 'tersedia',
                    'lokasi_kios' => 'Blok A No. '.$i,
                    'pasar_id' => $pasarBunda->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 2. PASAR KELAKAP TUJUH (121 Kios)
        if ($pasarKelakap) {
            for ($i = 1; $i <= 121; $i++) {
                $kiosList[] = [
                    'nomor_kios' => sprintf('K-%02d', $kiosCounter++),
                    'ukuran_kios' => '3x4 m',
                    'harga_sewa' => 1200000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_kios' => 'tersedia',
                    'lokasi_kios' => 'Blok B No. '.$i,
                    'pasar_id' => $pasarKelakap->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 3. PASAR TAMAN LEPIN (101 Kios)
        if ($pasarLepin) {
            for ($i = 1; $i <= 101; $i++) {
                $kiosList[] = [
                    'nomor_kios' => sprintf('K-%02d', $kiosCounter++),
                    'ukuran_kios' => '3x4 m',
                    'harga_sewa' => 1200000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_kios' => 'tersedia',
                    'lokasi_kios' => 'Blok C No. '.$i,
                    'pasar_id' => $pasarLepin->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DataKios::truncate();

        foreach (array_chunk($kiosList, 100) as $chunk) {
            DataKios::insert($chunk);
        }
    }
}
