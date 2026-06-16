<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Logika untuk Mahasiswa
        if ($user->role === 'student') {
            $myCourses = $user->enrolledCourses;
            $availableCourses = Course::whereNotIn('id', $myCourses->pluck('id'))->with('teacher')->get();

            // Perbaikan: Memanggil folder student
            return view('student.dashboard', compact('myCourses', 'availableCourses'));
        }

        // Logika untuk Dosen
        if ($user->role === 'teacher') {
            $myTeachingCourses = Course::where('teacher_id', $user->id)->get();

            // Memanggil folder teacher
            return view('teacher.dashboard', compact('myTeachingCourses'));
        }

        abort(403, 'Peran pengguna tidak valid.');
    }
}