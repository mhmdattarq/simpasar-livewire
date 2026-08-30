<?php

namespace App\Repositories;

use App\Models\DataPasar;
use Illuminate\Support\Facades\Log;

class PasarRepo
{
    // public static function delete($id)
    // {
    //     try {
    //         Kecamatan::find($id)->delete();
    //         return true;
    //     } catch (\Exception $e) {
    //         Log::error("Delete data tabel kecamatans gagal", ['error' => $e->getMessage()]);
    //         return false;
    //     }
    // }
    public static function create($data)
    {
        try {
            DataPasar::create($data);
            return true;
        } catch (\Exception $e) {
            Log::error("Insert ke tabel data_pasars gagal", ['error' => $e->getMessage()]);
            return false;
        }
    }
}
