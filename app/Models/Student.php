<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table='students';

    public $fillable = [
        'first_name',
        'surname',
        'father_name',
        'student_num',
        'birth_date',
        'address',
        'parent_phone_number',
        'gender',
        'classroom_id',
        'enrollment_date',
        'school',
        'email',
        'password',
        'father_name'
    ];

    public function classroom()
    {
        return $this->belongsTo('App\Models\Classroom');
    }

    public function getAuthPassword()
    {
        return $this->password;
    }
}