<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('petugas')->insert([
            'id_petugas' => 'PI00001',
            'username' => 'admin_utama',
            'password' => Hash::make('admin12345'),
            'nama_petugas' => 'Pasyha Zulfahmi R',
            'level' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
