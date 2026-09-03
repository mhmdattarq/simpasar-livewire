<?php

namespace App\Http\Controllers;

use App\Repositories\LosRepo;
use Yajra\DataTables\Facades\DataTables;

class LosController extends Controller
{
    public function dataDt()
    {
        $data = LosRepo::getDt();

        return DataTables::of($data)
            ->toJson();
    }
}
