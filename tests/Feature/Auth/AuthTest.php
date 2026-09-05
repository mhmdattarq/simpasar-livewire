<?php

use App\Enums\Role;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Models\DataPedagang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('halaman login dan register dapat diakses oleh tamu', function () {
    $this->get(route('login'))->assertSuccessful();
    $this->get(route('register'))->assertSuccessful();
});

test('pedagang dapat melakukan registrasi akun baru', function () {
    Livewire::test(Register::class)
        ->set('nik', '1472010101950001')
        ->set('nama', 'Ahmad Pedagang')
        ->set('tempat_lahir', 'Dumai')
        ->set('tanggal_lahir', '1995-05-15')
        ->set('jenis_kelamin', 'L')
        ->set('no_telp', '081234567899')
        ->set('alamat', 'Jl. Hasanuddin No. 12')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->call('registerSubmit')
        ->assertHasNoErrors()
        ->assertRedirect(route('login'));

    expect(User::where('nik', '1472010101950001')->exists())->toBeTrue();
    expect(DataPedagang::where('nama', 'Ahmad Pedagang')->exists())->toBeTrue();
});

test('user dapat login menggunakan nik dan password yang benar', function () {
    $user = User::create([
        'name' => 'Siti Aminah',
        'nik' => '1472010101920002',
        'password' => Hash::make('secret123'),
        'role' => Role::Pedagang,
    ]);

    Livewire::test(Login::class)
        ->set('identifier', '1472010101920002')
        ->set('password', 'secret123')
        ->call('authenticate')
        ->assertHasNoErrors()
        ->assertRedirect(route('pedagang.dashboard'));

    $this->assertAuthenticatedAs($user);
});
