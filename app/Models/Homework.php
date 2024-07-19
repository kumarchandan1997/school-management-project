<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_title',
        'classroom_id',
        'subject_code',
        'content_id',
        'description',
        'topic_id',
        'subtopic_id',
        'homework_file',
    ];
}