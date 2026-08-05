<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil NISN siswa
        $nisn = Session::get('nisn');

        if (!$nisn) {
            return redirect('/')->with('error', 'Sesi habis, silakan login ulang!');
        }

        // 2. Ambil Biodata Siswa beserta Info Kelas & SPP-nya
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('spp', 'siswa.id_spp', '=', 'spp.id_spp')
            ->where('siswa.nisn', $nisn)
            ->first();

        // 3. Ambil Riwayat Pembayaran KHUSUS Siswa Ini Saja
        $history = DB::table('pembayaran')
            ->join('petugas', 'pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->select('pembayaran.*', 'petugas.nama_petugas')
            ->where('pembayaran.nisn', $nisn)
            ->orderBy('pembayaran.id_pembayaran', 'desc')
            ->get();

        // Hitung total uang 
        $totalDibayar = $history->sum('jumlah_bayar');

        // 4. Lempar data ke tampilan Dashboard Siswa
        return view('siswa.dashboard', compact('siswa', 'history', 'totalDibayar'));
    }
}