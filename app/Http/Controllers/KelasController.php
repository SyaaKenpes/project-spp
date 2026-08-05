<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index() {
        $kelas = DB::table('kelas')
        ->orderBy('kompetensi_keahlian', 'asc')
        ->orderBy('nama_kelas', 'asc')
        ->paginate(4);
        
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create() { 
        return view('admin.kelas.create'); 
    }
    
    public function store(Request $request) {
         // 1. Validasi inputan biar rapi (SATPAM ANTI-KEMBAR ADA DI SINI)
        $request->validate([
            'nama_kelas' => 'required|max:50|unique:kelas,nama_kelas',
            'kompetensi_keahlian' => 'required|in:PPLG,TAV,DPIB,TSM,TKR' 
        ], [
            'nama_kelas.unique' => 'Nama kelas ini sudah ada cuy! Masa kelasnya kembar?' 
        ]);

        $namaKelas = strtoupper($request->nama_kelas);
        $jurusan = $request->kompetensi_keahlian;

        // 2. SATPAM ANTI-NYASAR: Pastiin inputan kelas nyambung sama pilihan dropdown
        if (!str_contains($namaKelas, $jurusan)) {
            return back()->withInput()->with('error', 'kesalahan! anda ngetik kelas ' . $namaKelas . ' tapi milih jurusannya ' . $jurusan . '? Harus sinkron dong!');
        }

        // 3. Simpan data ke database
        DB::table('kelas')->insert([
            'nama_kelas' => $namaKelas, 
            'kompetensi_keahlian' => $jurusan
        ]);
        
        return redirect()->route('kelas.index')
        ->with('success', 'Kelas ' . $namaKelas . ' berhasil didaftarkan secara valid!');
    }
    
    public function edit($id) {
        $kelas = DB::table('kelas')->where('id_kelas', $id)->first();

        // Safety check kalau data tidak di temukan
        if (!$kelas) {
            return redirect()->route('kelass.index')->with('error', 'data kelas tidak ditemukan!');
        }

        return view('admin.kelas.edit', compact('kelas'));
    }
    
    public function update(Request $request, $id) {
        // 1. Validasi Input + SATPAM ANTI-KEMBAR
        $request->validate([
            'nama_kelas' => 'required|max:50|unique:kelas,nama_kelas,' . $id . ',id_kelas',
            'kompetensi_keahlian' => 'required|in:PPLG,TAV,DPIB,TSM,TKR' 
        ], [
            'nama_kelas.unique' => 'Nama kelas ini sudah ada cuy! Cari nama lain.' 
        ]);

        $namaKelas = strtoupper($request->nama_kelas);
        $jurusan = $request->kompetensi_keahlian;

        // 2. SATPAM ANTI-NYASAR 
        if (!str_contains($namaKelas, $jurusan)) {
            return back()->withInput()->with('error', 'Error ! Masa ngetik kelas ' . $namaKelas . ' tapi milih jurusannya ' . $jurusan . '? Harus sinkron dong!');
        }

        // 3. Update data ke database
        DB::table('kelas')->where('id_kelas', $id)->update([
            'nama_kelas' => $namaKelas,
            'kompetensi_keahlian' => $jurusan
        ]);
        
        return redirect()->route('kelas.index')
        ->with('success', 'Data kelas ' . $namaKelas . ' berhasil diupdate!');
    }
    
    public function destroy($id)
    {
        $kelas = DB::table('kelas')->where('id_kelas', $id)->first();
        if (!$kelas) {
            return redirect()->route('kelas.index')
            ->with('error', 'data SPP sudah terhapus!');
        }
        
        DB::table('kelas')->where('id_kelas', $id)->delete();
        return redirect()->route('kelas.index')
        ->with('success', 'Data kelas berhasil dihapus!');
    }
}