<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'teacher_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function edit(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        return view('teacher.edit-course', compact('course'));
    }

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

    public function destroy(Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $course->delete();

        return redirect()->route('dashboard')->with('success', 'Kelas berhasil dihapus!');
    }

    public function enroll(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Akses Ditolak: Hanya mahasiswa yang dapat mendaftar kelas.');
        }

        $user->enrolledCourses()->syncWithoutDetaching($course->id);

        return redirect()->route('dashboard')->with('success', 'Anda berhasil mendaftar ke kelas ' . $course->title . '!');
    }
}