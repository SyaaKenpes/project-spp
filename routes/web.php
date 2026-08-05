<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CekLogin;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\DB;

// 1. Halaman Awal (Login)
Route::get('/', function () {
    return view('welcome');
});

// 2. Proses Login (Mengirim data ke Controller)
Route::post('/login', [AuthController::class, 'login']);

// 3. Proses Logout
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware([CekLogin::class])->group(function() {

    // admin
Route::get('/admin/dashboard', function () {
    $totalSiswa = DB::table('siswa')->count();
    
    // HITUNGAN BERDASARKAN LEVEL
    $totalAdmin = DB::table('petugas')->where('level', 'admin')->count();
    $totalPetugas = DB::table('petugas')->where('level', 'petugas')->count();
    $totalKelas = DB::table('kelas')->count();

    // Persiapan variabel hari ini & session
    $hariIni = \Carbon\Carbon::now()->format('Y-m-d');
    $id_petugas = session('id_petugas');

    // 1. Hitung total SELURUH transaksi dari semua petugas di hari ini
    $totalTransaksiGlobal = DB::table('pembayaran')
        ->whereDate('tgl_bayar', $hariIni)
        ->count();

    // 2. Hitung total uang masuk KOTOR (semua petugas)
    $totalKotor = DB::table('pembayaran')
        ->whereDate('tgl_bayar', $hariIni)
        ->sum('jumlah_bayar');

    // 3. LOGIKA SAKTI: Kurangi kotor dengan (Total Transaksi Global x Biaya Admin Rp 2000)
    $pendapatanHariIni = $totalKotor - ($totalTransaksiGlobal * 2000);

    // 4. Hitung berapa kali petugas (yang lagi login) ngelayanin transaksi hari ini (Buat info pribadi si Admin)
    $siswaDilayani = DB::table('pembayaran')
        ->whereDate('tgl_bayar', $hariIni)
        ->where('id_petugas', $id_petugas)
        ->count();

    // Kirim data ke halaman view admin.dashboard
    return view('admin.dashboard', compact('totalSiswa', 'totalAdmin', 'totalPetugas', 'totalKelas', 'pendapatanHariIni', 'siswaDilayani'));
})->name('admin.dashboard');

    // Ruangan Petugas
Route::get('/petugas/dashboard', function () {
    // 1. Ambil ID Petugas yang lagi login dari session
    $id_petugas = session('id_petugas'); 

    // 2. Ambil tanggal hari ini
    $hariIni = date('Y-m-d');

    // 3. Hitung berapa kali transaksi HARI INI khusus petugas ini
    $siswaDilayani = \DB::table('pembayaran')
        ->where('id_petugas', $id_petugas)
        ->whereDate('tgl_bayar', $hariIni)
        ->count();

    // 4. Hitung TOTAL KOTOR pendapatan SPP HARI INI
    $totalKotor = \DB::table('pembayaran')
        ->where('id_petugas', $id_petugas)
        ->whereDate('tgl_bayar', $hariIni)
        ->sum('jumlah_bayar');

    // 5. LOGIKA SAKTI: Total Kotor dikurangi (Jumlah Siswa Dilayani x Biaya Admin Rp 2000)
    $pendapatanHariIni = $totalKotor - ($siswaDilayani * 2000);

    // Lempar datanya ke tampilan
    return view('petugas.dashboard', compact('pendapatanHariIni', 'siswaDilayani'));
})->name('petugas.dashboard');

    // Ruangan Siswa
    Route::get('/siswa/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});

// Halaman data petugas (admin)
Route::prefix('admin')->group(function () {
    // 1. Rute buat nampilin tabel
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
    
    // 2. Rute buat nampilin halaman form tambah data
    Route::get('/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
    
    // 3. Rute buat memproses data pas tombol "Simpan" diklik
    Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');

    Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit'])->name('petugas.edit');
    
    Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
    
    Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
    
    // Halaman data kelas
    // --- RUTE KELAS ---
    Route::get('/kelas', [App\Http\Controllers\KelasController::class, 'index'])->name('kelas.index');
    
    Route::get('/kelas/create', [App\Http\Controllers\KelasController::class, 'create'])->name('kelas.create');
    
    Route::post('/kelas', [App\Http\Controllers\KelasController::class, 'store'])->name('kelas.store');
    
    Route::get('/kelas/{id}/edit', [App\Http\Controllers\KelasController::class, 'edit'])->name('kelas.edit');
    
    Route::put('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'update'])->name('kelas.update');
    
    Route::delete('/kelas/{id}', [App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.destroy');
    
    
    // Halaman data spp
    // --- RUTE SPP ---
    Route::get('/spp', [App\Http\Controllers\SppController::class, 'index'])->name('spp.index');
    
    Route::get('/spp/create', [App\Http\Controllers\SppController::class, 'create'])->name('spp.create');
    
    Route::post('/spp', [App\Http\Controllers\SppController::class, 'store'])->name('spp.store');
    
    Route::get('/spp/{id}/edit', [App\Http\Controllers\SppController::class, 'edit'])->name('spp.edit');
    
    Route::put('/spp/{id}', [App\Http\Controllers\SppController::class, 'update'])->name('spp.update');
    
    Route::delete('/spp/{id}', [App\Http\Controllers\SppController::class, 'destroy'])->name('spp.destroy');
    
    
    // Halaman data siswa 
    // --- RUTE SISWA ---
    Route::get('/siswa', [App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.index');
    
    Route::get('/siswa/create', [App\Http\Controllers\SiswaController::class, 'create'])->name('siswa.create');
    
    Route::post('/siswa', [App\Http\Controllers\SiswaController::class, 'store'])->name('siswa.store');
    
    
    // Parameter untuk siswa biasanya pake NISN, bukan ID
    Route::get('/siswa/{nisn}/edit', [App\Http\Controllers\SiswaController::class, 'edit'])->name('siswa.edit');
    
    Route::put('/siswa/{nisn}', [App\Http\Controllers\SiswaController::class, 'update'])->name('siswa.update');
    
    Route::delete('/siswa/{nisn}', [App\Http\Controllers\SiswaController::class, 'destroy'])->name('siswa.destroy');

    
    // Halaman Entry transaksi
    // --- RUTE ENTRY TRANSAKSI ---
    Route::get('/transaksi', [App\Http\Controllers\PembayaranController::class, 'index'])->name('transaksi.index');
    
    Route::get('/transaksi/create', [App\Http\Controllers\PembayaranController::class, 'create'])->name('transaksi.create');
    
    Route::post('/transaksi', [App\Http\Controllers\PembayaranController::class, 'store'])->name('transaksi.store');


    // --- RUTE ENTRY & HISTORY TRANSAKSI ---
    Route::get('/transaksi', [App\Http\Controllers\PembayaranController::class, 'index'])->name('transaksi.index');
    
    Route::get('/transaksi/create', [App\Http\Controllers\PembayaranController::class, 'create'])->name('transaksi.create');
    
    Route::post('/transaksi', [App\Http\Controllers\PembayaranController::class, 'store'])->name('transaksi.store');


    // Fitur Cetak & Generate laporan
    Route::get('/transaksi/cetak-struk/{id}', [App\Http\Controllers\PembayaranController::class, 'cetakStruk'])->name('transaksi.cetakStruk');
    
    Route::get('/transaksi/generate-laporan', [App\Http\Controllers\PembayaranController::class, 'generateLaporan'])->name('transaksi.laporan');
});
    

// Route Siswa
Route::get('/siswa/dashboard', [App\Http\Controllers\DashboardSiswaController::class, 'index'])->name('siswa.dashboard');

// Cek tunggakan
Route::get('/transaksi/cek-tunggakan', [\App\Http\Controllers\PembayaranController::class, 'cekTunggakan'])->name('transaksi.cek-tunggakan');
Route::get('/transaksi/detail-tunggakan/{nisn}', [\App\Http\Controllers\PembayaranController::class, 'detailTunggakanSiswa'])->name('transaksi.detail-tunggakan');

// Halaman Profil
Route::get('/profil', function () {
    // 1. CEK JIKA YANG LOGIN ADALAH PETUGAS / ADMIN
    if (session()->has('id_petugas')) {
        $user = \DB::table('petugas')->where('id_petugas', session('id_petugas'))->first();
        $role = 'petugas'; // Bisa admin atau petugas
        
        return view('profil', compact('user', 'role'));
    } 
    // 2. CEK JIKA YANG LOGIN ADALAH SISWA
    elseif (session()->has('nisn')) {
        $user = \DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas') // Join buat ambil nama kelas
            ->where('nisn', session('nisn'))
            ->first();
        $role = 'siswa';
        
        return view('profil', compact('user', 'role'));
    }

    // Kalau gak ada session login, lempar balik ke halaman login
    return redirect('/'); 
})->name('profil');