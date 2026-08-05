@extends('layouts.app')

@section('title', 'Entry Transaksi SPP')

@section('content')
    <div class="p-6">
        <div class="max-w-4xl mx-auto">

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r-lg animate-pulse">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-xl"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 shadow-sm rounded-r-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                        <span class="font-bold">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="bg-blue-900 p-6 flex justify-between items-center text-white">
                    <div>
                        <h3 class="text-2xl font-black tracking-wider"><i class="fas fa-cash-register mr-3"></i>MESIN KASIR
                            EDUPAY</h3>
                        <p class="text-blue-200 text-sm mt-1">Sistem Input Pembayaran SPP Siswa</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-blue-300 font-mono uppercase tracking-widest mb-1">Petugas Kasir</p>
                        <p class="font-bold text-lg text-yellow-300">{{ session('nama_petugas') ?? 'Admin' }}</p>
                    </div>
                </div>

                <div class="p-8 bg-gray-50">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Siswa</label>
                                <div class="relative">
                                    <select name="nisn" id="pilihSiswa" onchange="hitungKalkulator()" required
                                        class="w-full px-4 py-4 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 outline-none transition-all appearance-none bg-white font-semibold text-gray-800 shadow-sm">
                                        <option value="" data-nominal="0" disabled selected>-- Cari Nama Siswa / NISN
                                            --</option>
                                        @foreach ($siswa as $s)
                                            <option value="{{ $s->nisn }}" data-nominal="{{ $s->nominal }}">
                                                {{ $s->nisn }} - {{ $s->nama }} | (Tagihan: Rp
                                                {{ number_format($s->nominal, 0, ',', '.') }}/bln)
                                            </option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-gray-400">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Bulan Dibayar</label>
                                <div class="relative">
                                    <select name="bulan_dibayar" required
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all appearance-none bg-white font-semibold">
                                        <option value="" disabled selected>-- Pilih Bulan --</option>
                                        @php
                                            $bulan = [
                                                'Januari',
                                                'Februari',
                                                'Maret',
                                                'April',
                                                'Mei',
                                                'Juni',
                                                'Juli',
                                                'Agustus',
                                                'September',
                                                'Oktober',
                                                'November',
                                                'Desember',
                                            ];
                                        @endphp
                                        @foreach ($bulan as $b)
                                            <option value="{{ $b }}">{{ $b }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                        <i class="fas fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tahun Dibayar</label>
                                <input type="number" name="tahun_dibayar" required placeholder="Contoh: 2026"
                                    value="{{ date('Y') }}"
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition-all font-mono font-bold text-gray-800 shadow-sm">
                            </div>

                            <div class="md:col-span-2 mt-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Uang Diterima (Dari
                                    Siswa)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <span class="text-green-600 font-black text-xl">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah_bayar" id="inputBayar" onkeyup="hitungKalkulator()"
                                        required placeholder="0" min="1000"
                                        class="w-full pl-16 pr-4 py-5 rounded-xl border-2 border-green-200 focus:border-green-500 focus:ring-4 focus:ring-green-100 outline-none transition-all font-mono text-3xl text-green-700 font-black shadow-inner bg-green-50">
                                </div>
                            </div>

                            <div class="md:col-span-2 bg-blue-50 p-5 rounded-xl border border-blue-200 mt-2 shadow-inner">
                                <h4 class="font-black text-blue-900 mb-4 border-b border-blue-200 pb-2"><i
                                        class="fas fa-calculator mr-2"></i> RINGKASAN PEMBAYARAN</h4>

                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 font-semibold">Tagihan SPP:</span>
                                    <span class="font-bold text-gray-800 text-lg" id="teksTagihan">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 font-semibold">Biaya Admin:</span>
                                    <span class="font-bold text-gray-800 text-lg">Rp 2.000</span>
                                </div>

                                <hr class="border-blue-200 my-3">

                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-blue-900 font-black text-lg">Total Harus Dibayar:</span>
                                    <span class="font-black text-2xl text-blue-900" id="teksTotal">Rp 0</span>
                                </div>

                                <div
                                    class="flex justify-between items-center bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <span class="text-gray-700 font-black text-lg">KEMBALIAN:</span>
                                    <span class="font-black text-3xl text-gray-400" id="teksKembalian">Rp 0</span>
                                </div>
                            </div>

                        </div>

                        <div class="mt-10 flex items-center justify-end space-x-4 border-t border-gray-200 pt-6">
                            <button type="submit"
                                class="w-full md:w-auto bg-blue-600 hover:bg-blue-800 text-white px-10 py-4 rounded-xl font-black tracking-wide shadow-xl shadow-blue-200 transform hover:-translate-y-1 transition-all flex items-center justify-center">
                                <i class="fas fa-print mr-3"></i> PROSES PEMBAYARAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hitungKalkulator() {
            // 1. Ambil elemen yang dibutuhin
            const selectSiswa = document.getElementById('pilihSiswa');
            const inputBayar = document.getElementById('inputBayar');

            // 2. Ambil nilai nominal dari siswa yang dipilih
            const opsiDipilih = selectSiswa.options[selectSiswa.selectedIndex];
            const nominalSpp = parseInt(opsiDipilih.getAttribute('data-nominal')) || 0;

            // 3. Tentukan Biaya Admin
            const biayaAdmin = 2000;
            let totalTagihan = 0;

            // 4. Update teks UI Tagihan & Total
            if (nominalSpp > 0) {
                totalTagihan = nominalSpp + biayaAdmin;
                document.getElementById('teksTagihan').innerText = 'Rp ' + nominalSpp.toLocaleString('id-ID');
                document.getElementById('teksTotal').innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
            } else {
                document.getElementById('teksTagihan').innerText = 'Rp 0';
                document.getElementById('teksTotal').innerText = 'Rp 0';
            }

            // 5. Hitung Kembalian
            const uangMasuk = parseInt(inputBayar.value) || 0;
            const kembalianEl = document.getElementById('teksKembalian');

            if (uangMasuk === 0 || totalTagihan === 0) {
                kembalianEl.innerText = 'Rp 0';
                kembalianEl.className = 'font-black text-3xl text-gray-400'; // Warna abu-abu kalau kosong
            } else {
                const hasilKembalian = uangMasuk - totalTagihan;

                if (hasilKembalian < 0) {
                    kembalianEl.innerText = 'UANG KURANG!';
                    kembalianEl.className =
                    'font-black text-3xl text-red-500 animate-pulse'; // Warna merah kedip kalau kurang
                } else {
                    kembalianEl.innerText = 'Rp ' + hasilKembalian.toLocaleString('id-ID');
                    kembalianEl.className = 'font-black text-3xl text-green-500'; // Warna ijo kalau pas/lebih
                }
            }
        }
    </script>
@endsection
