<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EduPay SPP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        input[type="radio"]:checked+label {
            background-color: #000080;
            /* Navy Blue */
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen items-center justify-center p-4">

    <!-- Card Utama -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md border border-gray-200">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <div class="bg-blue-900 p-4 rounded-xl shadow-md">
                <i class="fas fa-university text-white text-3xl"></i>
            </div>
        </div>

        <!-- Judul -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">EduPay</h1>
            <h1 class="text-2xl font-bold text-blue-900">Sistem Informasi Pembayaran SPP</h1>
            <p class="text-gray-500 text-sm mt-2">Silakan masuk untuk mengelola keuangan sekolah</p>
        </div>

        <!-- Peringatan jika validasi gagal (Kurang 8 karakter / Tidak ada angka) -->
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-5 shadow-sm rounded-r">
                <ul class="text-sm font-medium">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Peringatan jika Username / Password salah -->
        @if (session('error'))
            <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-3 mb-5 shadow-sm rounded-r">
                <p class="text-sm font-medium"><i class="fas fa-times-circle mr-1"></i> {{ session('error') }}</p>
            </div>
        @endif

        <!-- ========================================== -->

        <form action="/login" method="POST">
            @csrf <!-- CSRF Protection bawaan Laravel -->

            <!-- Input Username / NISN -->
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Username /
                    NISN</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="far fa-user"></i>
                    </span>
                    <input type="text" name="username" placeholder="Masukkan ID Anda"
                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent outline-none transition-all">
                </div>
            </div>

            <!-- Input Password -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" placeholder="Masukkan kata sandi"
                        class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent outline-none transition-all">
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer">
                        <i class="far fa-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Tombol Masuk -->
            <button type="submit"
                class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow-lg transition-all transform hover:-translate-y-1 active:scale-95">
                Masuk ke Sistem
            </button>
        </form>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-xs text-gray-400">
        <p><i class="fas fa-shield-alt"></i> Sistem Pembayaran Terenkripsi & Aman</p>
        <p class="mt-4">&copy; 2026 Sistem Informasi Pembayaran SPP. EduPay -- SMKN 7 Baleendah</p>
    </div>

</body>

</html>
