<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'teacher_id',
    ];

    // Relasi ke Dosen pembuat kelas
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Relasi ke Materi/Modul
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    // Relasi ke Tugas/Assignment (Ini yang menyelesaikan error Anda)
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}