<?php

namespace App\Repositories;

use App\Models\DataKios;
use App\Models\DataPasar;
use Illuminate\Support\Facades\Log;

class KiosRepo
{
    public static function getPasars()
    {
        return DataPasar::orderBy('nama_pasar', 'asc')->get(['id', 'nama_pasar']);
    }

    public static function create($data)
    {
        try {
            DataKios::create($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Insert ke tabel data_kios gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $kios = DataKios::findOrFail($id);
            $kios->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Update tabel data_kios gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $kios = DataKios::findOrFail($id);
            $kios->delete();

            return true;
        } catch (\Exception $e) {
            Log::error('Delete data tabel data_kios gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function getById($id)
    {
        return DataKios::findOrFail($id);
    }

    public static function getDt()
    {
        return DataKios::with('pasar');
    }
}
