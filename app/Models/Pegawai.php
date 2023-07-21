<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Golongan;
use App\Models\GajiPegawai;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function golongan(){
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    public function gajipegawai(){
        return $this->belongsTo(GajiPegawai::class, 'gaji_pegawai_id');
    }
}
