<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'description', 'deadline', 'file_path'];

    // Memastikan deadline dibaca sebagai format waktu (Carbon) oleh Laravel
    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    // Relasi ke Submission (Jawaban Mahasiswa)
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}