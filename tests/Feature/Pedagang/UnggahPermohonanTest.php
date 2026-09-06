<?php

use App\Enums\Role;
use App\Livewire\Pedagang\UnggahPermohonan\UnggahPermohonanCreate;
use App\Livewire\Pedagang\UnggahPermohonan\UnggahPermohonanData;
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
        'name' => 'Budi Pedagang',
        'nik' => '1472010101900001',
        'role' => Role::Pedagang,
    ]);

    DataPedagang::create([
        'user_id' => $this->pedagangUser->id,
        'nama' => 'Budi Pedagang',
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

    $this->permohonan = DataPermohonan::create([
        'user_id' => $this->pedagangUser->id,
        'nik' => '1472010101900001',
        'nama' => 'Budi Pedagang',
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
        'status' => 'draft',
    ]);
});

test('tamu yang belum login diarahkan ke login saat mengakses halaman unggah permohonan', function () {
    $this->get(route('pedagang.permohonan.unggah'))
        ->assertRedirect(route('login'));

    $this->get(route('pedagang.unggah_permohonan.create'))
        ->assertRedirect(route('login'));
});

test('admin tidak dapat mengakses halaman unggah permohonan pedagang', function () {
    $this->actingAs($this->adminUser)
        ->get(route('pedagang.permohonan.unggah'))
        ->assertForbidden();

    $this->actingAs($this->adminUser)
        ->get(route('pedagang.unggah_permohonan.create'))
        ->assertForbidden();
});

test('pedagang dapat mengakses halaman data unggah permohonan dan melihat pengajuannya', function () {
    $this->actingAs($this->pedagangUser)
        ->get(route('pedagang.permohonan.unggah'))
        ->assertSuccessful()
        ->assertSee('Unggah Surat Permohonan')
        ->assertSee('Pasar Lepin')
        ->assertSee('K-01')
        ->assertSee('Belum Lengkap');
});

test('pedagang dapat memicu modal pratinjau draf surat pada halaman data permohonan lengkap dengan tombol download', function () {
    Livewire::actingAs($this->pedagangUser)
        ->test(UnggahPermohonanData::class)
        ->call('previewSurat', $this->permohonan->id)
        ->assertDispatched('modal-setModalData', function ($event, $params) {
            $data = $params['data'] ?? $params;

            return $data['modalId'] === 'modalPreviewDraft'
                && $data['btnCancelText'] === 'Tutup'
                && ($data['showActionBtn'] ?? null) === true
                && ($data['btnActionText'] ?? null) === 'Download PDF'
                && ($data['btnActionUrl'] ?? null) === route('pedagang.permohonan.download', $this->permohonan->id);
        });
});

test('pedagang dapat membuka halaman form create unggah permohonan', function () {
    $this->actingAs($this->pedagangUser)
        ->get(route('pedagang.unggah_permohonan.create', ['id' => $this->permohonan->id]))
        ->assertSuccessful()
        ->assertSee('Formulir Unggah Surat Bertandatangan')
        ->assertSee('Pasar Lepin')
        ->assertSee('K-01');
});

test('validasi form unggah permohonan menolak jika berkas kosong atau format salah', function () {
    Livewire::actingAs($this->pedagangUser)
        ->test(UnggahPermohonanCreate::class, ['id' => $this->permohonan->id])
        ->call('formSubmit')
        ->assertHasErrors(['signed_document']);

    $invalidFile = UploadedFile::fake()->create('dokumen.txt', 100, 'text/plain');

    Livewire::actingAs($this->pedagangUser)
        ->test(UnggahPermohonanCreate::class, ['id' => $this->permohonan->id])
        ->set('signed_document', $invalidFile)
        ->call('formSubmit')
        ->assertHasErrors(['signed_document']);
});

test('pedagang dapat mengunggah berkas bertandatangan dan status permohonan berubah menjadi lengkap', function () {
    $file = UploadedFile::fake()->create('surat_permohonan_bertandatangan.pdf', 800, 'application/pdf');

    Livewire::actingAs($this->pedagangUser)
        ->test(UnggahPermohonanCreate::class, ['id' => $this->permohonan->id])
        ->set('signed_document', $file)
        ->call('formSubmit')
        ->assertHasNoErrors()
        ->assertRedirect(route('pedagang.permohonan.unggah'));

    $this->permohonan->refresh();

    // Verifikasi status berubah menjadi lengkap dan path dokumen terisi
    expect($this->permohonan->status)->toBe('lengkap');
    expect($this->permohonan->dokumen_path)->not->toBeNull();
    Storage::disk('public')->assertExists($this->permohonan->dokumen_path);
});

test('pedagang dapat mengunduh draf surat permohonan dalam format pdf', function () {
    $response = $this->actingAs($this->pedagangUser)
        ->get(route('pedagang.permohonan.download', $this->permohonan->id));

    $response->assertSuccessful();
    $response->assertHeader('Content-Type', 'application/pdf');
    expect($response->streamedContent())->not->toBeEmpty();
});

test('pedagang lain tidak dapat mengunduh draf surat permohonan milik orang lain', function () {
    $otherPedagang = User::factory()->create([
        'name' => 'Pedagang Lain',
        'nik' => '1472010101900099',
        'role' => Role::Pedagang,
    ]);

    $this->actingAs($otherPedagang)
        ->get(route('pedagang.permohonan.download', $this->permohonan->id))
        ->assertNotFound();
});
