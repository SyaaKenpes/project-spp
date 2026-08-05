<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PembayaranController extends Controller
{
    // 1. TAMPILAN TABEL HISTORY PEMBAYARAN
    public function index(Request $request)
    {
        $query = DB::table('pembayaran')
            ->join('siswa', 'pembayaran.nisn', '=', 'siswa.nisn')
            ->join('petugas', 'pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->join('spp', 'pembayaran.id_spp', '=', 'spp.id_spp')
            ->select('pembayaran.*', 'siswa.nama as nama_siswa', 'petugas.nama_petugas', 'spp.nominal');

        // Fitur Filter Tanggal di Halaman History (Jika diisi)
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('pembayaran.tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $history = $query->orderBy('pembayaran.id_pembayaran', 'desc')->get();

        return view('admin.transaksi.index', compact('history'));
    }

    public function create()
    {
        $siswa = DB::table('siswa')
            ->join('spp', 'siswa.id_spp', '=', 'spp.id_spp')
            ->select('siswa.*', 'spp.nominal')
            ->orderBy('siswa.nama', 'asc')
            ->get();
            
        return view('admin.transaksi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'bulan_dibayar' => 'required',
            'tahun_dibayar' => 'required|numeric|digits:4',
            'jumlah_bayar' => 'required|numeric|min:1000'
        ]);

        $siswa = DB::table('siswa')
            ->join('spp', 'siswa.id_spp', '=', 'spp.id_spp')
            ->where('siswa.nisn', $request->nisn)
            ->first();

        // Validasi Uang Kurang (Nominal SPP + Admin 2rb)
        $biaya_admin = 2000;
        $total_tagihan = $siswa->nominal + $biaya_admin;

        if ($request->jumlah_bayar < $total_tagihan) {
            return back()->with('error', 'TRANSAKSI DITOLAK! Uang kurang. Total Tagihan (Rp ' . number_format($siswa->nominal, 0, ',', '.') . ') + Admin (Rp 2.000) adalah Rp ' . number_format($total_tagihan, 0, ',', '.') . '.');
        }

        // Validasi Bulan Sudah Lunas
        $cekLunas = DB::table('pembayaran')
            ->where('nisn', $request->nisn)
            ->where('bulan_dibayar', $request->bulan_dibayar)
            ->where('tahun_dibayar', $request->tahun_dibayar)
            ->first();

        if ($cekLunas) {
            return back()->with('error', 'PEMBAYARAN DIBATALKAN! Siswa atas nama ' . $siswa->nama . ' sudah LUNAS untuk bulan ' . $request->bulan_dibayar . ' tahun ' . $request->tahun_dibayar . '.');
        }

        $id_petugas = session('id_petugas') ?? 1; 

        DB::table('pembayaran')->insert([
            'id_petugas' => $id_petugas,
            'nisn' => $request->nisn,
            'tgl_bayar' => Carbon::now()->format('Y-m-d'),
            'bulan_dibayar' => $request->bulan_dibayar,
            'tahun_dibayar' => $request->tahun_dibayar,
            'id_spp' => $siswa->id_spp,
            'jumlah_bayar' => $total_tagihan,
            'uang_diterima' => $request->jumlah_bayar
        ]);

        return redirect()->route('transaksi.create')->with('success', 'TRANSAKSI BERHASIL! Uang SPP bulan ' . $request->bulan_dibayar . ' sudah masuk ke sistem.');
    }

    // 2. FITUR CETAK STRUK MANUAL PER SISWA
    public function cetakStruk($id)
    {
        $transaksi = DB::table('pembayaran')
            ->join('siswa', 'pembayaran.nisn', '=', 'siswa.nisn')
            ->join('petugas', 'pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('pembayaran.*', 'siswa.nama as nama_siswa', 'petugas.nama_petugas', 'kelas.nama_kelas')
            ->where('pembayaran.id_pembayaran', $id)
            ->first();

        return view('admin.transaksi.struk', compact('transaksi'));
    }

    // 3. FITUR GENERATE LAPORAN MASSAL
    public function generateLaporan(Request $request)
    {
        $query = DB::table('pembayaran')
            ->join('siswa', 'pembayaran.nisn', '=', 'siswa.nisn')
            ->join('petugas', 'pembayaran.id_petugas', '=', 'petugas.id_petugas')
            ->join('spp', 'pembayaran.id_spp', '=', 'spp.id_spp')
            ->select('pembayaran.*', 'siswa.nama as nama_siswa', 'petugas.nama_petugas', 'spp.nominal');

        // Filter tanggal laporan jika admin memilih tanggal tertentu
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('pembayaran.tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $laporan = $query->orderBy('pembayaran.tgl_bayar', 'asc')->get();
        
        // Hitung total uang masuk dari semua yang difilter
        $totalPemasukan = $laporan->sum('jumlah_bayar');

        return view('admin.transaksi.laporan', compact('laporan', 'totalPemasukan', 'request'));
    }

    // 4. FITUR CEK TUNGGAKAN SISWA
    public function cekTunggakan(Request $request)
    {
        $id_kelas = $request->id_kelas;
        $siswa_list = [];

        // Jika petugas sudah memilih kelas dan klik cari
        if ($id_kelas) {
            $siswa_list = DB::table('siswa')
                ->where('id_kelas', $id_kelas)
                ->orderBy('nama', 'asc')
                ->get();
        }

        // Mengambil semua data kelas untuk isi dropdown select di halaman view
        $daftarKelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        return view('admin.transaksi.cek-tunggakan', compact('siswa_list', 'daftarKelas', 'request'));
    }

    // 5. FITUR DETAIL KARTU TUNGGAKAN PER SISWA (Saat Tombol Diklik)
    public function detailTunggakanSiswa($nisn)
    {
        // Ambil data detail siswa, nama kelas, dan tarif SPP-nya
        $siswa = DB::table('siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('spp', 'siswa.id_spp', '=', 'spp.id_spp')
            ->select('siswa.*', 'kelas.nama_kelas', 'spp.nominal')
            ->where('siswa.nisn', $nisn)
            ->first();

        if (!$siswa) {
            return redirect()->route('transaksi.cek-tunggakan')->with('error', 'Siswa tidak ditemukan!');
        }

        // Daftar urutan 12 bulan penuh dalam satu tahun ajaran
        $semuaBulan = [
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'
        ];

        // Ambil riwayat bulan apa saja yang SUDAH DIBAYAR oleh siswa ini di database
        $bulanSudahDibayar = DB::table('pembayaran')
            ->where('nisn', $nisn)
            ->pluck('bulan_dibayar')
            ->toArray();

        // LOGIKA SAKTI: Bandingkan 12 bulan dengan bulan yang sudah dibayar untuk tahu yang nunggak
        $bulanBelumDibayar = array_diff($semuaBulan, $bulanSudahDibayar);

        return view('admin.transaksi.detail-tunggakan', compact('siswa', 'semuaBulan', 'bulanSudahDibayar', 'bulanBelumDibayar'));
    }
}