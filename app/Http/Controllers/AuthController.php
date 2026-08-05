<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username / NISN tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);

        $username = $request->username;
        $password = $request->password;

        // 1. Cek tabel Petugas
        $petugas = DB::table('petugas')->where('username', $username)->first();

        if ($petugas) {
            if (Hash::check($password, $petugas->password)) {
                
                // SIMPAN SESSION
                Session::put('id_petugas', $petugas->id_petugas);
                Session::put('login_sebagai', $petugas->level); 
                Session::put('username', $petugas->username);
                Session::put('nama_petugas', $petugas->nama_petugas);
                
                if ($petugas->level == 'admin') {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('petugas.dashboard');
                }

            } else {
                return back()->with('error', 'Password salah!');
            }
        }

        // 2. Cek tabel Siswa 
        $siswa = DB::table('siswa')->where('nisn', $username)->first();
        
        if ($siswa) {
            if (Hash::check($password, $siswa->password)) {
                
                Session::put('login_sebagai', 'siswa');
                Session::put('nama_petugas', $siswa->nama); 
                Session::put('nisn', $siswa->nisn);
                
                return redirect()->route('siswa.dashboard');

            } else {
                return back()->with('error', 'Password Siswa salah!');
            }
        }

        return back()->with('error', 'Akun tidak ditemukan! Lau Sape Mpruyy?? 😹');
    }

    public function logout() {
        Session::flush();
        return redirect('/')->with('error', 'Anda berhasil logout!');
    }
}