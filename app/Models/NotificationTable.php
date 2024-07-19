<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTable extends Model
{
    use HasFactory;

    protected $table = 'notification_tables';

    protected $fillable = [
        'school_id',
        'student_id',
        'teacher_id',
        'notification_type',
        'description',
        'notification_url',
        'seen_at',
    ];
}