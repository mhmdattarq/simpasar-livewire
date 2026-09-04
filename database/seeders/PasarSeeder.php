<?php

namespace Database\Seeders;

use App\Models\DataPasar;
use Illuminate\Database\Seeder;

class PasarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pasars = [
            [
                'nama_pasar' => 'PASAR BUNDA SRI MERSING',
                'alamat_pasar' => 'Jl. Dock Yard, Kel. Pangkalan Sesai, Kec. Dumai Barat, Kota Dumai',
                'total_kios' => 46,
                'total_los' => 504,
                'total_pelataran' => 49,
                'foto_depan' => 'pasar/pasar_bunda_sri_mersing_depan.jpg',
                'foto_dalam' => 'pasar/pasar_bunda_sri_mersing_dalam.jpg',
                'foto_belakang' => 'pasar/pasar_bunda_sri_mersing_belakang.jpg',
                'lokasi_peta' => '<iframe src="https://maps.google.com/maps?q=Dumai&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama_pasar' => 'PASAR KELAKAP TUJUH',
                'alamat_pasar' => 'Jl. Kelakap Tujuh, Kel. Simpang Tetap Darul Ihsan, Kec. Dumai Barat, Kota Dumai',
                'total_kios' => 121,
                'total_los' => 284,
                'total_pelataran' => 54,
                'foto_depan' => 'pasar/pasar_kelakap_tujuh_depan.jpg',
                'foto_dalam' => 'pasar/pasar_kelakap_tujuh_dalam.jpg',
                'foto_belakang' => 'pasar/pasar_kelakap_tujuh_belakang.jpg',
                'lokasi_peta' => '<iframe src="https://maps.google.com/maps?q=Dumai&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
            [
                'nama_pasar' => 'PASAR TAMAN LEPIN',
                'alamat_pasar' => 'Jl. Sultan Syarif Kasim, Kel. Teluk Binjai, Kec. Dumai Timur, Kota Dumai',
                'total_kios' => 101,
                'total_los' => 102,
                'total_pelataran' => 0,
                'foto_depan' => 'pasar/pasar_taman_lepin_depan.jpg',
                'foto_dalam' => 'pasar/pasar_taman_lepin_dalam.jpg',
                'foto_belakang' => 'pasar/pasar_taman_lepin_belakang.jpg',
                'lokasi_peta' => '<iframe src="https://maps.google.com/maps?q=Dumai&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            ],
        ];

        foreach ($pasars as $pasar) {
            DataPasar::updateOrCreate(
                ['nama_pasar' => $pasar['nama_pasar']],
                $pasar
            );
        }
    }
}
