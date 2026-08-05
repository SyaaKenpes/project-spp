<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SppController extends Controller
{
    public function index() 
    {
    // Urutkan dari tahun terbaru ke yang terlama
        $spp = DB::table('spp')->orderBy('tahun', 'desc')->paginate(4);
        return view('admin.spp.index', compact('spp'));
    }

    public function create() 
    { 
        return view('admin.spp.create'); 
    }
    
    public function store(Request $request) 
    { 
        // 1. Validasi Super Ketat
        $request->validate([
            // Tahun wajib unique biar nggak ada 2 tarif berbeda di tahun yang sama
            'tahun' => 'required|numeric|digits:4|unique:spp,tahun',
            // Nominal wajib angka dan minimal 1000 rupiah
            'nominal' => 'required|numeric|min:1000'
        ], [
            'tahun.unique' => 'Tahun ajaran ini sudah punya tarif SPP! Kalau mau ubah nominal, atau di-edit aja datanya.',
            'tahun.digits' => 'Format tahun harus 4 digit angka (Contoh: 2026)!',
            'nominal.numeric' => 'Nominal tagihan harus berupa angka murni!'
        ]);

        // 2. Simpan ke database
        DB::table('spp')->insert([
            'tahun' => $request->tahun,
            'nominal' => $request->nominal
        ]);

        // 3. Balik ke halaman index 
        return redirect()->route('spp.index')
            ->with('success', 'Tarif SPP tahun ' . $request->tahun . ' berhasil ditambahkan!');
    
    }

    public function edit($id) 
    { 
        $spp = DB::table('spp')->where('id_spp', $id)->first();

        if (!$spp) {
            return redirect()->route('spp.index')->with('error', 'Data SPP tidak ditemukan!');
        }
        
        return view('admin.spp.edit', compact('spp'));
    }

    public function update(Request $request, $id) 
    { 
        // Validasi: Abaikan pengecekan unique untuk ID yang sedang diedit
        $request->validate([
            'tahun' => 'required|numeric|digits:4|unique:spp,tahun,' . $id . ',id_spp',
            'nominal' => 'required|numeric|min:1000'
        ], [
            'tahun.unique' => 'Tahun ajaran ini sudah punya tarif SPP cuy! Cari tahun lain.',
            'tahun.digits' => 'Format tahun harus 4 digit angka (Contoh: 2026)!',
            'nominal.numeric' => 'Nominal tagihan harus berupa angka murni!'
        ]);

        // Eksekusi Update
        DB::table('spp')->where('id_spp', $id)->update([
            'tahun' => $request->tahun,
            'nominal' => $request->nominal
        ]);

        return redirect()->route('spp.index')
            ->with('success', 'Tarif SPP tahun ' . $request->tahun . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $spp = DB::table('spp')->where('id_spp', $id)->first();
        if (!$spp) {
            return redirect()->route('spp.index')->with('error', 'data SPP sudah terhapus!');
        }

        DB::table('spp')->where('id_spp', $id)->delete();
        return redirect()->route('spp.index')->with('success', 'Data SPP berhasil dihapus!');
    }
}
