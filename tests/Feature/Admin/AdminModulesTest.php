<?php

use App\Enums\Role;
use App\Livewire\Admin\Kios\KiosData;
use App\Livewire\Admin\Los\LosData;
use App\Livewire\Admin\Pasar\PasarData;
use App\Livewire\Admin\Pelataran\PelataranData;
use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPelataran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->adminUser = User::factory()->create([
        'name' => 'Administrator',
        'role' => Role::Admin,
    ]);

    $this->pedagangUser = User::factory()->create([
        'name' => 'Pedagang Pasar',
        'role' => Role::Pedagang,
    ]);

    $this->pasar = DataPasar::create([
        'nama_pasar' => 'Pasar Kelapa',
        'alamat_pasar' => 'Jl. Kelapa 1',
        'total_kios' => 5,
        'total_los' => 5,
        'total_pelataran' => 5,
        'foto_depan' => 'pasar/depan.jpg',
        'foto_dalam' => 'pasar/dalam.jpg',
        'foto_belakang' => 'pasar/belakang.jpg',
        'lokasi_peta' => 'https://maps.google.com',
    ]);

    $this->kios = DataKios::create([
        'pasar_id' => $this->pasar->id,
        'nomor_kios' => 'K-101',
        'ukuran_kios' => '3x3',
        'lokasi_kios' => 'Blok B',
        'status_kios' => 'tersedia',
    ]);

    $this->los = DataLos::create([
        'pasar_id' => $this->pasar->id,
        'nomor_los' => 'L-101',
        'ukuran_los' => '2x2',
        'lokasi_los' => 'Blok C',
        'status_los' => 'tersedia',
    ]);

    $this->pelataran = DataPelataran::create([
        'pasar_id' => $this->pasar->id,
        'nomor_pelataran' => 'P-101',
        'ukuran_pelataran' => '2x1',
        'lokasi_pelataran' => 'Halaman Depan',
        'status_pelataran' => 'tetap',
    ]);
});

test('admin dapat mengakses seluruh menu manajemen master data', function () {
    $this->actingAs($this->adminUser);

    $this->get(route('admin.dashboard'))->assertSuccessful();
    $this->get(route('admin.pasar.data'))->assertSuccessful();
    $this->get(route('admin.kios.data'))->assertSuccessful();
    $this->get(route('admin.los.data'))->assertSuccessful();
    $this->get(route('admin.pelataran.data'))->assertSuccessful();
});

test('pedagang tidak diizinkan mengakses menu admin', function () {
    $this->actingAs($this->pedagangUser);

    $this->get(route('admin.dashboard'))->assertForbidden();
    $this->get(route('admin.pasar.data'))->assertForbidden();
    $this->get(route('admin.kios.data'))->assertForbidden();
    $this->get(route('admin.los.data'))->assertForbidden();
    $this->get(route('admin.pelataran.data'))->assertForbidden();
});

test('admin dapat men-trigger hookModalDelete dan menghapus pasar melalui event modal', function () {
    Livewire::actingAs($this->adminUser)
        ->test(PasarData::class)
        ->call('hookModalDelete', $this->pasar->id, $this->pasar->nama_pasar)
        ->assertDispatched('modal-delete-setDeleteId')
        ->call('delete', ['id' => $this->pasar->id])
        ->assertDispatched('closeModal', id: 'modalDelete')
        ->assertDispatched('alert-show');

    expect(DataPasar::find($this->pasar->id))->toBeNull();
});

test('admin dapat men-trigger hookModalDelete dan menghapus kios melalui event modal', function () {
    Livewire::actingAs($this->adminUser)
        ->test(KiosData::class)
        ->call('hookModalDelete', $this->kios->id, $this->kios->nomor_kios)
        ->assertDispatched('modal-delete-setDeleteId')
        ->call('delete', ['id' => $this->kios->id])
        ->assertDispatched('closeModal', id: 'modalDelete');

    expect(DataKios::find($this->kios->id))->toBeNull();
});

test('admin dapat men-trigger hookModalDelete dan menghapus los melalui event modal', function () {
    Livewire::actingAs($this->adminUser)
        ->test(LosData::class)
        ->call('hookModalDelete', $this->los->id, $this->los->nomor_los)
        ->assertDispatched('modal-delete-setDeleteId')
        ->call('delete', ['id' => $this->los->id])
        ->assertDispatched('closeModal', id: 'modalDelete');

    expect(DataLos::find($this->los->id))->toBeNull();
});

test('admin dapat men-trigger hookModalDelete dan menghapus pelataran melalui event modal', function () {
    Livewire::actingAs($this->adminUser)
        ->test(PelataranData::class)
        ->call('hookModalDelete', $this->pelataran->id, $this->pelataran->nomor_pelataran)
        ->assertDispatched('modal-delete-setDeleteId')
        ->call('delete', ['id' => $this->pelataran->id])
        ->assertDispatched('closeModal', id: 'modalDelete');

    expect(DataPelataran::find($this->pelataran->id))->toBeNull();
});
