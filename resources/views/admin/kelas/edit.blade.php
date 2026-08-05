@extends('layouts.app')

@section('title', 'Edit Data Kelas')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">

            {{-- Nampilin Error Logika --}}
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-times-circle mr-3 text-xl"></i>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Nampilin Error Validasi --}}
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
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <div>
                        <h3 class="text-lg font-bold text-blue-900">Formulir Edit Kelas</h3>
                        <p class="text-gray-500 text-xs">Perbarui data nama kelas atau kompetensi keahlian.</p>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-md font-mono text-sm border border-blue-200">
                        ID: {{ $kelas->id_kelas }}
                    </span>
                </div>

                <div class="p-8">
                    {{-- Arahkan action ke rute update dan wajib bawa parameter ID --}}
                    <form action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kelas</label>
                                <input type="text" name="nama_kelas" required
                                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all uppercase">
                                <p class="text-xs text-gray-400 mt-1">Gunakan format tingkat dan nama jurusan.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jurusan</label>
                                <div class="relative">
                                    <select name="kompetensi_keahlian" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all appearance-none bg-white">
                                        <option value="" disabled>-- Pilih Jurusan --</option>
                                        <option value="PPLG"
                                            {{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) == 'PPLG' ? 'selected' : '' }}>
                                            Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                        <option value="TAV"
                                            {{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) == 'TAV' ? 'selected' : '' }}>
                                            Teknik Audio Vidio (TAV)</option>
                                        <option value="DPIB"
                                            {{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) == 'DPIB' ? 'selected' : '' }}>
                                            Desain Pemodelan dan Informasi Pembangunan (DPIB)</option>
                                        <option value="TSM"
                                            {{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) == 'TSM' ? 'selected' : '' }}>
                                            Teknik Sepeda Motor (TSM)</option>
                                        <option value="TKR"
                                            {{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) == 'TKR' ? 'selected' : '' }}>
                                            Teknik Kendaraan Ringan (TKR)</option>
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
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
