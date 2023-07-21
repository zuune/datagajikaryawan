<?php

namespace App\Http\Controllers;

use App\Models\GajiPegawai;
use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class GolonganController extends Controller
{
    public function index(){
        $golongan = Golongan::all();
        $golonganCode = 'G' . (Golongan::count() + 1);

        return view('golongan', ['golongan' => $golongan, 'golonganCode' => $golonganCode,]);
    }

    public function store(Request $request){
        $validatedData['nama_golongan'] = $request->input('nama_golongan');

        $pajak = $request->input('pajak');
        $pajakDecimal = $pajak / 100;

        $validatedData['pajak'] = $pajakDecimal;

        Golongan::create($validatedData);

        return redirect()->back()->with('success', 'Data golongan pegawai telah ditambahkan!');
    }

    public function delete($id){
        $golongan_id = Crypt::decrypt($id);

        $golongan = Golongan::find($golongan_id);

        GajiPegawai::where('golongan_id', $golongan_id)->delete();
        Pegawai::where('golongan_id', $golongan_id)->delete();
       
        $golongan->delete();


        return redirect()->back()->with('success', 'Data telah berhasil dihapus!');


    }


    public function filterGolongan(Request $request)
    {
        // Ambil data golongan untuk dropdown filter
        $golongan = Golongan::all();
        $gajipegawai = GajiPegawai::all();

        // Query builder untuk data pegawai
        $query = Pegawai::with('gajipegawai', 'golongan');

        // Filtering berdasarkan golongan
        if ($request->has('filterGolongan') && !empty($request->filterGolongan)) {
            $query->where('golongan_id', $request->filterGolongan);
        }

        // Sorting berdasarkan total_gaji (asc atau desc)
        if ($request->has('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('total_gaji', $request->sort);
        }

        // Ambil data pegawai
        $pegawai = $query->get();

        return view('pegawai', compact('pegawai', 'golongan', 'gajipegawai'));
    }
}
