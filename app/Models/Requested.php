<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requested extends Model
{
    use HasFactory;
    protected $table = 'requests';
    public $fillable = [
        'course_title',
        'description',
        'courses_type',
        'url',
        'subject_code',
        'teacher_id',
        'classroom_id',
        'school_id',
        'status',
        'school_id',
        'topic_id',
        'subtopic_id',
    ];
    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'subjects', 'teacher_id', 'classroom_id');
    }
    
}