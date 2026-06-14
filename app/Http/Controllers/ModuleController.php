<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    // Menampilkan halaman detail kelas beserta daftar materinya
    public function show(Course $course)
    {
        // Pastikan hanya dosen pemilik yang bisa mengelola materinya
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // Ambil semua modul kelas ini, urutkan dari yang terbaru
        $modules = $course->modules()->latest()->get();
        return view('teacher.show-course', compact('course', 'modules'));
    }

    // Menyimpan file materi baru
    public function store(Request $request, Course $course)
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            // Validasi file: pdf, doc, zip, ppt, dll (Maksimal 10MB)
            'file' => 'nullable|mimes:pdf,doc,docx,ppt,pptx,zip|max:10240', 
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            // Simpan ke folder public/modules
            $filePath = $request->file('file')->store('modules', 'public'); 
        }

        // Buat data di database terkait kelas ini
        $course->modules()->create([
            'title' => $request->title,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Materi pembelajaran berhasil ditambahkan!');
    }
}