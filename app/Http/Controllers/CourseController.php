<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Method untuk menyimpan data kelas baru
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // 2. Simpan ke database
        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => Auth::id(), // Menggunakan Facade Auth
        ]);

        // 3. Kembalikan ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit
    public function edit(Course $course)
    {
        // Keamanan: Menggunakan Auth::id() agar konsisten dan terbaca IDE
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('teacher.edit-course', compact('course'));
    }

    // Menyimpan perubahan data kelas
    public function update(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil diperbarui!');
    }

    // Menghapus data kelas
    public function destroy(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $course->delete();

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil dihapus!');
    }
    // Method untuk mahasiswa mendaftar ke sebuah kelas
    public function enroll(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Pastikan hanya mahasiswa yang bisa mendaftar
        if ($user->role !== 'student') {
            abort(403, 'Akses Ditolak: Hanya mahasiswa yang dapat mendaftar kelas.');
        }

        // Memasukkan data ke pivot table (syncWithoutDetaching mencegah duplikasi data)
        $user->enrolledCourses()->syncWithoutDetaching($course->id);

        return redirect()->route('dashboard')->with('success', 'Anda berhasil mendaftar ke kelas ' . $course->title . '!');
    }
}