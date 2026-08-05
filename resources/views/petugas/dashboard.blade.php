@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm">
                <h1 class="text-3xl font-black text-gray-800 mb-2">Welcome Petugas {{ Session::get('nama_petugas') }}! 👋
                </h1>
                <p class="text-gray-500 mb-6">Selamat datang di Panel Petugas Sistem Pembayaran SPP.</p>

                <div class="bg-blue-50 text-blue-700 p-4 rounded-xl flex items-start space-x-3 border border-blue-100">
                    <i class="fas fa-info-circle mt-1"></i>
                    <p class="text-sm font-medium">Anda login sebagai <strong>Petugas</strong>. Akses Anda terbatas. </p>
                </div>
            </div>


            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b border-gray-200 pb-2">Laporan Kinerja Hari Ini</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div
                        class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 flex justify-between items-center text-white transform hover:scale-105 transition-transform duration-300">
                        <div>
                            <p class="text-green-100 font-bold uppercase tracking-wider text-sm mb-1">
                                Pendapatan SPP Hari Ini
                            </p>
                            <h3 class="text-4xl font-black">
                                Rp {{ number_format($pendapatanHariIni ?? 0, 0, ',', '.') }}
                            </h3>
                            <p class="text-xs text-green-100 opacity-90 mt-2 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i> Bersih (Tidak termasuk biaya admin Rp 2.000/transaksi)
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-full shadow-inner">
                            <i class="fas fa-wallet text-4xl"></i>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 flex justify-between items-center text-white transform hover:scale-105 transition-transform duration-300">
                        <div>
                            <p class="text-blue-200 font-bold uppercase tracking-wider text-sm mb-1">Siswa Dilayani Olehmu
                            </p>
                            <h3 class="text-4xl font-black">{{ $siswaDilayani ?? 0 }} <span
                                    class="text-lg font-normal">Transaksi</span></h3>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-full">
                            <i class="fas fa-hands-helping text-4xl"></i>
                        </div>
                    </div>

                </div>
            </div>
        @endsection
