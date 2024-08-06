<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class game extends Model
{
    use HasFactory;

    protected $table='games';

    public $fillable = [
        'name',
        'teacher_id',
        'school_id',
        'classroom_id',
        'topic_id',
        'subtopic_id',
        'status',
        'url',
        'subject_code',
        'description',
    ];
}