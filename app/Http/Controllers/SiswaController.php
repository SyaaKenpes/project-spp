<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index() 
    {
        // Gunakan JOIN untuk menyambungkan tabel Siswa, Kelas, dan SPP
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('spp', 'siswa.id_spp', '=', 'spp.id_spp')
            ->orderBy('siswa.nisn', 'desc') // Urutin dari data terbaru
            ->paginate(4);

        return view('admin.siswa.index', compact('siswa'));
    }

    public function create() 
    { 
        $kelas = DB::table('kelas')
            ->orderBy('nama_kelas', 'asc')
            ->get();
        $spp = DB::table('spp')
            ->orderBy('tahun', 'desc')
            ->get();
        
        return view('admin.siswa.create', compact('kelas', 'spp')); 
    }

    public function store(Request $request) 
    { 
        // 1. Validasi Inputan
        $request->validate([
            'nisn'     => 'required|numeric|digits:10|unique:siswa,nisn',
            'nis'      => 'required|numeric|unique:siswa,nis',
            'nama'     => 'required|max:100',
            'id_kelas' => 'required',
            'id_spp'   => 'required',
            'no_telp'  => 'required|numeric|max_digits:15',
            'alamat'   => 'required'
        ], [
            'nisn.unique'    => 'NISN ini sudah terdaftar! Cek lagi datanya.',
            'nisn.digits'    => 'Format NISN wajib 10 digit angka!',
            'nis.unique'     => 'NIS ini sudah dipakai siswa lain!',
            'no_telp.numeric'=> 'Nomor telepon hanya boleh berisi angka!'
        ]); 

        $passwordSiswa = Hash::make($request->nis);

        // 2. Simpan ke database
        DB::table('siswa')->insert([
            'nisn'     => $request->nisn,
            'nis'      => $request->nis,
            'nama'     => strtoupper($request->nama),
            'id_kelas' => $request->id_kelas,
            'id_spp'   => $request->id_spp,
            'no_telp'  => $request->no_telp,
            'alamat'   => $request->alamat,
            'password' => $passwordSiswa // Masukin password yang udah dienkripsi
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa ' . strtoupper($request->nama) . ' berhasil didaftarkan dan siap login!');
    }

    public function edit($nisn) 
    { 
        // 1. Cari data siswa berdasarkan NISN
        $siswa = DB::table('siswa')->where('nisn', $nisn)->first();
        
        if (!$siswa) {
            return redirect()->route('siswa.index')->with('error', 'Data siswa tidak ditemukan!');
        }

        // 2. Tarik data Kelas dan SPP
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        $spp = DB::table('spp')->orderBy('tahun', 'desc')->get();
        
        return view('admin.siswa.edit', compact('siswa', 'kelas', 'spp'));
    }

    public function update(Request $request, $nisn) 
    { 
        // 1. Validasi + Satpam Anti-Kembar
        $request->validate([
            'nisn'     => 'required|numeric|digits:10|unique:siswa,nisn,' . $nisn . ',nisn',
            'nis'      => 'required|numeric|unique:siswa,nis,' . $nisn . ',nisn',
            'nama'     => 'required|max:100',
            'id_kelas' => 'required',
            'id_spp'   => 'required',
            'no_telp'  => 'required|numeric|max_digits:15',
            'alamat'   => 'required'
        ], [
            'nisn.unique'    => 'NISN ini sudah dipakai siswa lain!',
            'nisn.digits'    => 'Format NISN wajib 10 digit angka!',
            'nis.unique'     => 'NIS ini sudah dipakai siswa lain!'
        ]);

        // 2. Siapin wadah data yang mau di-update
        $dataUpdate = [
            'nisn'     => $request->nisn,
            'nis'      => $request->nis,
            'nama'     => strtoupper($request->nama),
            'id_kelas' => $request->id_kelas,
            'id_spp'   => $request->id_spp,
            'no_telp'  => $request->no_telp,
            'alamat'   => $request->alamat
        ];

        // 3. Cek apakah admin mengganti NIS. Kalau ganti, otomatis enkripsi ulang passwordnya!
        $siswaLama = DB::table('siswa')->where('nisn', $nisn)->first();
        if ($siswaLama->nis != $request->nis) {
            $dataUpdate['password'] = Hash::make($request->nis);
        }

        DB::table('siswa')->where('nisn', $nisn)->update($dataUpdate);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa ' . strtoupper($request->nama) . ' berhasil diperbarui!');
    }
    
    public function destroy($nisn)
    {
        DB::table('siswa')->where('nisn', $nisn)->delete();
        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil dikeluarin dari sekolah (dihapus)!');
    }
}
