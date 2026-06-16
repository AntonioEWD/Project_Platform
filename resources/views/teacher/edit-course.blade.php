<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('courses.update', $course->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT') <div>
                            <x-input-label for="title" :value="__('Judul Mata Kuliah')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $course->title }}" required />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Singkat')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4" required>{{ $course->description }}</textarea>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui Kelas') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>