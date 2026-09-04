<?php

use App\Enums\Role;
use App\Livewire\Pedagang\AjukanPermohonan\AjukanPermohonanCreate;
use App\Models\DataKios;
use App\Models\DataPasar;
use App\Models\DataPedagang;
use App\Models\DataPermohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');

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
        'alamat' => 'Jl. Jenderal Sudirman No. 10, Dumai',
    ]);

    $this->adminUser = User::factory()->create([
        'name' => 'Admin Pasar',
        'nik' => '1472010101800001',
        'role' => Role::Admin,
    ]);

    $this->pasar = DataPasar::create([
        'nama_pasar' => 'Pasar Lepin',
        'alamat_pasar' => 'Jl. Lepin Jaya',
        'total_kios' => 10,
        'total_los' => 10,
        'total_pelataran' => 10,
        'foto_depan' => 'pasar/depan.jpg',
        'foto_dalam' => 'pasar/dalam.jpg',
        'foto_belakang' => 'pasar/belakang.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);

    $this->kios = DataKios::create([
        'pasar_id' => $this->pasar->id,
        'nomor_kios' => 'K-01',
        'ukuran_kios' => '3x3',
        'lokasi_kios' => 'Lantai 1 Blok A',
        'status_kios' => 'tersedia',
    ]);
});

test('tamu yang belum login diarahkan ke login saat mengakses ajukan permohonan', function () {
    $this->get(route('pedagang.ajukan_permohonan.create'))
        ->assertRedirect(route('login'));
});

test('admin tidak dapat mengakses halaman pedagang ajukan permohonan', function () {
    $this->actingAs($this->adminUser)
        ->get(route('pedagang.ajukan_permohonan.create'))
        ->assertForbidden();
});

test('pedagang dapat mengakses halaman ajukan permohonan dan data identitas terisi otomatis', function () {
    $this->actingAs($this->pedagangUser)
        ->get(route('pedagang.ajukan_permohonan.create'))
        ->assertSuccessful()
        ->assertSee('Ajukan Permohonan Tempat')
        ->assertSee('Budi Santoso')
        ->assertSee('1472010101900001');
});

test('komponen livewire ajukan permohonan memuat data profil pedagang dengan benar', function () {
    Livewire::actingAs($this->pedagangUser)
        ->test(AjukanPermohonanCreate::class)
        ->assertSet('nik', '1472010101900001')
        ->assertSet('nama', 'Budi Santoso')
        ->assertSet('tempat_lahir', 'Dumai')
        ->assertSet('jenis_kelamin', 'L')
        ->assertSet('no_telp', '081234567890')
        ->assertSet('alamat', 'Jl. Jenderal Sudirman No. 10, Dumai');
});

test('memilih pasar dan unit mengisi luas dan lokasi secara reaktif', function () {
    Livewire::actingAs($this->pedagangUser)
        ->test(AjukanPermohonanCreate::class)
        ->set('pasar_id', $this->pasar->id)
        ->set('tipe_tempat', 'kios')
        ->set('nomor_tempat', 'K-01')
        ->assertSet('luas', '3x3')
        ->assertSet('lokasi', 'Lantai 1 Blok A');
});

test('validasi form permohonan berjalan ketika field kosong', function () {
    Livewire::actingAs($this->pedagangUser)
        ->test(AjukanPermohonanCreate::class)
        ->call('previewSubmit')
        ->assertHasErrors([
            'pasar_id',
            'tipe_tempat',
            'nomor_tempat',
            'jenis_dagangan',
            'jam_buka',
            'jam_tutup',
            'nib',
            'npwp',
            'ktp',
            'kk',
            'foto',
        ]);
});

test('pedagang dapat memvalidasi dan memicu preview modal kemudian submit permohonan', function () {
    $nib = UploadedFile::fake()->create('nib.pdf', 500, 'application/pdf');
    $npwp = UploadedFile::fake()->create('npwp.pdf', 500, 'application/pdf');
    $ktp = UploadedFile::fake()->create('ktp.pdf', 500, 'application/pdf');
    $kk = UploadedFile::fake()->create('kk.pdf', 500, 'application/pdf');
    $foto = UploadedFile::fake()->image('pasfoto.jpg', 300, 400);

    $component = Livewire::actingAs($this->pedagangUser)
        ->test(AjukanPermohonanCreate::class)
        ->set('pasar_id', $this->pasar->id)
        ->set('tipe_tempat', 'kios')
        ->set('nomor_tempat', 'K-01')
        ->set('jenis_dagangan', 'Bumbu Dapur')
        ->set('jam_buka', '06:00')
        ->set('jam_tutup', '17:00')
        ->set('nib', $nib)
        ->set('npwp', $npwp)
        ->set('ktp', $ktp)
        ->set('kk', $kk)
        ->set('foto', $foto)
        ->call('previewSubmit')
        ->assertHasNoErrors()
        ->assertDispatched('modal-setModalData')
        ->assertDispatched('showModal')
        ->call('confirmSubmit')
        ->assertRedirect(route('pedagang.dashboard'));

    // Verifikasi data tersimpan di database
    expect(DataPermohonan::count())->toBe(1);

    $permohonan = DataPermohonan::first();
    expect($permohonan->user_id)->toBe($this->pedagangUser->id);
    expect($permohonan->pasar_id)->toBe($this->pasar->id);
    expect($permohonan->tipe_tempat)->toBe('kios');
    expect($permohonan->nomor_tempat)->toBe('K-01');
    expect($permohonan->status)->toBe('draft');

    // Verifikasi status unit kios berubah menjadi pengajuan
    $this->kios->refresh();
    expect($this->kios->status_kios)->toBe('pengajuan');
});
