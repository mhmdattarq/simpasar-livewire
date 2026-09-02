<?php

namespace App\Http\Controllers;

use App\Repositories\KiosRepo;
use Yajra\DataTables\Facades\DataTables;

class KiosController extends Controller
{
    public function dataDt()
    {
        $data = KiosRepo::getDt();

        return DataTables::of($data)
            ->toJson();
    }
}
