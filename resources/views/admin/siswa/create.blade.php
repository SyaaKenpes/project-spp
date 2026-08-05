@extends('layouts.app')

@section('title', 'Tambah Data Siswa')

@section('content')
    <div class="p-6">
        <div class="max-w-4xl mx-auto">

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
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-blue-900">Formulir Induk Siswa Baru</h3>
                        <p class="text-gray-500 text-xs">Masukkan data diri siswa beserta relasi kelas dan tagihan SPP.</p>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-lg">
                        <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NISN</label>
                                <input type="number" name="nisn" required placeholder="Contoh: 0061234567"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono">
                                <p class="text-xs text-gray-400 mt-1">Wajib 10 digit. Akan digunakan sebagai Username login.
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIS</label>
                                <input type="number" name="nis" required placeholder="Contoh: 26001"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono">
                                <p class="text-xs text-orange-500 mt-1 font-semibold"><i class="fas fa-info-circle"></i> NIS
                                    akan otomatis menjadi Password login.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" required placeholder="Contoh: Budi Santoso"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all uppercase">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                                <div class="relative">
                                    <select name="id_kelas" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all appearance-none bg-white">
                                        <option value="" disabled selected>-- Pilih Kelas --</option>
                                        @foreach ($kelas as $k)
                                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun SPP / Tagihan</label>
                                <div class="relative">
                                    <select name="id_spp" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all appearance-none bg-white">
                                        <option value="" disabled selected>-- Pilih Tarif SPP --</option>
                                        @foreach ($spp as $s)
                                            <option value="{{ $s->id_spp }}">Tahun {{ $s->tahun }} - Rp
                                                {{ number_format($s->nominal, 0, ',', '.') }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon / WA</label>
                                <input type="number" name="no_telp" required placeholder="Contoh: 081234567890"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all font-mono">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" required placeholder="Masukkan alamat lengkap siswa..."
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all resize-none"></textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex items-center justify-end space-x-4 border-t border-gray-50 pt-6">
                            <a href="{{ route('siswa.index') }}"
                                class="text-gray-400 hover:text-gray-600 font-semibold px-4 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 transform hover:-translate-y-0.5 transition-all flex items-center">
                                <i class="fas fa-save mr-2"></i> Simpan Data Siswa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
