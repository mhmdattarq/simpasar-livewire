<?php

use App\Enums\Role;
use App\Livewire\Landing\LandingIndex;
use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->pasarA = DataPasar::create([
        'nama_pasar' => 'Pasar Bunda Sri Mersing',
        'alamat_pasar' => 'Jl. Dock Yard, Dumai Barat',
        'total_kios' => 10,
        'total_los' => 20,
        'total_pelataran' => 5,
        'foto_depan' => 'pasar/depan_a.jpg',
        'foto_dalam' => 'pasar/dalam_a.jpg',
        'foto_belakang' => 'pasar/belakang_a.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);

    $this->pasarB = DataPasar::create([
        'nama_pasar' => 'Pasar Kelakap Tujuh',
        'alamat_pasar' => 'Jl. Kelakap Tujuh, Dumai',
        'total_kios' => 15,
        'total_los' => 25,
        'total_pelataran' => 10,
        'foto_depan' => 'pasar/depan_b.jpg',
        'foto_dalam' => 'pasar/dalam_b.jpg',
        'foto_belakang' => 'pasar/belakang_b.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);

    DataKios::create([
        'pasar_id' => $this->pasarA->id,
        'nomor_kios' => 'K-01',
        'ukuran_kios' => '3x3',
        'harga_sewa' => 500000,
        'status_kios' => 'tersedia',
        'lokasi_kios' => 'Lantai 1',
    ]);

    DataLos::create([
        'pasar_id' => $this->pasarA->id,
        'nomor_los' => 'L-01',
        'ukuran_los' => '2x2',
        'harga_sewa' => 250000,
        'status_los' => 'tersedia',
        'lokasi_los' => 'Blok A',
    ]);
});

test('pengunjung publik dapat mengakses halaman landing simpasar', function () {
    $this->get('/')
        ->assertSuccessful()
        ->assertSee('SIMPASAR')
        ->assertSee('Kota Dumai')
        ->assertSee('Ajukan Tempat Usaha')
        ->assertSee('Masuk')
        ->assertSee('Daftar');
});

test('komponen livewire landing index menampilkan statistik dan daftar pasar secara akurat', function () {
    Livewire::test(LandingIndex::class)
        ->assertViewHas('stats', function ($stats) {
            return $stats['total_pasar'] === 2
                && $stats['kios_tersedia'] === 1
                && $stats['los_tersedia'] === 1;
        })
        ->assertSee('Pasar Bunda Sri Mersing')
        ->assertSee('Pasar Kelakap Tujuh');
});

test('fitur pencarian pasar di landing page memfilter data pasar secara reaktif', function () {
    Livewire::test(LandingIndex::class)
        ->set('search', 'Kelakap')
        ->assertSee('Pasar Kelakap Tujuh')
        ->assertDontSee('Pasar Bunda Sri Mersing');
});

test('pengguna yang sudah login melihat tombol buka dashboard di navbar', function () {
    $pedagang = User::factory()->create([
        'role' => Role::Pedagang,
    ]);

    $this->actingAs($pedagang)
        ->get('/')
        ->assertSuccessful()
        ->assertSee('Buka Dashboard')
        ->assertSee(route('pedagang.dashboard'));
});
