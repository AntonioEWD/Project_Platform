<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengumpulan Tugas: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('modules.show', $assignment->course_id) }}" class="text-red-600 hover:underline font-semibold">&larr; Kembali ke Ruang Kelas</a>
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

            <div class="bg-white p-8 shadow-sm sm:rounded-lg border-t-4 border-red-600">
                <div class="border-b border-gray-200 pb-4 mb-6 flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $assignment->title }}</h3>
                    <div class="px-3 py-1 bg-red-100 text-red-800 rounded-md text-sm font-bold">
                        Deadline: {{ $assignment->deadline->format('d M Y, H:i') }} WIB
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-lg font-bold text-gray-700 mb-2">Instruksi / Soal:</h4>
                    <div class="p-4 bg-gray-50 rounded-md border border-gray-200 text-gray-800 whitespace-pre-wrap">{{ $assignment->description }}</div>
                    
                    @if($assignment->file_path)
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $assignment->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-blue-700 hover:bg-gray-200 font-semibold transition">
                                📄 Download File Lampiran Soal
                            </a>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-6">
                    @if($mySubmission)
                        <div class="p-4 bg-green-50 border border-green-300 rounded-md">
                            <p class="text-green-800 font-bold mb-2">✅ Diserahkan pada {{ $mySubmission->created_at->format('d M Y, H:i') }}</p>
                            @if($mySubmission->notes)
                                <p class="text-sm text-gray-600 mb-3"><span class="font-bold">Catatan Anda:</span> {{ $mySubmission->notes }}</p>
                            @endif
                            <a href="{{ asset('storage/' . $mySubmission->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm font-semibold">
                                ⬇️ Download File Jawaban Anda
                            </a>
                        </div>
                    @elseif(now() > $assignment->deadline)
                        <div class="p-4 bg-gray-100 border border-gray-300 rounded-md text-center">
                            <p class="text-red-600 font-bold">Waktu pengumpulan tugas ini telah berakhir.</p>
                        </div>
                    @else
                        <form action="{{ route('submissions.store', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-6 rounded-md border border-gray-200">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pesan / Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md focus:border-red-500 shadow-sm"></textarea>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">File Jawaban <span class="text-red-500">*</span></label>
                                <input type="file" name="file" class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-red-100 file:text-red-700 hover:file:bg-red-200" required>
                                <p class="text-xs text-gray-500 mt-2">Maksimal ukuran file: 10MB.</p>
                            </div>
                            <button type="submit" class="w-full bg-red-600 text-white px-4 py-3 rounded-md font-bold hover:bg-red-700 transition shadow-md">
                                Kumpulkan Jawaban
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>