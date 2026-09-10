<?php

use App\Enums\Role;
use App\Livewire\Admin\DashboardIndex;
use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPedagang;
use App\Models\DataPelataran;
use App\Models\DataPermohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->adminUser = User::factory()->create([
        'name' => 'Admin Utama',
        'nik' => '1472010101800001',
        'role' => Role::Admin,
    ]);

    $this->pedagangUser = User::factory()->create([
        'name' => 'Budi Santoso',
        'nik' => '1472010101900001',
        'role' => Role::Pedagang,
    ]);

    DataPedagang::create([
        'user_id' => $this->pedagangUser->id,
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman No. 1, Dumai',
    ]);

    $this->pasar = DataPasar::create([
        'nama_pasar' => 'Pasar Kelakap Tujuh',
        'alamat_pasar' => 'Jl. Kelakap Tujuh, Dumai Barat',
        'total_kios' => 10,
        'total_los' => 5,
        'total_pelataran' => 5,
        'foto_depan' => 'pasar/depan.jpg',
        'foto_dalam' => 'pasar/dalam.jpg',
        'foto_belakang' => 'pasar/belakang.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);

    // Kios: 1 terisi, 1 pengajuan, 1 tersedia
    DataKios::create([
        'pasar_id' => $this->pasar->id,
        'nomor_kios' => 'K-01',
        'ukuran_kios' => '3x3',
        'harga_sewa' => 500000,
        'status_kios' => 'terisi',
        'lokasi_kios' => 'Lantai 1',
    ]);
    DataKios::create([
        'pasar_id' => $this->pasar->id,
        'nomor_kios' => 'K-02',
        'ukuran_kios' => '3x3',
        'harga_sewa' => 500000,
        'status_kios' => 'pengajuan',
        'lokasi_kios' => 'Lantai 1',
    ]);
    DataKios::create([
        'pasar_id' => $this->pasar->id,
        'nomor_kios' => 'K-03',
        'ukuran_kios' => '3x3',
        'harga_sewa' => 500000,
        'status_kios' => 'tersedia',
        'lokasi_kios' => 'Lantai 1',
    ]);

    // Los: 1 terisi, 1 pengajuan, 1 tersedia
    DataLos::create([
        'pasar_id' => $this->pasar->id,
        'nomor_los' => 'L-01',
        'ukuran_los' => '2x2',
        'harga_sewa' => 250000,
        'status_los' => 'terisi',
        'lokasi_los' => 'Blok B',
    ]);
    DataLos::create([
        'pasar_id' => $this->pasar->id,
        'nomor_los' => 'L-02',
        'ukuran_los' => '2x2',
        'harga_sewa' => 250000,
        'status_los' => 'pengajuan',
        'lokasi_los' => 'Blok B',
    ]);
    DataLos::create([
        'pasar_id' => $this->pasar->id,
        'nomor_los' => 'L-03',
        'ukuran_los' => '2x2',
        'harga_sewa' => 250000,
        'status_los' => 'tersedia',
        'lokasi_los' => 'Blok B',
    ]);

    // Pelataran: 3 unit
    DataPelataran::create([
        'pasar_id' => $this->pasar->id,
        'nomor_pelataran' => 'P-01',
        'ukuran_pelataran' => '2x1',
        'harga_sewa' => 100000,
        'status_pelataran' => 'tetap',
        'lokasi_pelataran' => 'Halaman Barat',
    ]);
    DataPelataran::create([
        'pasar_id' => $this->pasar->id,
        'nomor_pelataran' => 'P-02',
        'ukuran_pelataran' => '2x1',
        'harga_sewa' => 100000,
        'status_pelataran' => 'tetap',
        'lokasi_pelataran' => 'Halaman Barat',
    ]);
    DataPelataran::create([
        'pasar_id' => $this->pasar->id,
        'nomor_pelataran' => 'P-03',
        'ukuran_pelataran' => '2x1',
        'harga_sewa' => 100000,
        'status_pelataran' => 'tetap',
        'lokasi_pelataran' => 'Halaman Barat',
    ]);

    // Permohonan untuk pelataran: 1 selesai (terisi), 1 lengkap (pengajuan)
    DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman',
        'pasar_id' => $this->pasar->id,
        'tipe_tempat' => 'pelataran',
        'nomor_tempat' => 'P-01',
        'status' => 'selesai',
    ]);

    DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman',
        'pasar_id' => $this->pasar->id,
        'tipe_tempat' => 'pelataran',
        'nomor_tempat' => 'P-02',
        'status' => 'lengkap',
    ]);
});

test('admin dapat mengakses dashboard dan melihat statistik dinamis', function () {
    $this->actingAs($this->adminUser)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Data Pasar')
        ->assertSee('Data Kios')
        ->assertSee('Data Los')
        ->assertSee('Data Pelataran')
        ->assertSee('Data Permohonan')
        ->assertSee('Akses Cepat Modul')
        ->assertSee(route('admin.pasar.data'))
        ->assertSee(route('admin.kios.data'))
        ->assertSee(route('admin.los.data'))
        ->assertSee(route('admin.pelataran.data'))
        ->assertSee(route('admin.permohonan.data'));
});

test('livewire dashboard admin menghitung statistik kios, los, dan pelataran dengan tepat', function () {
    Livewire::actingAs($this->adminUser)
        ->test(DashboardIndex::class)
        ->assertViewHas('totalPasar', 1)
        ->assertViewHas('totalPedagang', 1)
        ->assertViewHas('totalPermohonan', 2)
        ->assertViewHas('kios', function ($kios) {
            return $kios['total'] === 3
                && $kios['terisi'] === 1
                && $kios['pengajuan'] === 1
                && $kios['kosong'] === 1;
        })
        ->assertViewHas('los', function ($los) {
            return $los['total'] === 3
                && $los['terisi'] === 1
                && $los['pengajuan'] === 1
                && $los['kosong'] === 1;
        })
        ->assertViewHas('pelataran', function ($pelataran) {
            return $pelataran['total'] === 3
                && $pelataran['terisi'] === 1
                && $pelataran['pengajuan'] === 1
                && $pelataran['kosong'] === 1;
        });
});
