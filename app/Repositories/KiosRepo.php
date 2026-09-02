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
}
