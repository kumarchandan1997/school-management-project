<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
      public $fillable = [
        'course_title',
        'description',
        'courses_type',
        'url',
        'subject_code',
        'teacher_id',
        'classroom_id',
        'school_id',
    ];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
//       public function user()
// {
//     return $this->belongsTo(User::class, 'school_id', 'id');
// }
}
