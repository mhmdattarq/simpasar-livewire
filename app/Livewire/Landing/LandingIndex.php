<?php

namespace App\Livewire\Landing;

use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPedagang;
use App\Models\DataPelataran;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('templates.layouts.landing')]
#[Title('SIMPASAR - Sistem Informasi Manajemen Pasar Kota Dumai')]
class LandingIndex extends Component
{
    /**
     * Kata kunci pencarian nama atau alamat pasar.
     */
    public string $search = '';

    /**
     * Render tampilan halaman landing dengan data statistik dan daftar pasar.
     */
    public function render(): View
    {
        $stats = [
            'total_pasar' => DataPasar::count(),
            'total_pedagang' => DataPedagang::count(),
            'total_kios' => DataKios::count(),
            'total_los' => DataLos::count(),
            'total_pelataran' => DataPelataran::count(),
            'kios_tersedia' => DataKios::where('status_kios', 'tersedia')->count(),
            'los_tersedia' => DataLos::where('status_los', 'tersedia')->count(),
        ];

        $pasars = DataPasar::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_pasar', 'like', '%'.$this->search.'%')
                        ->orWhere('alamat_pasar', 'like', '%'.$this->search.'%');
                });
            })
            ->withCount(['kios', 'los', 'pelataran'])
            ->get();

        return view('mods.landing.landing-index', [
            'stats' => $stats,
            'pasars' => $pasars,
        ]);
    }
}
