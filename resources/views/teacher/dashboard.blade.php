<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-xl font-bold text-indigo-600">Kelas Yang Saya Ajar</h3>
                        {{-- Sesuaikan dengan nama route tambah kelas Anda jika ada --}}
                        <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700">
                            + Tambah Kelas Baru
                        </a>
                    </div>
                    
                    @if($myTeachingCourses->isEmpty())
                        <p class="text-gray-500">Anda belum membuat kelas materi apa pun.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($myTeachingCourses as $course)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                    <h4 class="font-bold text-lg text-gray-800">{{ $course->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex gap-2">
                                        <a href="{{ route('modules.show', $course->id) }}" class="w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-md text-sm font-semibold transition">
                                            Kelola Kelas
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>