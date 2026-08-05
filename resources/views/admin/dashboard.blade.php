@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-xl shadow-sm border-l-8 border-blue-600 p-6 mb-8">
            <h1 class="text-3xl font-extrabold text-blue-900 mb-2">Welcome {{ session('nama_petugas') ?? 'Admin' }} !</h1>
            <p class="text-gray-500">Selamat datang di Sistem Informasi Pembayaran SPP EduPay. Semangat bertugas hari ini!
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-50 flex items-center hover:shadow-md transition-shadow">
                <div class="bg-blue-100 p-4 rounded-full mr-5">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-50 flex items-center hover:shadow-md transition-shadow">
                <div class="bg-red-100 p-4 rounded-full mr-5">
                    <i class="fas fa-user-shield text-red-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase tracking-wider">Total Admin</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalAdmin }}</h3>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-50 flex items-center hover:shadow-md transition-shadow">
                <div class="bg-purple-100 p-4 rounded-full mr-5">
                    <i class="fas fa-user-tie text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase tracking-wider">Total Petugas</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalPetugas }}</h3>
                </div>
            </div>

            <div
                class="bg-white rounded-xl shadow-sm p-6 border border-gray-50 flex items-center hover:shadow-md transition-shadow">
                <div class="bg-orange-100 p-4 rounded-full mr-5">
                    <i class="fas fa-chalkboard text-orange-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-semibold uppercase tracking-wider">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalKelas }}</h3>
                </div>
            </div>
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
                    <p class="text-blue-200 font-bold uppercase tracking-wider text-sm mb-1">Siswa Dilayani Olehmu</p>
                    <h3 class="text-4xl font-black">{{ $siswaDilayani }} <span class="text-lg font-normal">Transaksi</span>
                    </h3>
                </div>
                <div class="bg-white bg-opacity-20 p-4 rounded-full">
                    <i class="fas fa-hands-helping text-4xl"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
