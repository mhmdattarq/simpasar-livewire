<?php

use App\Enums\Role;
use App\Livewire\Admin\Permohonan\PermohonanData;
use App\Models\DataKios;
use App\Models\DataPasar;
use App\Models\DataPedagang;
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

    DataPedagang::create([
        'user_id' => $this->pedagangUser->id,
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Jenderal Sudirman No. 10, Dumai',
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
        'status_kios' => 'pengajuan',
    ]);

    $this->permohonan = DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Budi Santoso',
        'tempat_lahir' => 'Dumai',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'no_telp' => '081234567890',
        'alamat' => 'Jl. Jenderal Sudirman No. 10, Dumai',
        'pasar_id' => $this->pasar->id,
        'tipe_tempat' => 'kios',
        'nomor_tempat' => 'K-01',
        'lokasi' => 'Lantai 1 Blok A',
        'luas' => '3x3',
        'jenis_dagangan' => 'Sembako',
        'jam_buka' => '06:00',
        'jam_tutup' => '17:00',
        'nib' => 'permohonan/nib/dummy.pdf',
        'npwp' => 'permohonan/npwp/dummy.pdf',
        'ktp' => 'permohonan/ktp/dummy.pdf',
        'kk' => 'permohonan/kk/dummy.pdf',
        'foto' => 'permohonan/foto/dummy.jpg',
        'dokumen_path' => 'permohonan/signed/surat_permohonan.pdf',
        'status' => 'lengkap',
    ]);
});

test('tamu yang belum login tidak dapat mengakses halaman permohonan admin', function () {
    $this->get(route('admin.permohonan.data'))
        ->assertRedirect(route('login'));

    $this->get(route('admin.permohonan.dt'))
        ->assertRedirect(route('login'));
});

test('pedagang tidak diizinkan mengakses halaman permohonan admin', function () {
    $this->actingAs($this->pedagangUser)
        ->get(route('admin.permohonan.data'))
        ->assertForbidden();

    $this->actingAs($this->pedagangUser)
        ->get(route('admin.permohonan.dt'))
        ->assertForbidden();
});

test('admin dapat mengakses halaman data permohonan pedagang', function () {
    $this->actingAs($this->adminUser)
        ->get(route('admin.permohonan.data'))
        ->assertSuccessful()
        ->assertSee('Data Permohonan Pedagang')
        ->assertSee('Manajemen Pengajuan Permohonan Pedagang');
});

test('datatable permohonan merespons data json dengan benar', function () {
    $response = $this->actingAs($this->adminUser)
        ->get(route('admin.permohonan.dt'));

    $response->assertSuccessful();
    $response->assertJsonStructure(['data']);
});

test('admin dapat memuat data review berkas permohonan', function () {
    Livewire::actingAs($this->adminUser)
        ->test(PermohonanData::class)
        ->call('reviewPermohonan', $this->permohonan->id)
        ->assertDispatched('showModal', id: 'modalReviewPermohonan')
        ->assertSet('selectedPermohonan.id', $this->permohonan->id)
        ->assertSet('selectedPermohonan.nama', 'Budi Santoso');
});

test('admin dapat menyetujui permohonan pedagang', function () {
    Livewire::actingAs($this->adminUser)
        ->test(PermohonanData::class)
        ->call('openApproveModal', $this->permohonan->id)
        ->assertDispatched('showModal', id: 'modalApprovePermohonan')
        ->set('approveStatus', 'approved')
        ->call('saveApprove')
        ->assertDispatched('closeModal', id: 'modalApprovePermohonan')
        ->assertDispatched('alert-show')
        ->assertDispatched('reloadDT', data: 'tablePermohonan');

    $this->permohonan->refresh();
    expect($this->permohonan->status)->toBe('disetujui');
    expect($this->permohonan->keterangan)->toContain('disetujui, Belum Terverifikasi');
});

test('admin dapat menolak permohonan pedagang dan mengembalikan status unit tempat menjadi tersedia', function () {
    Livewire::actingAs($this->adminUser)
        ->test(PermohonanData::class)
        ->call('openApproveModal', $this->permohonan->id)
        ->set('approveStatus', 'rejected')
        ->set('rejectReason', 'Berkas KTP dan NIB tidak sesuai domisili')
        ->call('saveApprove')
        ->assertDispatched('closeModal', id: 'modalApprovePermohonan')
        ->assertDispatched('alert-show')
        ->assertDispatched('reloadDT', data: 'tablePermohonan');

    $this->permohonan->refresh();
    expect($this->permohonan->status)->toBe('ditolak');
    expect($this->permohonan->keterangan)->toBe('Berkas KTP dan NIB tidak sesuai domisili');

    // Unit tempat kios harus kembali 'tersedia'
    $this->kios->refresh();
    expect($this->kios->status_kios)->toBe('tersedia');
});

test('admin dapat memverifikasi pedagang ketika permohonan berstatus verifikasi', function () {
    $this->permohonan->update([
        'status' => 'verifikasi',
        'dokumen_path_pernyataan' => 'permohonan/pernyataan/surat_pernyataan.pdf',
    ]);

    Livewire::actingAs($this->adminUser)
        ->test(PermohonanData::class)
        ->call('verifyPermohonan', $this->permohonan->id)
        ->assertDispatched('alert-show')
        ->assertDispatched('reloadDT', data: 'tablePermohonan');

    $this->permohonan->refresh();
    expect($this->permohonan->status)->toBe('selesai');

    // Unit tempat kios harus berubah menjadi 'terisi'
    $this->kios->refresh();
    expect($this->kios->status_kios)->toBe('terisi');
});

test('datatable menyajikan kolom keterangan dengan fallback yang tepat sesuai status', function () {
    $this->permohonan->update([
        'status' => 'lengkap',
        'keterangan' => null,
    ]);

    $response = $this->actingAs($this->adminUser)
        ->getJson(route('admin.permohonan.dt'));

    $response->assertOk();
    $data = $response->json('data');
    expect($data)->not->toBeEmpty();
    expect($data[0]['keterangan'])->toBe('Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!');
});
