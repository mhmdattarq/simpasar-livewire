<?php

namespace App\Repositories;

use App\Models\DataKios;
use App\Models\DataLos;
use App\Models\DataPasar;
use App\Models\DataPelataran;
use App\Models\DataPermohonan;
use Illuminate\Support\Facades\Log;

class PermohonanRepo
{
    public static function getPasars()
    {
        return DataPasar::orderBy('nama_pasar', 'asc')->get(['id', 'nama_pasar']);
    }

    public static function getAvailableUnits($pasarId, $tipeTempat)
    {
        if (! $pasarId || ! $tipeTempat) {
            return collect();
        }

        return match ($tipeTempat) {
            'kios' => DataKios::where('pasar_id', $pasarId)
                ->where('status_kios', 'tersedia')
                ->orderBy('nomor_kios', 'asc')
                ->get(['id', 'nomor_kios', 'ukuran_kios', 'lokasi_kios']),
            'los' => DataLos::where('pasar_id', $pasarId)
                ->where('status_los', 'tersedia')
                ->orderBy('nomor_los', 'asc')
                ->get(['id', 'nomor_los', 'ukuran_los', 'lokasi_los']),
            'pelataran' => DataPelataran::where('pasar_id', $pasarId)
                ->orderBy('nomor_pelataran', 'asc')
                ->get(['id', 'nomor_pelataran', 'ukuran_pelataran', 'lokasi_pelataran']),
            default => collect(),
        };
    }

    public static function create(array $data): ?DataPermohonan
    {
        try {
            $permohonan = DataPermohonan::create($data);

            // Update status unit tempat menjadi 'pengajuan' jika kios/los
            if (! empty($data['tipe_tempat']) && ! empty($data['nomor_tempat']) && ! empty($data['pasar_id'])) {
                if ($data['tipe_tempat'] === 'kios') {
                    DataKios::where('pasar_id', $data['pasar_id'])
                        ->where('nomor_kios', $data['nomor_tempat'])
                        ->update(['status_kios' => 'pengajuan']);
                } elseif ($data['tipe_tempat'] === 'los') {
                    DataLos::where('pasar_id', $data['pasar_id'])
                        ->where('nomor_los', $data['nomor_tempat'])
                        ->update(['status_los' => 'pengajuan']);
                }
            }

            return $permohonan;
        } catch (\Exception $e) {
            Log::error('Insert ke tabel data_permohonans gagal', ['error' => $e->getMessage()]);

            return null;
        }
    }

    public static function getById($id): DataPermohonan
    {
        return DataPermohonan::with(['user', 'pasar'])->findOrFail($id);
    }

    public static function getByUserId($userId)
    {
        return DataPermohonan::with('pasar')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
