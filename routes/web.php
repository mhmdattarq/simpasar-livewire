<?php

use App\Http\Controllers\KiosController;
use App\Http\Controllers\PasarController;
use App\Livewire\Admin\DashboardIndex as AdminDashboard;
use App\Livewire\Admin\Kios\KiosCreate;
use App\Livewire\Admin\Kios\KiosData;
use App\Livewire\Admin\Kios\KiosEdit;
use App\Livewire\Admin\Pasar\PasarCreate;
use App\Livewire\Admin\Pasar\PasarData;
use App\Livewire\Admin\Pasar\PasarEdit;
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
        Route::prefix('pasar')->group(function () {
            Route::name('pasar.')->group(function () {
                Route::get('/datatable', [PasarController::class, 'dataDt'])->name('dt');
                Route::livewire('/data', PasarData::class)->name('data');
                Route::livewire('/create', PasarCreate::class)->name('create');
                Route::livewire('/edit/{id}', PasarEdit::class)->name('edit');
            });
        });
        Route::prefix('kios')->group(function () {
            Route::name('kios.')->group(function () {
                Route::get('/datatable', [KiosController::class, 'dataDt'])->name('dt');
                Route::livewire('/data', KiosData::class)->name('data');
                Route::livewire('/create', KiosCreate::class)->name('create');
                Route::livewire('/edit/{id}', KiosEdit::class)->name('edit');
            });
        });
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
