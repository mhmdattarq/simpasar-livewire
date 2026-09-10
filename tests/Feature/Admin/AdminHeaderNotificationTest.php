<?php

use App\Enums\Role;
use App\Models\DataPasar;
use App\Models\DataPermohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->adminUser = User::factory()->create([
        'name' => 'Admin Pasar',
        'nik' => '1472010101800001',
        'role' => Role::Admin,
    ]);

    $this->pedagangUser = User::factory()->create([
        'name' => 'Budi Santoso',
        'nik' => '1472010101900001',
        'role' => Role::Pedagang,
    ]);

    $this->pasar = DataPasar::create([
        'nama_pasar' => 'Pasar Kelakap Tujuh',
        'alamat_pasar' => 'Jl. Kelakap Tujuh',
        'total_kios' => 10,
        'total_los' => 5,
        'total_pelataran' => 5,
        'foto_depan' => 'pasar/depan.jpg',
        'foto_dalam' => 'pasar/dalam.jpg',
        'foto_belakang' => 'pasar/belakang.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);
});

test('header admin menampilkan notifikasi ketika pedagang mengajukan permohonan', function () {
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
        'tipe_tempat' => 'kios',
        'nomor_tempat' => 'K-01',
        'status' => 'lengkap',
    ]);

    Livewire::actingAs($this->adminUser)
        ->test('header')
        ->assertViewHas('unreadCount', 1)
        ->assertViewHas('notifications', function ($notifs) {
            return $notifs->count() === 1 && $notifs->first()->nama === 'Budi Santoso';
        })
        ->assertSee('Budi Santoso')
        ->assertSee('Pengajuan Kios (K-01)')
        ->assertSee('Menunggu Review');
});

test('header memisahkan notifikasi review dan verifikasi dengan tepat', function () {
    // Permohonan perlu review
    DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Pedagang Review',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman',
        'pasar_id' => $this->pasar->id,
        'tipe_tempat' => 'kios',
        'nomor_tempat' => 'K-02',
        'status' => 'lengkap',
    ]);

    // Permohonan perlu verifikasi
    DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Pedagang Verifikasi',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Sudirman',
        'pasar_id' => $this->pasar->id,
        'tipe_tempat' => 'los',
        'nomor_tempat' => 'L-01',
        'status' => 'verifikasi',
    ]);

    Livewire::actingAs($this->adminUser)
        ->test('header')
        ->assertViewHas('unreadCount', 2)
        ->assertViewHas('notificationsReview', function ($review) {
            return $review->count() === 1 && $review->first()->nama === 'Pedagang Review';
        })
        ->assertViewHas('notificationsVerifikasi', function ($verif) {
            return $verif->count() === 1 && $verif->first()->nama === 'Pedagang Verifikasi';
        })
        ->assertSee('Pedagang Review')
        ->assertSee('Pedagang Verifikasi');
});
