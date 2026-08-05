@extends('layouts.app')

@section('title', 'Tambah Tarif SPP')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                    <ul class="list-disc list-inside font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-blue-900">Formulir Tarif SPP Baru</h3>
                        <p class="text-gray-500 text-xs">Masukkan tahun ajaran dan nominal tagihan SPP bulanan.</p>
                    </div>
                    <div class="bg-green-100 p-2 rounded-lg">
                        <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('spp.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                                <input type="number" name="tahun" required placeholder="Contoh: 2026" min="2000"
                                    max="2100"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono">
                                <p class="text-xs text-gray-400 mt-1">Masukkan tahun menggunakan format 4 digit angka.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal SPP (Per
                                    Bulan)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">Rp</span>
                                    </div>
                                    <input type="number" name="nominal" required placeholder="150000" min="1000"
                                        class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all font-mono text-green-700 font-bold">
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Masukkan angka saja tanpa titik atau koma (Contoh:
                                    150000).</p>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-50 pt-6">
                            <a href="{{ route('spp.index') }}"
                                class="text-gray-400 hover:text-gray-600 font-semibold px-4 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 transform hover:-translate-y-0.5 transition-all flex items-center">
                                <i class="fas fa-save mr-2"></i> Simpan Tarif SPP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
