<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $dataFromBackend = Pegawai::select('golongan_id', 'total_gaji')
            ->get();

        return view('index', compact('dataFromBackend'));

    }
}
