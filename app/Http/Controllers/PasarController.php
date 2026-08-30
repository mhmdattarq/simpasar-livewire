<?php

namespace App\Http\Controllers;

use App\Repositories\PasarRepo;
use Illuminate\Http\Request;

class PasarController extends Controller
{
    public function dataDt()
    {
        $data = PasarRepo::getDt();
        return DataTables::of($data)
            ->toJson();
    }
}
