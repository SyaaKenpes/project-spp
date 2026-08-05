<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PetugasController extends Controller
{
    // 1. NAMPILIN HALAMAN DATA PETUGAS (TABEL)
    public function index()
    {
        // Ambil semua data
        $petugas = DB::table('petugas')->orderBy('created_at', 'desc')->paginate(4);
        return view('admin.petugas.index', compact('petugas'));
    }

    // 2. NAMPILIN HALAMAN FORM TAMBAH
    public function create()
    {
        return view('admin.petugas.create');
    }

    // 3. LOGIKA SIMPAN DATA & GENERATE CUSTOM ID
    public function store(Request $request)
    {
        // Validasi form
        $request->validate([
            'nama_petugas' => 'required|max:35',
            'username'     => 'required|unique:petugas,username|max:25',
            'password'     => 'required|min:8',
            'level'        => 'required|in:admin,petugas'
        ], [
            'username.unique' => 'Username udah ada yang punya, cari yang lain cuy!',
            'password.min'    => 'Password kependekan! Minimal 8 karakter ya.',
        ]);

        // --- LOGIKA GENERATE ID LEBIH AMAN ---
        $prefix = $request->level == 'admin' ? 'PI' : 'PE';
        
        // Cari ID terakhir yang punya prefix sama
        $lastData = DB::table('petugas')
                    ->where('id_petugas', 'LIKE', $prefix . '%')
                    ->orderBy('id_petugas', 'desc')
                    ->first();

        if ($lastData) {
            // Ambil 3 angka terakhir, terus tambah 1
            $lastNumber = (int) substr($lastData->id_petugas, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $newId = $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT); 

        // --- SIMPAN KE DATABASE ---
        DB::table('petugas')->insert([
            'id_petugas'   => $newId, 
            'nama_petugas' => $request->nama_petugas,
            'username'     => $request->username,
            'password'     => Hash::make($request->password), 
            'level'        => $request->level,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        return redirect()->route('petugas.index')->with('success', 'Akun ' . $request->nama_petugas . ' berhasil dibuat dengan ID: ' . $newId);
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        $petugas = DB::table('petugas')->where('id_petugas', $id)->first();
        
        // Safety check: kalau ID gak ketemu di URL
        if (!$petugas) {
            return redirect()->route('petugas.index')->with('error', 'Data petugas ga nemu, cuy!');
        }

        return view('admin.petugas.edit', compact('petugas'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_petugas' => 'required|max:35',
            'level'        => 'required|in:admin,petugas'
        ]);

        $data = [
            'nama_petugas' => $request->nama_petugas,
            'level'        => $request->level,
            'updated_at'   => now(),
        ];

        // Password diupdate cuma kalau diisi (biar ga ribet ngetik ulang)
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        DB::table('petugas')->where('id_petugas', $id)->update($data);

        return redirect()->route('petugas.index')->with('success', 'Data petugas ' . $request->nama_petugas . ' berhasil diupdate!');
    }

    // 6. PROSES HAPUS
    public function destroy($id)
    {
        // 1. Cari datanya dulu di database
        $userCek = DB::table('petugas')->where('id_petugas', $id)->first();

        // 2. Cek kalau datanya ternyata udah kosong/ga ada (null)
        if (!$userCek) {
            return redirect()->route('petugas.index')->with('error', 'data SPP sudah terhapus!!');
        }

        // 3. Jangan biarin admin hapus akunnya sendiri pas lagi login
        if ($userCek->username == Session::get('username')) {
            return redirect()->route('petugas.index')->with('error', 'Jangan hapus akun sendiri dong, nanti siapa yang login? 😂');
        }

        // 4. Eksekusi hapus kalau semua pengecekan aman
        DB::table('petugas')->where('id_petugas', $id)->delete();
        
        return redirect()->route('petugas.index')->with('success', 'Akun petugas udah diberantas!');
    }
}