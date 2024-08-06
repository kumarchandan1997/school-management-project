<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportlog extends Model
{
    use HasFactory;

    protected $fillable = ['content_name','teacher_id','classroom_id','subject_code','content','content_type','content_table_name','video_id', 'open_time', 'close_time', 'interval','description'];

}