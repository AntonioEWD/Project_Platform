<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function show(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $isTeacher = $course->teacher_id === $user->id;
        $isEnrolledStudent = $user->enrolledCourses()->where('courses.id', $course->id)->exists();

        if (!$isTeacher && !$isEnrolledStudent) {
            abort(403, 'Akses Ditolak. Anda belum terdaftar di kelas ini.');
        }

        $modules = $course->modules()->latest()->get();
        // INI YANG KURANG: Memanggil data tugas dari database
        $assignments = $course->assignments()->latest()->get(); 
        
        // Mengirimkan data modules DAN assignments ke view
        if ($user->role === 'student') {
            return view('student.show-course', compact('course', 'modules', 'assignments'));
        }

        return view('teacher.show-course', compact('course', 'modules', 'assignments'));
    }

    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240', 
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('modules', 'public'); 
        }

        $course->modules()->create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Materi pembelajaran berhasil ditambahkan!');
    }
}