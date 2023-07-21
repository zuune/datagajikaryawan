<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\GajiPegawai;
use App\Models\Pegawai;

class Golongan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pegawai(){
        return $this->hasMany(Pegawai::class, 'golongan_id');
    }

    public function gajipegawai(){
        return $this->hasOne(Pegawai::class, 'golongan_id');
    }
}
