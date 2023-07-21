<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\GajiPegawai;
use App\Models\Golongan;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\VarDumper\VarDumper;

class PegawaiController extends Controller
{
    //

    public function index(){
        $pegawai = Pegawai::all();
        $golongan = Golongan::all();
        $gajipegawai = GajiPegawai::all();
        


        return view('pegawai', ['pegawai' => $pegawai, 'golongan' => $golongan, 'gajipegawai' => $gajipegawai]);
    }


    public function store(Request $request){
        $request->validate([
            'golongan_id' => 'required',
            'nama_pegawai' => 'required|max:255',
            'gaji_pegawai_id' => 'required',
        ]);


        // Temukan total gaji pegawai
        $gaji = $request->input('gaji_pegawai_id');
        $gajiPegawai = GajiPegawai::find($gaji);
        $totalGaji = $gajiPegawai->gaji_pokok + $gajiPegawai->tunjangan + $gajiPegawai->transportasi;

        // Temukan pajak pegawai
        $golongan_id = $request->input('golongan_id');
        $golongan = Golongan::find($golongan_id);
        $pajakPegawai = $golongan->pajak;

        // Temukan gaji bersih
        $pajak = $totalGaji * $pajakPegawai;
        $gajiBersih = $totalGaji - $pajak;



        // Tambah data pegawai
        Pegawai::create([
            'golongan_id' => $request->input('golongan_id'),
            'gaji_pegawai_id' => $request->input('gaji_pegawai_id'),
            'nama_pegawai' => $request->input('nama_pegawai'),
            'total_gaji' => $totalGaji,
            'pajak' => $pajakPegawai,
            'gaji_bersih' => $gajiBersih,
        ]);

        
        return redirect()->back()->with('success', 'Data pegawai berhasil ditambahkan!');


    }

    // Delete
    public function delete($id){
        $pegawai_id = Crypt::decrypt($id);

        $pegawai = Pegawai::find($pegawai_id);

        $pegawai->delete();


        return redirect()->back()->with('success', 'Data pegawai berhasil dihapus!');


    }

    public function show($id){
        $golongan = Golongan::all();
        $gajipegawai = GajiPegawai::all();
        $pegawai_id = Crypt::decrypt($id);


        $pegawai = Pegawai::find($pegawai_id);

        return view('detail_pegawai', ['pegawai' => $pegawai, 'golongan' => $golongan, 'gajipegawai' => $gajipegawai]);

    }

    public function update(Request $request, $id)
    {

        // Validasi input form sebelum menyimpan perubahan
        $request->validate([
            'golongan_id' => 'required',
            'nama_pegawai' => 'required|max:255',
            'gaji_pegawai_id' => 'required',
        ]);

        // Cari data customer berdasarkan ID
        $pegawai = Pegawai::find($id);

        if($pegawai->nama_pegawai === $request->input('nama_pegawai') && $pegawai->golongan_id === $request->input('golongan_id') &&
        $pegawai->gaji_pegawai_id === $request->input('gaji_pegawai_id')) {
            return redirect()->back()->with('error', 'Tidak ada perubahan');
        } else if ($pegawai) {
            // Temukan total gaji pegawai
            $gaji = $request->input('gaji_pegawai_id');
            $gajiPegawai = GajiPegawai::find($gaji);
            $totalGaji = $gajiPegawai->gaji_pokok + $gajiPegawai->tunjangan + $gajiPegawai->transportasi;

            // Temukan pajak pegawai
            $golongan_id = $request->input('golongan_id');
            $golongan = Golongan::find($golongan_id);
            $pajakPegawai = $golongan->pajak;

            // Temukan gaji bersih
            $pajak = $totalGaji * $pajakPegawai;
            $gajiBersih = $totalGaji - $pajak;


            // Update data customer berdasarkan input dari form
            $pegawai->nama_pegawai = $request->input('nama_pegawai');
            $pegawai->golongan_id = $request->input('golongan_id');
            $pegawai->gaji_pegawai_id  = $request->input('gaji_pegawai_id');
            $pegawai->total_gaji = $totalGaji;
            $pegawai->pajak = $pajakPegawai;
            $pegawai->gaji_bersih = $gajiBersih;
        

            // Simpan perubahan ke dalam database
            $pegawai->save();

            return redirect()->back()->with('success', 'Data pegawai telah berhasil diubah!');
        } 

        return redirect()->back()->with('error', 'Customer not found.');
    }

    
}
