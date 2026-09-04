<?php

namespace App\Livewire\Auth;

use App\Enums\Role;
use App\Models\DataPedagang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('templates.layouts.guest')]
#[Title('Daftar Akun Pedagang - SIM Pasar')]
class Register extends Component
{
    public string $nik = '';

    public string $nama = '';

    public string $tempat_lahir = '';

    public string $tanggal_lahir = '';

    public string $jenis_kelamin = '';

    public string $no_telp = '';

    public string $alamat = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?string $errorMessage = null;

    public function rules(): array
    {
        return [
            'nik' => 'required|numeric|digits:16|unique:users,nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.required' => 'NIK (Nomor KTP) wajib diisi.',
            'nik.numeric' => 'NIK harus berupa angka.',
            'nik.digits' => 'NIK harus berjumlah 16 digit angka.',
            'nik.unique' => 'NIK ini sudah terdaftar. Silakan langsung login.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin Anda.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'no_telp.required' => 'Nomor handphone wajib diisi.',
            'alamat.required' => 'Alamat tempat tinggal wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password di atas.',
        ];
    }

    public function registerSubmit()
    {
        $this->validate();
        $this->errorMessage = null;

        try {
            DB::transaction(function () {
                // 1. Buat Akun Login di tabel users
                $user = User::create([
                    'name' => $this->nama,
                    'nik' => $this->nik,
                    'password' => Hash::make($this->password),
                    'role' => Role::Pedagang,
                ]);

                // 2. Simpan Biodata Lengkap ke tabel data_pedagangs
                DataPedagang::create([
                    'user_id' => $user->id,
                    'nama' => $this->nama,
                    'tempat_lahir' => $this->tempat_lahir,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'no_telp' => $this->no_telp,
                    'alamat' => $this->alamat,
                ]);
            });

            // 3. Pasang flash message sukses dan redirect ke halaman login
            session()->flash('success', 'Pendaftaran berhasil! Silakan masuk menggunakan NIK dan password Anda.');

            return $this->redirectRoute('login', navigate: true);
        } catch (\Exception $e) {
            Log::error('Gagal melakukan registrasi pedagang', ['error' => $e->getMessage()]);
            $this->errorMessage = 'Terjadi kesalahan sistem saat mendaftar. Silakan coba beberapa saat lagi.';
        }
    }

    public function render()
    {
        return view('mods.auth.register');
    }
}
