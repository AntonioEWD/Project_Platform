<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\DashboardController;
use App\Models\Course; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;

// Halaman Utama (Landing Page)
Route::get('/', function () {
    // Mengambil 6 kelas terbaru beserta data dosennya
    $courses = Course::with('teacher')->latest()->take(6)->get();
    
    return view('welcome', compact('courses'));
});

// Route Dashboard Mengarah ke Controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route Group untuk Fitur yang Membutuhkan Login
Route::middleware('auth')->group(function () {
    // Manajemen Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Manajemen Kelas & Enrolment
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');

    // Manajemen Materi/Modul Di Dalam Kelas
    Route::get('/courses/{course}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/courses/{course}/modules', [ModuleController::class, 'store'])->name('modules.store');

    Route::post('/courses/{course}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    // Manajemen Tugas & Pengumpulan
    Route::post('/courses/{course}/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'submissions'])->name('assignments.submissions');
    Route::post('/assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::post('/assignments/{assignment}/submit', [SubmissionController::class, 'store'])->name('submissions.store');
});

require __DIR__.'/auth.php';