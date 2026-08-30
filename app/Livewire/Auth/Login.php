<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

// 7. Memberi tahu Livewire untuk memakai layout guest (tanpa sidebar/navbar)
#[Layout('templates.layouts.guest')]

// 8. Mengatur judul tab browser menjadi "Login - SIM Pasar"
#[Title('Login - SIM Pasar')]

// 9. Mendefinisikan class Login sebagai komponen Livewire
class Login extends Component
{
    // 10. Validasi: variabel identifier (Username/NIK) tidak boleh kosong saat dikirim
    #[Validate('required', message: 'Username atau NIK wajib diisi.')]
    // 11. Properti publik untuk menampung teks inputan Username/NIK dari form HTML
    public string $identifier = '';

    // 12. Validasi: variabel password tidak boleh kosong saat dikirim
    #[Validate('required', message: 'Password wajib diisi.')]
    // 13. Properti publik untuk menampung teks inputan Password dari form HTML
    public string $password = '';

    // 14. Properti boolean untuk menampung status checkbox "Ingat Saya" (true/false)
    public bool $remember = false;

    // 15. Properti untuk menampung pesan kesalahan jika login gagal (awalnya null/kosong)
    public ?string $errorMessage = null;

    /**
     * Method ini akan dijalankan saat form login disubmit (wire:submit="authenticate")
     */
    public function authenticate()
    {
        // 16. Menjalankan proses validasi berdasarkan aturan #[Validate] di atas
        $this->validate();

        // 17. Mengosongkan pesan error sebelumnya agar alert merah hilang saat mencoba login lagi
        $this->errorMessage = null;

        // 18. Mengecek apakah inputan hanya berupa angka.
        //     Jika angka (true) -> login menggunakan kolom 'nik' (Pedagang).
        //     Jika ada huruf (false) -> login menggunakan kolom 'username' (Admin).
        $field = is_numeric($this->identifier) ? 'nik' : 'username';

        // 19. Menyusun array kredensial yang akan dicocokkan dengan tabel users di database
        $credentials = [
            $field => $this->identifier, // Kolom yang dituju ('nik' atau 'username') beserta isinya
            'password' => $this->password, // Password yang diketik user
        ];

        // 20. Mencoba proses autentikasi ke database:
        //     Mencari user yang sesuai & mencocokkan hash password-nya.
        //     $this->remember dipakai untuk mengaktifkan cookie "remember me".
        if (Auth::attempt($credentials, $this->remember)) {

            // 21. Memperbarui ID session di browser untuk mencegah serangan keamanan Session Fixation
            session()->regenerate();

            // 22. Mengambil data model User yang sedang aktif berhasil login
            /** @var User $user */
            $user = Auth::user();

            // 23. Jika role akun tersebut adalah Admin, arahkan ke dashboard Admin
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // 24. Jika role akun adalah Pedagang, arahkan ke dashboard Pedagang
            return redirect()->intended(route('pedagang.dashboard'));
        }

        // 25. Jika baris ini tercapai, artinya Auth::attempt gagal (user tidak ditemukan / password salah).
        //     Kita isi pesan error agar kotak merah muncul di tampilan blade.
        $this->errorMessage = 'Username/NIK atau password yang Anda masukkan salah.';
    }

    /**
     * Method untuk me-render tampilan HTML Blade
     */
    public function render()
    {
        // 26. Menampilkan file view di resources/views/mods/auth/login.blade.php
        return view('mods.auth.login');
    }
}
