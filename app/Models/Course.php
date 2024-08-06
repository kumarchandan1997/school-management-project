<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
           use HasFactory;

            protected $fillable = [
            'course_title',
            'description',
            'courses_type',
            'url',
            'subject_code',
            'teacher_id',
            'classroom_id',
            'school_id',
            'pdf_video',
            ];
}