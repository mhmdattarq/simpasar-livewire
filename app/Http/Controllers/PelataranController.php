<?php

namespace App\Http\Controllers;

use App\Repositories\PelataranRepo;
use Yajra\DataTables\Facades\DataTables;

class PelataranController extends Controller
{
    public function dataDt()
    {
        $data = PelataranRepo::getDt();

        return DataTables::of($data)
            ->toJson();
    }
}
