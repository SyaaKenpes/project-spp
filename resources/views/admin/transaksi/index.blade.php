@extends('layouts.app')

@section('title', 'History Pembayaran')

@section('content')
    <div class="p-6">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">

            <div
                class="p-6 bg-blue-900 flex flex-col md:flex-row justify-between items-start md:items-center border-b border-gray-100 gap-4">
                <div>
                    <h3 class="text-xl font-extrabold text-white"><i class="fas fa-history mr-2"></i> Riwayat Pembayaran SPP
                    </h3>
                    <p class="text-blue-200 text-xs mt-1">Daftar semua uang SPP masuk yang berhasil dicatat oleh sistem
                        kasir.</p>
                </div>
                <a href="{{ route('transaksi.create') }}"
                    class="bg-yellow-400 hover:bg-yellow-500 text-blue-950 font-bold px-4 py-2 rounded-lg text-sm transition-colors shadow">
                    <i class="fas fa-plus mr-1"></i> Buka Mesin Kasir
                </a>
            </div>

            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <form action="{{ route('transaksi.index') }}" method="GET"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Dari Tanggal</label>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}"
                            class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Sampai Tanggal</label>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}"
                            class="w-full p-2 border border-gray-300 rounded-lg text-sm shadow-sm">
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg text-sm shadow transition-colors flex-1">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('transaksi.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold px-3 py-2 rounded-lg text-sm shadow transition-colors">
                            Reset
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('transaksi.laporan', ['tgl_mulai' => request('tgl_mulai'), 'tgl_selesai' => request('tgl_selesai')]) }}"
                            target="_blank"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-black px-4 py-2.5 rounded-lg text-sm shadow transition-all flex items-center justify-center border-b-4 border-green-800">
                            <i class="fas fa-file-invoice-dollar mr-2"></i> GENERATE LAPORAN
                        </a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-100 uppercase text-xs font-bold text-gray-600 tracking-wider border-b border-gray-200">
                            <th class="p-4">Tanggal Bayar</th>
                            <th class="p-4">Siswa (NISN)</th>
                            <th class="p-4">Bulan/ Tahun</th>
                            <th class="p-4">Total Bayar</th>
                            <th class="p-4">Petugas Kasir</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm font-medium text-gray-700">
                        @forelse($history as $h)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-mono text-gray-500">{{ date('d/m/Y', strtotime($h->tgl_bayar)) }}</td>
                                <td class="p-4">
                                    <span class="block font-bold text-blue-950">{{ $h->nama_siswa }}</span>
                                    <span class="text-xs font-mono text-gray-400">{{ $h->nisn }}</span>
                                </td>
                                <td class="p-4">
                                    <span
                                        class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-md text-xs font-bold uppercase">{{ $h->bulan_dibayar }}
                                        {{ $h->tahun_dibayar }}</span>
                                </td>
                                <td class="p-4 text-green-600 font-bold">Rp
                                    {{ number_format($h->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="p-4 text-purple-700"><i class="fas fa-user-circle mr-1"></i>
                                    {{ $h->nama_petugas }}</td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('transaksi.cetakStruk', $h->id_pembayaran) }}" target="_blank"
                                        class="bg-gray-100 hover:bg-blue-100 text-gray-600 hover:text-blue-700 p-2 rounded-lg border border-gray-200 transition-all text-xs font-bold shadow-sm">
                                        <i class="fas fa-print mr-1"></i> Struk
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-gray-400 font-bold">
                                    <i class="fas fa-folder-open text-4xl mb-3 block"></i> Belum ada riwayat transaksi
                                    pembayaran SPP.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
