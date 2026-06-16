<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Kelas: {{ $course->title }}
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Form ini HANYA akan muncul jika user yang login adalah Dosen pemilik kelas --}}
                @if(Auth::id() === $course->teacher_id)
                <div class="bg-white p-6 shadow-sm sm:rounded-lg col-span-1 h-fit">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Unggah Materi Baru</h3>
                    <form action="{{ route('modules.store', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <x-input-label for="title" :value="__('Judul Materi')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="content" :value="__('Instruksi / Teks (Opsional)')" />
                            <textarea id="content" name="content" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>

                        <div>
                            <x-input-label for="file" :value="__('File Lampiran (Opsional, Maks 10MB)')" />
                            <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                        </div>

                        <x-primary-button class="w-full justify-center">{{ __('Simpan Materi') }}</x-primary-button>
                    </form>
                </div>
                @endif

                {{-- Kolom Daftar Materi: Akan memakan 2 kolom jika di layar dosen, dan layar penuh (3 kolom) di layar mahasiswa --}}
                <div class="bg-white p-6 shadow-sm sm:rounded-lg {{ Auth::id() === $course->teacher_id ? 'col-span-2' : 'col-span-3 md:col-span-3' }}">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Materi Pembelajaran</h3>
                    
                    <div class="space-y-4">
                        @forelse($modules as $module)
                            <div class="p-4 bg-gray-50 border border-gray-200 rounded-md">
                                <h4 class="font-bold text-indigo-700">{{ $module->title }}</h4>
                                <p class="text-sm text-gray-600 mt-2">{{ $module->content }}</p>
                                
                                @if($module->file_path)
                                    <div class="mt-3 pt-3 border-t border-gray-200">
                                        <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                                            📄 Lihat File Lampiran
                                        </a>
                                    </div>
                                @endif
                                <p class="text-xs text-gray-400 mt-2">Dibuat pada: {{ $module->created_at->format('d M Y') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-6">Belum ada materi yang diunggah.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>