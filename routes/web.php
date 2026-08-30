<?php

use App\Livewire\Admin\DashboardIndex as AdminDashboard;
use App\Livewire\Auth\Login;
use App\Livewire\Pedagang\DashboardIndex as PedagangDashboard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 1. Halaman Login (Hanya untuk Tamu / Pengguna yang BELUM Login)
Route::middleware('guest')->group(function () {
    Route::livewire('/login', Login::class)->name('login');
});

// 2. Halaman yang Membutuhkan Login (Auth)
Route::middleware('auth')->group(function () {

    // Group Khusus Role ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::livewire('/dashboard', AdminDashboard::class)->name('dashboard');
    });

    // Group Khusus Role PEDAGANG
    Route::middleware('role:pedagang')->prefix('pedagang')->name('pedagang.')->group(function () {
        Route::livewire('/dashboard', PedagangDashboard::class)->name('dashboard');
    });

    // Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    // Root URL (/) Otomatis Mengarahkan Pengguna Sesuai Role
    Route::get('/', function (Request $request) {
        /** @var User $user */
        $user = $request->user();

        return $user->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pedagang.dashboard');
    });
});
