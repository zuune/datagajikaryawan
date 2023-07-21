<?php

namespace App\Http\Controllers;

use App\Models\GajiPegawai;
use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class GajiGolonganController extends Controller
{
    //

    public function index(){
        $gaji = GajiPegawai::all();
        $golongan = Golongan::all();

        $id_golongan =  'G' . (Golongan::count() + 1);

        return view('gaji', ['gaji' => $gaji, 'golongan' => $golongan, 'id_golongan' => $id_golongan,]);
    }


    public function store(Request $request){
        $validatedData = $request->validate([
            'golongan_id' => 'required',
            'gaji_pokok' => 'required|integer',
            'tunjangan' => 'required|integer',
            'transportasi' => 'required|integer'
        ]);

        GajiPegawai::create($validatedData);

        return redirect()->back()->with('success', 'Data gaji pegawai telah ditambahkan!');
    }

    public function delete($id){
        $GajiPegawai_id = Crypt::decrypt($id);

        $gajiPegawai = GajiPegawai::find($GajiPegawai_id);

        Pegawai::where('gaji_pegawai_id', $GajiPegawai_id)->delete();
       
        $gajiPegawai->delete();


        return redirect()->back()->with('success', 'Data telah berhasil dihapus!');


    }
}
