<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liveclassshare extends Model
{
    use HasFactory;

    protected $fillable = [
        'students_ids',
        'teacher_id',
        'topic',
        'sub_topic',
        'description',
        'status',
        'meeting_link',
        'meeting_time',
    ];
}