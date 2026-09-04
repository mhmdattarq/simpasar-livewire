<?php

namespace App\Repositories;

use App\Models\DataPasar;
use App\Models\DataPelataran;
use Illuminate\Support\Facades\Log;

class PelataranRepo
{
    public static function getPasars()
    {
        return DataPasar::orderBy('nama_pasar', 'asc')->get(['id', 'nama_pasar']);
    }

    public static function create($data)
    {
        try {
            DataPelataran::create($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Insert ke tabel data_pelatarans gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $pelataran = DataPelataran::findOrFail($id);
            $pelataran->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Update tabel data_pelatarans gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function delete($id)
    {
        try {
            $pelataran = DataPelataran::findOrFail($id);
            $pelataran->delete();

            return true;
        } catch (\Exception $e) {
            Log::error('Delete data tabel data_pelatarans gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function getById($id)
    {
        return DataPelataran::findOrFail($id);
    }

    public static function getDt()
    {
        return DataPelataran::with('pasar');
    }
}
