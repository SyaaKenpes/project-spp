@extends('layouts.app')

@section('title', 'Dashboard Siswa - EduPay')

@section('content')
    <div class="p-6">
        <div class="max-w-5xl mx-auto space-y-6">

            <div
                class="bg-gradient-to-r from-blue-800 to-indigo-900 rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-blue-200 text-sm font-bold tracking-widest uppercase mb-1">Sistem Pembayaran SPP SMKN 7
                        BALEENDAH</p>
                    <h1 class="text-4xl font-black mb-2">Halo, {{ $siswa->nama }}! 👋</h1>
                    <p class="text-lg text-blue-100 font-medium"><i class="fas fa-graduation-cap mr-2"></i> Kelas:
                        {{ $siswa->nama_kelas }}</p>
                </div>
                <div class="mt-6 md:mt-0 relative z-10 text-right">
                    <div
                        class="bg-white bg-opacity-20 backdrop-blur-md px-6 py-4 rounded-2xl border border-white border-opacity-30 shadow-inner">
                        <p class="text-xs text-blue-200 uppercase font-bold tracking-wider mb-1">Status Keanggotaan</p>
                        <p class="text-xl font-black text-green-400"><i class="fas fa-check-circle mr-1"></i> SISWA AKTIF
                        </p>
                    </div>
                </div>
                <i
                    class="fas fa-user-graduate absolute -right-10 -bottom-10 text-9xl text-white opacity-5 transform -rotate-12"></i>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-5 hover:shadow-md transition-shadow">
                    <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
                        <i class="fas fa-id-card text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NISN / NIS</p>
                        <p class="text-xl font-black text-gray-800">{{ $siswa->nisn }} / {{ $siswa->nis }}</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-5 hover:shadow-md transition-shadow">
                    <div class="bg-yellow-50 p-4 rounded-xl text-yellow-600">
                        <i class="fas fa-file-invoice-dollar text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tagihan Bulanan</p>
                        <p class="text-xl font-black text-gray-800">Rp {{ number_format($siswa->nominal, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center space-x-5 hover:shadow-md transition-shadow">
                    <div class="bg-green-50 p-4 rounded-xl text-green-600">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Lunas</p>
                        <p class="text-xl font-black text-green-600">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
                <div class="bg-gray-50 p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-black text-gray-800 tracking-wide"><i
                            class="fas fa-history text-blue-600 mr-2"></i> Riwayat Pembayaran Saya</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-white text-xs uppercase font-bold text-gray-400 tracking-wider border-b border-gray-100">
                                <th class="p-5">Tanggal Bayar</th>
                                <th class="p-5">Pembayaran Untuk</th>
                                <th class="p-5">Nominal Bayar</th>
                                <th class="p-5">Status</th>
                                <th class="p-5">Petugas Kasir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm font-medium text-gray-700">
                            @forelse($history as $h)
                                <tr class="hover:bg-blue-50 transition-colors">
                                    <td class="p-5 font-mono text-gray-500">{{ date('d F Y', strtotime($h->tgl_bayar)) }}
                                    </td>
                                    <td class="p-5">
                                        <span
                                            class="bg-indigo-100 text-indigo-800 px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-wide border border-indigo-200">
                                            SPP {{ $h->bulan_dibayar }} {{ $h->tahun_dibayar }}
                                        </span>
                                    </td>
                                    <td class="p-5 font-bold text-gray-800">Rp
                                        {{ number_format($h->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="p-5">
                                        <span
                                            class="text-green-700 font-bold bg-green-100 px-3 py-1.5 rounded-lg text-xs border border-green-200"><i
                                                class="fas fa-check-circle mr-1"></i> LUNAS</span>
                                    </td>
                                    <td class="p-5 text-gray-500 text-xs font-bold"><i
                                            class="fas fa-user-circle mr-1 text-gray-400"></i> {{ $h->nama_petugas }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center text-gray-400 font-bold">
                                        <i class="fas fa-folder-open text-5xl mb-4 block text-gray-300"></i>
                                        Belum ada riwayat pembayaran.<br>
                                        <span class="text-xs font-normal mt-2 block">Silakan lakukan pembayaran SPP di ruang
                                            Tata Usaha.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4 mt-8 flex items-center justify-center text-gray-500 font-bold text-xs md:text-sm tracking-wide">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-graduation-cap text-blue-600 text-lg"></i>
                    <span>&copy; 2026 Sistem Informasi Pembayaran SPP. EduPay -- SMKN 7 Baleendah</span>
                </div>
            </div>

        </div>
    </div>
@endsection
