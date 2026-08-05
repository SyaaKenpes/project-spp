@extends('layouts.app')

@section('title', 'Detail Tunggakan Siswa')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('transaksi.cek-tunggakan') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pilih Kelas
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="bg-blue-600 px-6 py-4 text-white">
            <h3 class="text-xl font-bold">Kartu Kontrol Tunggakan SPP</h3>
            <p class="text-sm opacity-90">Tahun Ajaran: {{ date('Y') }}</p>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-700">
            <div>
                <p class="text-gray-400 uppercase font-semibold text-xs">Nama Lengkap</p>
                <p class="font-bold text-base text-gray-900">{{ $siswa->nama }}</p>
            </div>
            <div>
                <p class="text-gray-400 uppercase font-semibold text-xs">NISN</p>
                <p class="font-mono font-medium text-base text-gray-900">{{ $siswa->nisn }}</p>
            </div>
            <div>
                <p class="text-gray-400 uppercase font-semibold text-xs">Kelas & Tarif SPP</p>
                <p class="font-bold text-base text-gray-900">{{ $siswa->nama_kelas }} (<span class="text-green-600">Rp {{ number_format($siswa->nominal, 0, ',', '.') }}/bln</span>)</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h4 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">Status Pembayaran per Bulan:</h4>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($semuaBulan as $bulan)
                @if(in_array($bulan, $bulanSudahDibayar))
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-8 h-8 bg-green-500 text-white rounded-bl-full flex items-center justify-center pl-2 pb-1 text-xs">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-base font-bold text-green-800">{{ $bulan }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">LUNAS</span>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center shadow-sm relative overflow-hidden group">
                        <div class="absolute top-0 right-0 w-8 h-8 bg-red-500 text-white rounded-bl-full flex items-center justify-center pl-2 pb-1 text-xs">
                            <i class="fas fa-times"></i>
                        </div>
                        <p class="text-base font-bold text-red-800">{{ $bulan }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">NUNGGAK</span>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection