<?php

namespace App\Http\Controllers;

use App\Repositories\PasarRepo;
use Yajra\DataTables\Facades\DataTables;

class PasarController extends Controller
{
    public function dataDt()
    {
        $data = PasarRepo::getDt();

        return DataTables::of($data)
            ->toJson();
    }
}
