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

    public static function uploadSignedDocument(int $id, string $filePath): bool
    {
        try {
            $permohonan = DataPermohonan::findOrFail($id);

            return $permohonan->update([
                'dokumen_path' => $filePath,
                'status' => 'lengkap',
                'keterangan' => 'Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!',
            ]);
        } catch (\Exception $e) {
            Log::error('Upload surat permohonan bertandatangan gagal', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public static function getAdminDt()
    {
        return DataPermohonan::with('pasar')
            ->whereIn('status', ['lengkap', 'disetujui', 'ditolak', 'verifikasi', 'selesai'])
            ->orderBy('updated_at', 'desc');
    }

    public static function approve(int $id, string $status, ?string $reason = null): bool
    {
        try {
            $permohonan = DataPermohonan::findOrFail($id);
            $newStatus = ($status === 'approved') ? 'disetujui' : 'ditolak';
            $keterangan = ($status === 'approved')
                ? 'Surat permohonan telah disetujui, Belum Terverifikasi!'
                : ($reason ?: 'Surat permohonan tidak dikabulkan.');

            $updated = $permohonan->update([
                'status' => $newStatus,
                'keterangan' => $keterangan,
            ]);

            if ($status === 'rejected' && $permohonan->pasar_id && $permohonan->nomor_tempat) {
                if ($permohonan->tipe_tempat === 'kios') {
                    DataKios::where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_kios', $permohonan->nomor_tempat)
                        ->update(['status_kios' => 'tersedia']);
                } elseif ($permohonan->tipe_tempat === 'los') {
                    DataLos::where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_los', $permohonan->nomor_tempat)
                        ->update(['status_los' => 'tersedia']);
                }
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Approve/Reject permohonan gagal', [
                'id' => $id,
                'status' => $status,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public static function verify(int $id): bool
    {
        try {
            $permohonan = DataPermohonan::findOrFail($id);

            $updated = $permohonan->update([
                'status' => 'selesai',
                'keterangan' => 'Permohonan telah diverifikasi dan selesai',
            ]);

            if ($permohonan->pasar_id && $permohonan->nomor_tempat) {
                if ($permohonan->tipe_tempat === 'kios') {
                    DataKios::where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_kios', $permohonan->nomor_tempat)
                        ->update(['status_kios' => 'terisi']);
                } elseif ($permohonan->tipe_tempat === 'los') {
                    DataLos::where('pasar_id', $permohonan->pasar_id)
                        ->where('nomor_los', $permohonan->nomor_tempat)
                        ->update(['status_los' => 'terisi']);
                }
            }

            return $updated;
        } catch (\Exception $e) {
            Log::error('Verifikasi permohonan gagal', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public static function uploadPernyataan(int $id, string $filePath): bool
    {
        try {
            $permohonan = DataPermohonan::findOrFail($id);

            return $permohonan->update([
                'dokumen_path_pernyataan' => $filePath,
                'status' => 'verifikasi',
                'keterangan' => 'Surat Pernyataan menjadi pedagang berhasil di unggah, Silahkan tunggu verifikasi dari Admin!',
            ]);
        } catch (\Exception $e) {
            Log::error('Upload surat pernyataan gagal', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public static function getTempatDataByNik(string $nik): array
    {
        $permohonanList = DataPermohonan::with('pasar')
            ->where('nik', $nik)
            ->whereIn('status', ['disetujui', 'verifikasi', 'selesai'])
            ->get();

        $kiosCount = 0;
        $losTotal = 0;
        $pelataranTotal = 0;
        $kiosLocations = [];
        $losLocations = [];
        $pelataranLocations = [];

        foreach ($permohonanList as $item) {
            $namaPasar = $item->pasar?->nama_pasar ?? '-';
            if ($item->tipe_tempat === 'kios') {
                $kiosCount++;
                $kiosLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$namaPasar}";
            } elseif ($item->tipe_tempat === 'los') {
                $losTotal += (float) $item->luas;
                $losLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$namaPasar}";
            } elseif ($item->tipe_tempat === 'pelataran') {
                $pelataranTotal += (float) $item->luas;
                $pelataranLocations[] = "{$item->nomor_tempat}, {$item->lokasi}, {$namaPasar}";
            }
        }

        return [
            'kios' => [
                'count' => $kiosCount,
                'locations' => $kiosCount > 0 ? implode('; ', $kiosLocations) : '-',
            ],
            'los' => [
                'total' => $losTotal,
                'locations' => $losTotal > 0 ? implode('; ', $losLocations) : '-',
            ],
            'pelataran' => [
                'total' => $pelataranTotal,
                'locations' => $pelataranTotal > 0 ? implode('; ', $pelataranLocations) : '-',
            ],
        ];
    }
}
