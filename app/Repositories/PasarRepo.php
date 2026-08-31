<?php

namespace App\Repositories;

use App\Models\DataPasar;
use Illuminate\Support\Facades\Log;

class PasarRepo
{
    public static function create($data)
    {
        try {
            DataPasar::create($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Insert ke tabel data_pasars gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $pasar = DataPasar::findOrFail($id);
            $pasar->update($data);

            return true;
        } catch (\Exception $e) {
            Log::error('Update tabel data_pasars gagal', ['error' => $e->getMessage()]);

            return false;
        }
    }

    public static function getById($id)
    {
        return DataPasar::findOrFail($id);
    }

    public static function getDt()
    {
        return DataPasar::query();
    }
}
