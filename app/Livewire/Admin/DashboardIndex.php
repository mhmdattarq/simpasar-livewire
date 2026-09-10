<?php

namespace App\Livewire\Admin;

use App\Enums\Role;
use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPedagang;
use App\Models\DataPelataran;
use App\Models\DataPermohonan;
use App\Models\User;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $totalPasar = DataPasar::count();
        $totalPedagang = DataPedagang::count() ?: User::where('role', Role::Pedagang)->count();
        $totalPermohonan = DataPermohonan::count();
        $permohonanPerluReview = DataPermohonan::where('status', 'lengkap')->count();
        $permohonanPerluVerifikasi = DataPermohonan::where('status', 'verifikasi')->count();

        // Kios Statistics
        $kiosTotal = DataKios::count();
        $kiosTerisi = DataKios::where('status_kios', 'terisi')->count();
        $kiosPengajuan = DataKios::where('status_kios', 'pengajuan')->count();
        $kiosKosong = DataKios::where('status_kios', 'tersedia')->count();

        // Los Statistics
        $losTotal = DataLos::count();
        $losTerisi = DataLos::where('status_los', 'terisi')->count();
        $losPengajuan = DataLos::where('status_los', 'pengajuan')->count();
        $losKosong = DataLos::where('status_los', 'tersedia')->count();

        // Pelataran Statistics
        $pelataranTotal = DataPelataran::count();
        $pelataranTerisi = DataPermohonan::where('tipe_tempat', 'pelataran')
            ->where('status', 'selesai')
            ->distinct('nomor_tempat')
            ->count('nomor_tempat');
        $pelataranPengajuan = DataPermohonan::where('tipe_tempat', 'pelataran')
            ->whereIn('status', ['draft', 'lengkap', 'disetujui', 'verifikasi'])
            ->distinct('nomor_tempat')
            ->count('nomor_tempat');
        $pelataranKosong = max(0, $pelataranTotal - $pelataranTerisi - $pelataranPengajuan);

        return view('mods.admin.dashboard-index', [
            'totalPasar' => $totalPasar,
            'totalPedagang' => $totalPedagang,
            'totalPermohonan' => $totalPermohonan,
            'permohonanPerluReview' => $permohonanPerluReview,
            'permohonanPerluVerifikasi' => $permohonanPerluVerifikasi,
            'kios' => [
                'total' => $kiosTotal,
                'terisi' => $kiosTerisi,
                'pengajuan' => $kiosPengajuan,
                'kosong' => $kiosKosong,
                'persen_terisi' => $kiosTotal > 0 ? round(($kiosTerisi / $kiosTotal) * 100) : 0,
            ],
            'los' => [
                'total' => $losTotal,
                'terisi' => $losTerisi,
                'pengajuan' => $losPengajuan,
                'kosong' => $losKosong,
                'persen_terisi' => $losTotal > 0 ? round(($losTerisi / $losTotal) * 100) : 0,
            ],
            'pelataran' => [
                'total' => $pelataranTotal,
                'terisi' => $pelataranTerisi,
                'pengajuan' => $pelataranPengajuan,
                'kosong' => $pelataranKosong,
                'persen_terisi' => $pelataranTotal > 0 ? round(($pelataranTerisi / $pelataranTotal) * 100) : 0,
            ],
            'totalTempat' => $kiosTotal + $losTotal + $pelataranTotal,
            'totalTerisi' => $kiosTerisi + $losTerisi + $pelataranTerisi,
        ]);
    }
}
