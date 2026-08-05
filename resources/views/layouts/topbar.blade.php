<!-- resources/views/layouts/topbar.blade.php -->
<div class="bg-white h-16 px-8 flex items-center justify-between shadow-sm border-b border-gray-200">
    <!-- Judul Halaman -->
    <h1 class="text-xl font-bold text-gray-800">
        @yield('title', 'Dashboard')
    </h1>

    <!-- Ikon Kanan -->
    <div class="flex items-center space-x-6">
        <!-- Tombol Tanda Tanya (PANDUAN AKTIF) -->
        <button onclick="toggleHelpModal()"
            class="text-gray-400 hover:text-blue-600 transition-colors focus:outline-none">
            <i class="far fa-question-circle text-xl"></i>
        </button>

        <!-- User Profile Icon -->
        <a href="{{ url('/profil') }}"
            class="h-8 w-8 bg-blue-900 hover:bg-blue-800 rounded-full flex items-center justify-center text-white cursor-pointer shadow-md transition-all duration-300 transform hover:scale-110">
            <i class="fas fa-user text-sm"></i>
        </a>
    </div>
</div>

<!-- MODAL PANDUAN PENGGUNAAN EDUPAY (OTOMATIS DETEKSI ROLE & URL)            -->
<div id="helpModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex items-center justify-center p-4">
    <!-- Card Modal Box -->
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-100 transform transition-all duration-300">

        <!-- LOGIKA SAKTI DETEKSI SISWA (Berdasarkan Guard, URL, atau Kolom User) -->
        @if (request()->is('*siswa*') ||
                (auth()->user() &&
                    (auth()->user()->level == 'siswa' || auth()->user()->level == 'Siswa' || isset(auth()->user()->nisn))))
            <!-- TAMPILAN PANDUAN KHUSUS SISWA              -->
            <div class="bg-blue-600 px-6 py-4 text-white flex justify-between items-center">
                <h3 class="font-bold text-lg flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i> Panduan Siswa (EduPay)
                </h3>
                <button onclick="toggleHelpModal()"
                    class="text-white opacity-80 hover:opacity-100 text-2xl font-bold focus:outline-none">&times;</button>
            </div>

            <div class="p-6 space-y-4 text-sm text-gray-600">
                <p class="font-semibold text-gray-800 mb-2">Halo, Selamat Datang! Berikut hal yang bisa kamu lakukan:
                </p>

                <div class="flex gap-3 items-start">
                    <div
                        class="bg-blue-50 text-blue-600 font-bold h-6 w-6 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-xs border border-blue-100">
                        1</div>
                    <p>Cek halaman <strong class="text-gray-900">Dashboard</strong> untuk melihat info ringkas status
                        pembayaran SPP kamu.</p>
                </div>
            </div>

            <!-- Footer Modal Siswa -->
            <div class="bg-gray-50 px-6 py-3.5 flex justify-end border-t border-gray-100">
                <button onclick="toggleHelpModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium text-xs shadow-sm transition-colors focus:outline-none">
                    Oke, Saya Paham
                </button>
            </div>
        @else
            <!-- TAMPILAN PANDUAN KHUSUS ADMIN / PETUGAS    -->
            <div class="bg-blue-600 px-6 py-4 text-white flex justify-between items-center">
                <h3 class="font-bold text-lg flex items-center">
                    <i class="fas fa-book-reader mr-2"></i> Petunjuk Admin (EduPay)
                </h3>
                <button onclick="toggleHelpModal()"
                    class="text-white opacity-80 hover:opacity-100 text-2xl font-bold focus:outline-none">&times;</button>
            </div>

            <div class="p-6 space-y-4 text-sm text-gray-600">
                <p class="font-semibold text-gray-800 mb-2">Halo Admin! Berikut alur cepat manajemen SPP:</p>

                <div class="flex gap-3 items-start">
                    <div
                        class="bg-blue-50 text-blue-600 font-bold h-6 w-6 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-xs border border-blue-100">
                        1</div>
                    <p>Pastikan data <strong class="text-gray-900">Kelas</strong> dan tarif <strong
                            class="text-gray-900">SPP</strong> sudah diinput dengan benar di menu Master Data sebelum
                        mengelola siswa.</p>
                </div>

                <div class="flex gap-3 items-start">
                    <div
                        class="bg-blue-50 text-blue-600 font-bold h-6 w-6 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-xs border border-blue-100">
                        2</div>
                    <p>Gunakan fitur <strong class="text-gray-900">Cek Tunggakan</strong> untuk melihat daftar siswa per
                        kelas beserta riwayat bulan nunggak/lunas mereka.</p>
                </div>

                <div class="flex gap-3 items-start">
                    <div
                        class="bg-blue-50 text-blue-600 font-bold h-6 w-6 rounded-full flex items-center justify-center shrink-0 mt-0.5 text-xs border border-blue-100">
                        3</div>
                    <p>Jika ada siswa yang ingin bayar, masuk ke menu <strong class="text-gray-900">Entry
                            Transaksi</strong>, ketik NISN-nya, lalu pilih bulan yang ingin dilunasi.</p>
                </div>
            </div>

            <!-- Footer Modal Admin -->
            <div class="bg-gray-50 px-6 py-3.5 flex justify-end border-t border-gray-100">
                <button onclick="toggleHelpModal()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium text-xs shadow-sm transition-colors focus:outline-none">
                    Saya Mengerti
                </button>
            </div>
        @endif

    </div>
</div>

<!-- BUAT BUKA TUTUP POP-UP MODAL -->
<script>
    function toggleHelpModal() {
        const modal = document.getElementById('helpModal');
        modal.classList.toggle('hidden');
    }
</script>
