@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <div class="p-6">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div
                class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg animate-pulse">
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
                    <h3 class="text-lg font-bold text-blue-900">Daftar Kelas</h3>
                    <p class="text-xs text-gray-500">Kelola data kelas dan kompetensi keahlian {{ date('Y') }}</p>
                </div>
                <a href="{{ route('kelas.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-lg shadow-blue-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle mr-2"></i>Tambah Kelas
                </a>
            </div>

            <div class="overflow-x-auto p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-400 text-sm uppercase tracking-wider border-b border-gray-100">
                            <th class="pb-3 px-2">ID</th>
                            <th class="pb-3">Nama Kelas</th>
                            <th class="pb-3 text-center">Jurusan</th>
                            <th class="pb-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach ($kelas as $k)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-2">
                                    <span
                                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded font-mono text-xs">{{ $k->id_kelas }}</span>
                                </td>
                                <td class="py-4 font-bold text-blue-900">{{ $k->nama_kelas }}</td>
                                <td class="py-4 text-center">
                                    @php
                                        // Atur warna badge berdasarkan singkatan jurusan
                                        $colorMap = [
                                            'PPLG' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'TAV' => 'bg-red-100 text-red-700 border-red-200',
                                            'DPIB' => 'bg-orange-100 text-orange-700 border-orange-200',
                                            'TSM' => 'bg-red-100 text-red-700 border-red-200',
                                            'TKR' => 'bg-navy-100 text-navy-700 border-navy-200',
                                        ];
                                        $badgeStyle =
                                            $colorMap[$k->kompetensi_keahlian] ??
                                            'bg-gray-100 text-gray-700 border-gray-200';
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-full text-xs font-extrabold border {{ $badgeStyle }}">
                                        {{ $k->kompetensi_keahlian }}
                                    </span>
                                </td>
                                <td class="py-4 text-center">
                                    <div class="flex justify-center items-center space-x-3">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('kelas.edit', $k->id_kelas) }}"
                                            class="text-blue-500 hover:text-blue-700 transition-colors p-2 hover:bg-blue-50 rounded-lg">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('kelas.destroy', $k->id_kelas) }}" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus kelas {{ $k->nama_kelas }}?')">
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

                @if ($kelas->isEmpty())
                    <div class="text-center py-10">
                        <div class="bg-gray-50 inline-block p-6 rounded-full mb-4">
                            <i class="fas fa-chalkboard text-gray-300 text-5xl"></i>
                        </div>
                        <p class="text-gray-400 font-medium">Belum ada data kelas nih, cuy. Coba tambah dulu!</p>
                    </div>
                @endif

                {{-- PAGINATION --}}
                <div class="mt-8 border-t border-gray-50 pt-6">
                    {{ $kelas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
