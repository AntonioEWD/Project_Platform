<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ruang Kelas: {{ $course->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:underline">&larr; Kembali ke Dashboard</a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Bagian Kiri: Daftar Materi --}}
                <div class="bg-white p-6 shadow-sm sm:rounded-lg col-span-2">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Materi Pembelajaran</h3>
                    
                    <div class="space-y-4">
                        @forelse($modules as $module)
                            <div class="p-4 bg-gray-50 border border-gray-200 rounded-md">
                                <h4 class="font-bold text-indigo-700">{{ $module->title }}</h4>
                                <p class="text-sm text-gray-600 mt-2">{{ $module->content }}</p>
                                
                                @if($module->file_path)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                            📄 Download / Lihat Materi
                                        </a>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">Diunggah: {{ $module->created_at->format('d M Y') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-6">Belum ada materi yang diunggah oleh dosen.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Bagian Kanan: Daftar Tugas (VERSI BERSIH) --}}
                <div class="bg-white p-6 shadow-sm sm:rounded-lg col-span-1 h-fit">
                    <h3 class="text-lg font-bold text-red-600 mb-4 border-b pb-2">Daftar Tugas</h3>
                    
                    <div class="space-y-4">
                        @forelse($assignments as $assignment)
                            <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                                <h4 class="font-bold text-red-800">{{ $assignment->title }}</h4>
                                
                                <div class="mt-3 p-2 bg-white rounded border border-red-100 text-sm">
                                    <span class="font-semibold text-gray-600">Deadline:</span><br>
                                    <span class="text-red-600 font-bold">{{ $assignment->deadline->format('d M Y, H:i') }} WIB</span>
                                </div>

                                {{-- Tombol yang mengarah ke halaman khusus tugas --}}
                                <a href="{{ route('assignments.show', $assignment->id) }}" class="mt-4 block text-center w-full bg-red-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-red-700 transition shadow-sm">
                                    Lihat & Kumpulkan Tugas
                                </a>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-6">Belum ada tugas yang diberikan.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>