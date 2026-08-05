@extends('layouts.app')

@section('title', 'Cek Tunggakan per Kelas')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Cek Tunggakan SPP per Kelas</h2>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form action="{{ route('transaksi.cek-tunggakan') }}" method="GET" class="flex gap-4 items-end">
                <div class="w-1/2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kelas</label>
                    <select name="id_kelas"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"
                        required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($daftarKelas as $dk)
                            <option value="{{ $dk->id_kelas }}"
                                {{ request('id_kelas') == $dk->id_kelas ? 'selected' : '' }}>
                                {{ $dk->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    <i class="fas fa-history w-6 text-center mr-2"></i> Tampilkan Siswa
                </button>
            </form>
        </div>

        @if (request('id_kelas'))
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Siswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-sm font-bold text-gray-600 uppercase">
                                <th class="p-4 text-center">No</th>
                                <th class="p-4">NISN</th>
                                <th class="p-4">Nama Siswa</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @php $no = 1; @endphp
                            @forelse($siswa_list as $s)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 text-center">{{ $no++ }}</td>
                                    <td class="p-4 font-mono font-medium">{{ $s->nisn }}</td>
                                    <td class="p-4 font-bold text-gray-900">{{ $s->nama }}</td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('transaksi.detail-tunggakan', $s->nisn) }}"
                                            class="inline-flex items-center justify-center bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-colors">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            <span>Periksa Tunggakan</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500 font-medium">Tidak ada data
                                        siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
