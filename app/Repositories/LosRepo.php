<?php

namespace App\Repositories;

use App\Models\DataLos;
use App\Models\DataPasar;
use Illuminate\Support\Facades\Log;

class LosRepo
{
    public static function getPasars()
    {
        return DataPasar::orderBy('nama_pasar', 'asc')->get(['id', 'nama_pasar']);
    }

    public static function create($data)
    {
        try {
            DataLos::create($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Insert ke tabel data_los gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $los = DataLos::findOrFail($id);
            $los->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Update tabel data_los gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $los = DataLos::findOrFail($id);
            $los->delete();

            return true;
        } catch (\Exception $e) {
            Log::error('Delete data tabel data_los gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function getById($id)
    {
        return DataLos::findOrFail($id);
    }

    public static function getDt()
    {
        return DataLos::with('pasar');
    }
}
