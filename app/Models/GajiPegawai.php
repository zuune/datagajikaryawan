<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Golongan;

class GajiPegawai extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'gaji_pegawai_id');
    }

}
