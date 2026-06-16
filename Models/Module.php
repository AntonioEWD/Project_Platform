<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'file_path',
    ];

    // Relasi: Modul ini milik sebuah kelas
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}

