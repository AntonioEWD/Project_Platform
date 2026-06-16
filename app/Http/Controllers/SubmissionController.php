<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function store(Request $request, Assignment $assignment)
    {
        // Cek apakah mahasiswa ini sudah mengumpulkan sebelumnya
        $alreadySubmitted = Submission::where('assignment_id', $assignment->id)
                                      ->where('student_id', Auth::id())
                                      ->exists();

        if ($alreadySubmitted) {
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini.');
        }

        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg|max:10240',
            'notes' => 'nullable|string',
        ]);

        $filePath = $request->file('file')->store('submissions', 'public');

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => Auth::id(),
            'file_path' => $filePath,
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Jawaban tugas berhasil dikumpulkan!');
    }
}