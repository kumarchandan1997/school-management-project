<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table='videos';

    public $fillable = [
        'course_title',
        'description',
        'courses_type',
        'games',
        'video',
        'diksh',
        'subject_code',
        'teacher_id',
        'classroom_id',
        'school_id',
        'status',
        'topic_id',
        'subtopic_id',
        'share',
        'app',
        'test',
        'classroom',
    ];

    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'subjects', 'teacher_id', 'classroom_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}