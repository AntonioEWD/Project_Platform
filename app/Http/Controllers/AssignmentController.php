<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    // Menampilkan halaman khusus detail dan pengumpulan tugas untuk mahasiswa
    public function show(Assignment $assignment)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Akses khusus mahasiswa.');
        }

        // Cek apakah mahasiswa ini sudah mengumpulkan tugas terkait
        $mySubmission = Submission::where('assignment_id', $assignment->id)
                                  ->where('student_id', $user->id)
                                  ->first();

        return view('student.show-assignment', compact('assignment', 'mySubmission'));
    }

    // Menyimpan tugas baru dari dosen
    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'nullable|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        $course->assignments()->create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Tugas beserta deadline berhasil dipublikasikan!');
    }
    // Menampilkan daftar mahasiswa yang sudah mengumpulkan tugas (Khusus Dosen)
    public function submissions(Assignment $assignment)
    {
        if ($assignment->course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // Ambil data jawaban beserta data mahasiswanya
        $submissions = $assignment->submissions()->with('student')->latest()->get();

        return view('teacher.submissions', compact('assignment', 'submissions'));
    }
}