<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController; 
use App\Http\Controllers\ModuleController; // 1. Tambahan import ModuleController di sini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Course;

// 1. Rute Halaman Utama (Welcome)
Route::get('/', function () {
    $courses = [
        [
            'judul' => 'Pengantar Pemrograman Web', 
            'pengajar' => 'Dimas Rizky', 
            'deskripsi' => 'Mempelajari dasar routing, MVC, dan Blade.'
        ],
        [
            'judul' => 'Machine Learning Fundamental', 
            'pengajar' => 'Dimas Rizky', 
            'deskripsi' => 'Implementasi algoritma Support Vector Machine dan ANN.'
        ],
        [
            'judul' => 'Manajemen Basis Data', 
            'pengajar' => 'Dimas Rizky', 
            'deskripsi' => 'Merancang relasi tabel dan migrasi sistem.'
        ]
    ];

    return view('welcome', compact('courses'));
});

// 2. Rute Dashboard 
Route::get('/dashboard', function () {
    // Logika Khusus Dosen
    if (Auth::user()->role === 'teacher') {
        $courses = Course::where('teacher_id', Auth::id())->get();
        return view('teacher.dashboard', compact('courses'));
    }

    // Logika Khusus Mahasiswa (Enrolled Courses + Available Courses)
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $myCourses = $user->enrolledCourses; 
    $availableCourses = Course::with('teacher')->get(); 

    return view('dashboard', compact('myCourses', 'availableCourses'));
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Rute Manajemen Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Rute Pendaftaran Kelas Mahasiswa 
Route::middleware(['auth'])->group(function () {
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
});

// 5. Rute khusus Dosen untuk manajemen kelas dan modul 
Route::middleware(['auth', 'role:teacher'])->group(function () {
    // CRUD Kelas
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // 2. Manajemen Modul
    Route::get('/courses/{course}/manage', [ModuleController::class, 'show'])->name('courses.manage');
    Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('modules.store');
});

// 6. Rute Autentikasi Breeze
require __DIR__.'/auth.php';