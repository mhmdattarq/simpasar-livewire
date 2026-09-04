<?php

namespace Database\Seeders;

use App\Models\DataLos;
use App\Models\DataPasar;
use Illuminate\Database\Seeder;

class LosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasarBunda = DataPasar::where('nama_pasar', 'PASAR BUNDA SRI MERSING')->first();
        $pasarKelakap = DataPasar::where('nama_pasar', 'PASAR KELAKAP TUJUH')->first();
        $pasarLepin = DataPasar::where('nama_pasar', 'PASAR TAMAN LEPIN')->first();

        $losList = [];
        $losCounter = 1;
        $now = now();

        // 1. PASAR BUNDA SRI MERSING (504 Los)
        if ($pasarBunda) {
            for ($i = 1; $i <= 504; $i++) {
                $losList[] = [
                    'nomor_los' => sprintf('L-%02d', $losCounter++),
                    'ukuran_los' => '2x2 m',
                    'harga_sewa' => 150000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_los' => 'tersedia',
                    'lokasi_los' => 'Los Blok A No. '.$i,
                    'pasar_id' => $pasarBunda->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 2. PASAR KELAKAP TUJUH (284 Los)
        if ($pasarKelakap) {
            for ($i = 1; $i <= 284; $i++) {
                $losList[] = [
                    'nomor_los' => sprintf('L-%02d', $losCounter++),
                    'ukuran_los' => '2x2 m',
                    'harga_sewa' => 150000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_los' => 'tersedia',
                    'lokasi_los' => 'Los Blok B No. '.$i,
                    'pasar_id' => $pasarKelakap->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // 3. PASAR TAMAN LEPIN (102 Los)
        if ($pasarLepin) {
            for ($i = 1; $i <= 102; $i++) {
                $losList[] = [
                    'nomor_los' => sprintf('L-%02d', $losCounter++),
                    'ukuran_los' => '2x2 m',
                    'harga_sewa' => 150000.00,
                    'satuan_retribusi' => 'bulan',
                    'status_los' => 'tersedia',
                    'lokasi_los' => 'Los Blok C No. '.$i,
                    'pasar_id' => $pasarLepin->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DataLos::truncate();

        foreach (array_chunk($losList, 200) as $chunk) {
            DataLos::insert($chunk);
        }
    }
}
