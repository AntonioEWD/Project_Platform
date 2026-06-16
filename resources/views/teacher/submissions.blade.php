
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jawaban Mahasiswa: {{ $assignment->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center">
                <a href="{{ route('modules.show', $assignment->course_id) }}" class="text-red-600 hover:underline font-semibold">&larr; Kembali ke Kelas</a>
            </div>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg border-t-4 border-red-600">
                <div class="mb-6 pb-4 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-900">Daftar Pengumpulan</h3>
                    <p class="text-sm text-gray-600 mt-1">Total Mengumpulkan: <span class="font-bold">{{ $submissions->count() }} Mahasiswa</span></p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="p-4 border-b font-bold">Nama Mahasiswa</th>
                                <th class="p-4 border-b font-bold">Waktu Pengumpulan</th>
                                <th class="p-4 border-b font-bold">Catatan</th>
                                <th class="p-4 border-b font-bold">File Jawaban</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-4 border-b font-semibold text-gray-800">{{ $submission->student->name }}</td>
                                    <td class="p-4 border-b text-sm text-gray-600">
                                        {{ $submission->created_at->format('d M Y, H:i') }}
                                        @if($submission->created_at > $assignment->deadline)
                                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded font-bold">Terlambat</span>
                                        @else
                                            <span class="ml-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded font-bold">Tepat Waktu</span>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b text-sm text-gray-600">{{ $submission->notes ?? '-' }}</td>
                                    <td class="p-4 border-b">
                                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-md text-sm font-semibold border border-indigo-200 hover:bg-indigo-100 transition">
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500 font-semibold">
                                        Belum ada mahasiswa yang mengumpulkan tugas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>