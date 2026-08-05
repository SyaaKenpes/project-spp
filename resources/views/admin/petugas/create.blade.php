@extends('layouts.app')

{{-- 1. Setor Judul ke Topbar --}}
@section('title', 'Tambah Petugas Baru')

{{-- 2. Isi Konten Utama --}}
@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-blue-900">Formulir Petugas Baru</h3>
                    <p class="text-gray-500 text-xs">Lengkapi data di bawah untuk membuat akun akses sistem.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('petugas.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_petugas" required
                                    placeholder="Masukkan nama lengkap petugas..."
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                    <input type="text" name="username" required placeholder="Contoh: famm_li"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                                    <select name="level"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all bg-white">
                                        <option value="petugas">Petugas Biasa</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <input type="password" name="password" required placeholder="Buat password yang kuat..."
                                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition-all">
                            </div>
                        </div>

                        <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-50 pt-6">
                            <a href="{{ route('petugas.index') }}"
                                class="text-gray-400 hover:text-gray-600 font-semibold px-4 transition-colors">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-100 transform hover:-translate-y-0.5 transition-all">
                                Simpan Akun Petugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
