<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Pegawai;
use App\Models\DetailUser;
use App\Models\User;
use App\Models\GajiPegawai;
use App\Models\Golongan;
use Illuminate\Support\Facades\Hash;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Yeremia A Dio',
            'username' => 'datacakrayeremia',
            'password' => Hash::make('datacakra123'),
            'role' => 'admin',
            'email' => 'raikkonendio@gmail.com',
        ]);

        Pegawai::create([
            'golongan_id' => 1,
            'gaji_pegawai_id' => 1,
            'nama_pegawai' => 'Hermanto',
        ]);

        GajiPegawai::create([
            'golongan_id' => 3,
            'gaji_pokok' => 6000000,
            'tunjangan' => 500000,
            'transportasi' => 350000, 
        ]);

        Golongan::create([
            'nama_golongan' => 'G1',
            'pajak' => 0.02, 
        ]);

        Golongan::create([
            'nama_golongan' => 'G2',
            'pajak' => 0.03, 
        ]);

        Golongan::create([
            'nama_golongan' => 'G3',
            'pajak' => 0.04, 
        ]);
    
    
    
    }





}
