<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploadurlshare extends Model
{
    use HasFactory;

    protected $fillable = [
        'students_ids',
        'teacher_id',
        'topic_id',
        'sub_topic_id',
        'classroom_id',
        'subject_id',
        'description',
        'status',
        'course_title',
        'course_link',
        'course_time',
        ];
}