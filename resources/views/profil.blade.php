@extends('layouts.app') @section('title', 'Profil Pengguna')

@section('content')
    <div class="max-w-4xl mx-auto mt-6">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

            <div
                class="{{ $role == 'siswa' ? 'bg-gradient-to-r from-blue-500 to-blue-700' : 'bg-gradient-to-r from-blue-600 to-blue-800' }} px-8 py-8 text-white flex items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-10">
                    <i class="fas fa-id-card text-9xl -mt-4 -mr-4"></i>
                </div>

                <div
                    class="h-24 w-24 bg-white rounded-full flex items-center justify-center text-5xl shadow-lg z-10 {{ $role == 'siswa' ? 'text-blue-600' : 'text-blue-700' }}">
                    <i class="fas fa-user-circle"></i>
                </div>

                <div class="z-10">
                    <h2 class="text-3xl font-black tracking-wide">{{ $role == 'siswa' ? $user->nama : $user->nama_petugas }}
                    </h2>
                    <p
                        class="text-opacity-80 text-white mt-1 font-medium bg-black bg-opacity-20 inline-block px-3 py-1 rounded-full text-xs">
                        <i class="fas fa-shield-alt mr-1"></i> Hak Akses:
                        {{ strtoupper($role == 'siswa' ? 'SISWA' : $user->level) }}
                    </p>
                </div>
            </div>

            <div class="p-8 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-2">Informasi Detail</h3>

                @if ($role == 'siswa')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NISN</label>
                            <div class="text-gray-800 font-semibold text-lg">{{ $user->nisn }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIS</label>
                            <div class="text-gray-800 font-semibold text-lg">{{ $user->nis }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kelas</label>
                            <div class="text-gray-800 font-semibold text-lg">{{ $user->nama_kelas }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No WhatsApp /
                                Telepon</label>
                            <div class="text-gray-800 font-semibold text-lg">{{ $user->no_telp ?? '-' }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                Lengkap</label>
                            <div class="text-gray-800 font-semibold">{{ $user->alamat ?? 'Alamat belum diatur' }}</div>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">ID
                                Petugas</label>
                            <div class="text-gray-800 font-semibold text-lg">#{{ $user->id_petugas }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Username
                                Login</label>
                            <div class="text-gray-800 font-semibold text-lg flex items-center gap-2">
                                {{ $user->username }}
                                <span
                                    class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-bold">Aktif</span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="bg-white border-t border-gray-100 px-8 py-4 flex justify-end">
                <button onclick="history.back()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg transition-colors flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
            </div>

        </div>
    </div>
@endsection
