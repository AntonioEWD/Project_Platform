<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Informatika</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">LMS Informatika USD</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Login</a>
                <a href="{{ route('register') }}" class="text-gray-600 hover:text-blue-600 font-semibold">Daftar</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-4">
        <h2 class="text-3xl font-semibold mb-6 text-center text-gray-800">Daftar Kelas Tersedia</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $c)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6 hover:scale-105 transition-transform duration-300 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $c->title }}</h3>
                    <p class="text-gray-600 mt-2 text-sm">Pengajar: <span class="font-semibold">{{ $c->teacher->name ?? 'Belum diketahui' }}</span></p>
                    <p class="text-gray-500 mt-4 mb-4 text-sm">{{ \Illuminate\Support\Str::limit($c->description, 100) }}</p>
                </div>
                
                {{-- Diarahkan ke halaman login karena pengunjung belum masuk --}}
                <a href="{{ route('login') }}" class="block text-center w-full mt-auto bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                    Login untuk Melihat Materi
                </a>
            </div>
            @empty
            <div class="col-span-3 text-center py-10">
                <p class="text-gray-500 text-lg">Belum ada kelas yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <footer class="mt-12 bg-gray-800 p-6 text-center text-gray-400">
        <p>&copy; 2026 - Sistem LMS Terpadu</p>
    </footer>

</body>
</html>