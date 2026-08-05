@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
    <div class="p-6">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                    <span class="font-bold">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-blue-900">Daftar Akun Petugas</h3>
                    <p class="text-xs text-gray-500">Kelola hak akses admin dan petugas lapangan</p>
                </div>
                <a href="{{ route('petugas.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-lg shadow-blue-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Petugas
                </a>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 px-2">ID Petugas</th>
                            <th class="pb-3">Username</th>
                            <th class="pb-3">Nama Lengkap</th>
                            <th class="pb-3 text-center">Jabatan</th>
                            <th class="pb-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach ($petugas as $p)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-2">
                                    <span
                                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded font-mono text-xs">{{ $p->id_petugas }}</span>
                                </td>
                                <td class="py-4 font-medium text-gray-800">{{ $p->username }}</td>
                                <td class="py-4">{{ $p->nama_petugas }}</td>
                                <td class="py-4 text-center">
                                    @if ($p->level == 'admin')
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                            <i class="fas fa-user-shield mr-1"></i> ADMIN
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600">
                                            <i class="fas fa-user mr-1"></i> PETUGAS
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-center">
                                    <div class="flex justify-center items-center space-x-3">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('petugas.edit', $p->id_petugas) }}"
                                            class="text-blue-500 hover:text-blue-700 transition-colors p-2 hover:bg-blue-50 rounded-lg">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('petugas.destroy', $p->id_petugas) }}" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus data {{ $p->nama_petugas }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-red-700 transition-colors p-2 hover:bg-red-50 rounded-lg">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($petugas->isEmpty())
                    <div class="text-center py-10">
                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-3"></i>
                        <p class="text-gray-400">Belum ada data petugas nih cuy.</p>
                    </div>
                @endif

                <div class="mt-6 px-4">
                    {{ $petugas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
