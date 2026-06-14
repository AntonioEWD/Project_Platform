<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // Mengizinkan kolom ini diisi data
    protected $fillable = ['title', 'description', 'teacher_id'];

    // Relasi: Setiap kelas (Course) dimiliki oleh satu pengajar (User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    // Relasi Many-to-Many: Mahasiswa yang terdaftar di kelas ini
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }
    // Relasi One-to-Many: Kelas ini memiliki banyak modul
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}