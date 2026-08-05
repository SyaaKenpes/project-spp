<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EduPay SPP</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <!-- Tailwind & FontAwesome CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex min-h-screen">

    <!-- Panggil Sidebar di sini -->
    @include('layouts.sidebar')

    <!-- Kolom Kanan (Topbar + Konten Utama) -->
    <div class="flex-1 flex flex-col">

        <!-- Panggil Topbar di sini -->
        @include('layouts.topbar')

        <!-- Area Konten Utama yang dinamis -->
        <main class="p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>



    </div>

    <script>
        // Fungsi buat nampilin pop-up (ngehapus class 'hidden')
        function bukaModal() {
            document.getElementById('modalLogout').classList.remove('hidden');
        }

        // Fungsi buat nutup pop-up (nambahin class 'hidden')
        function tutupModal() {
            document.getElementById('modalLogout').classList.add('hidden');
        }
    </script>

</body>

</html>
