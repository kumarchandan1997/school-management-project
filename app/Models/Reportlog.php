<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportlog extends Model
{
    use HasFactory;

    protected $fillable = ['video_id', 'open_time', 'close_time', 'interval','description'];

}