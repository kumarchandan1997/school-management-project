<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class class_link extends Model
{
    use HasFactory;
    protected $table='meeting_link';

    protected $primaryKey='id';
    public $fillable = [
        'teacher_id',
        'school_id',
        'class',
        'class_time',
        'topic_id',
        'subtopic_id',
        'class_room',
        'subject_code',
        'note',
        'to_meeting_time',
        
    ];


    public function subjects()
    {
        return $this->hasMany('App\Models\Subject');
    }
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'subjects', 'teacher_id', 'classroom_id');
    }
//     public function user()
//    {
//     return $this->belongsTo(User::class, 'school_id');
//    }

 public function user()
    {
        return $this->belongsTo(User::class);
    }


}