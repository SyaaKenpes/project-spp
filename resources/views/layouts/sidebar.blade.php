<div class="w-64 bg-blue-900 text-white min-h-screen flex flex-col shadow-lg">
    <div class="p-6">
        <h2 class="text-xl font-bold uppercase tracking-wider">EduPay
            {{ ucfirst(Session::get('login_sebagai', 'Guest')) }}</h2>
        <p class="text-blue-300 text-xs mt-1">Sistem Pembayaran SPP</p>
    </div>

    <nav class="flex-1 mt-4 flex flex-col">

        @php
            $dashLink = '#';
            $role = Session::get('login_sebagai');
            if ($role == 'admin') {
                $dashLink = route('admin.dashboard');
            } elseif ($role == 'petugas') {
                $dashLink = route('petugas.dashboard');
            } elseif ($role == 'siswa') {
                $dashLink = route('siswa.dashboard');
            }

            // Variabel bantu buat class active
            $activeClass = 'bg-blue-800 text-white border-l-4 border-yellow-400';
            $defaultClass =
                'flex items-center px-6 py-3 text-blue-200 hover:bg-blue-800 hover:text-white transition-colors';
        @endphp

        <a href="{{ $dashLink }}"
            class="{{ $defaultClass }} {{ request()->is('admin/dashboard', 'petugas/dashboard', 'siswa/dashboard') ? $activeClass : '' }}">
            <i class="fas fa-home w-6 text-center mr-2"></i>
            <span>Dashboard</span>
        </a>

        @if ($role == 'admin')
            <a href="{{ route('petugas.index') }}"
                class="{{ $defaultClass }} {{ request()->is('admin/petugas*') ? $activeClass : '' }}">
                <i class="fas fa-user-shield w-6 text-center mr-2"></i>
                <span>Data Petugas</span>
            </a>

            <a href="{{ route('siswa.index') }}"
                class="{{ $defaultClass }} {{ request()->routeIs('siswa.*') ? $activeClass : '' }}"">
                <i class="fas fa-users w-6 text-center mr-2"></i>
                <span>Data Siswa</span>
            </a>

            <a href="{{ route('kelas.index') }}"
                class="{{ $defaultClass }} {{ request()->routeIs('kelas.*') ? $activeClass : '' }}">
                <i class="fas fa-chalkboard w-6 text-center mr-2"></i>
                <span>Data Kelas</span>
            </a>

            <a href="{{ route('spp.index') }}"
                class="{{ $defaultClass }} {{ request()->routeIs('spp.*') ? $activeClass : '' }}">
                <i class="fas fa-money-bill-wave w-6 text-center mr-2"></i>
                <span>Data SPP</span>
            </a>
        @endif

        @if ($role == 'admin' || $role == 'petugas')
            <a href="{{ route('transaksi.create') }}"
                class="{{ $defaultClass }} {{ request()->routeIs('transaksi.create') ? $activeClass : '' }}">
                <i class="fas fa-cash-register w-6 text-center mr-2"></i>
                <span>Entry Transaksi</span>
            </a>

            <a href="{{ route('transaksi.cek-tunggakan') }}"
                class="{{ $defaultClass }} {{ request()->routeIs('transaksi.cek-tunggakan') ? $activeClass : '' }}">
                <div class="mr-3 w-5 text-center text-lg text-white-400">
                    <i class="fas fa-search-dollar"></i>
                </div>
                <span class="font-medium text-base">Cek Tunggakan</span>
                </a>

                <a href="{{ route('transaksi.index') }}"
                    class="{{ $defaultClass }} {{ request()->routeIs('transaksi.index*') ? $activeClass : '' }}"">
                    <i class="fas fa-history w-6 text-center mr-2"></i>
                    <span>History Pembayaran</span>
                </a>
        @endif



    </nav>

    <div class="p-4 mb-2">
        <hr class="border-blue-700 mb-4">
        <button type="button" onclick="bukaModal()"
            class="w-full flex items-center px-4 py-3 text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors font-medium shadow-md">
            <i class="fas fa-sign-out-alt w-6 text-center mr-2"></i>
            <span>Logout</span>
        </button>
    </div>
</div>

<div id="modalLogout"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center transform transition-all">

        <div class="flex justify-center mb-5">
            <div class="bg-red-50 p-4 rounded-full">
                <i class="fas fa-sign-out-alt text-red-600 text-4xl"></i>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-blue-900 mb-2">Konfirmasi Keluar</h3>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">
            Apakah Anda yakin ingin keluar dari sistem? Pastikan semua transaksi hari ini telah tersimpan dengan benar.
        </p>

        <div class="flex space-x-4">
            <button type="button" onclick="tutupModal()"
                class="flex-1 py-3 border-2 border-gray-200 rounded-xl text-gray-600 font-bold hover:bg-gray-50 hover:border-gray-300 transition-all">
                BATAL
            </button>

            <form action="/logout" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    KELUAR
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function bukaModal() {
        document.getElementById('modalLogout').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modalLogout').classList.add('hidden');
    }
</script>
