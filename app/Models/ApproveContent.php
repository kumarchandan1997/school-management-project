<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproveContent extends Model
{
    use HasFactory;

    protected $fillable = ['classroom_id','subject_code','teacher_id','content','status','schoole_id','description'];
}