<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-indigo-600 mb-4 border-b pb-2">Kelas Aktif Saya</h3>
                    
                    @if($myCourses->isEmpty())
                        <p class="text-gray-500">Anda belum mendaftar ke kelas mana pun.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($myCourses as $course)
                                <div class="border border-indigo-200 rounded-lg p-4 bg-indigo-50">
                                    <h4 class="font-bold text-lg text-gray-800">{{ $course->title }}</h4>
                                    <p class="text-sm text-gray-600 mt-2">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                                    <div class="mt-4 pt-4 border-t border-indigo-100">
                                        <a href="{{ route('modules.show', $course->id) }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-semibold transition">
                                            Masuk Kelas
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Eksplorasi Kelas Tersedia</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($availableCourses as $course)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                <h4 class="font-bold text-lg text-gray-800">{{ $course->title }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Dosen: {{ $course->teacher->name ?? 'Tidak diketahui' }}</p>
                                <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($course->description, 80) }}</p>
                                
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    @if(Auth::user()->enrolledCourses->contains($course->id))
                                        <span class="inline-block w-full text-center bg-gray-200 text-gray-600 px-4 py-2 rounded-md text-sm font-semibold">
                                            Sudah Terdaftar
                                        </span>
                                    @else
                                        <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="background-color: #16a34a; color: white;" class="w-full px-4 py-2 rounded-md text-sm font-semibold transition hover:opacity-80">
                                                Daftar Kelas Ini
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>