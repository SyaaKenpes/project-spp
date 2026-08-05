@extends('layouts.app')

@section('title', 'Tambah Kelas Baru')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-blue-900">Formulir Data Kelas</h3>
                    <p class="text-gray-500 text-xs">Masukkan data kelas dan pilih jurusan atau kompetensi keahlian.</p>
                </div>

                <div class="p-8">
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-times-circle mr-3 text-xl"></i>
                                <span class="font-bold">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- NAMPILIN ERROR DATA KELAS KEMBAR (Validasi Laravel) --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                            <ul class="list-disc list-inside font-bold">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('kelas.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kelas</label>
                                <input type="text" name="nama_kelas" required placeholder="Contoh: X PPLG 1"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all uppercase">
                                <p class="text-xs text-gray-400 mt-1">Gunakan format tingkat dan nama jurusan.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jurusan</label>
                                <div class="relative">
                                    <select name="kompetensi_keahlian" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all appearance-none bg-white">
                                        <option value="" disabled selected>Pilih Jurusan</option>
                                        <option value="PPLG">Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                        <option value="TAV">Teknik Audio Vidio (TAV)</option>
                                        <option value="DPIB">Desain Pemodelan dan Informasi Pembangunan (DPIB)</option>
                                        <option value="TSM">Teknik Sepeda Motor (TSM)</option>
                                        <option value="TKR">Teknik Kendaraan Ringan (TKR)</option>
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-50 pt-6">
                            <a href="{{ route('kelas.index') }}"
                                class="text-gray-400 hover:text-gray-600 font-semibold px-4 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 transform hover:-translate-y-0.5 transition-all">
                                Simpan Data Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
