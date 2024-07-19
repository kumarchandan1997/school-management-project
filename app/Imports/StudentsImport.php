<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;
use Exception;

class StudentsImport implements ToModel ,WithHeadingRow
{
    protected $classroomId;
    protected $schoolId;
    
    public function __construct($classroomId, $schoolId)
    {
        $this->classroomId = $classroomId;
        $this->schoolId = $schoolId;
    }
    
    public function model(array $row)
    {   
        try {

            $user_id = $row['first_name'].'_'.$row['first_name'].'_'.$this->transformNumber($row['parent_phone_number']);
            $randomPassword = Str::random(10);
            
            return new Student([
                'student_num' => $this->generateStudentNumber(),
                'first_name' => $row['first_name'],
                'surname' => $row['surname'],
                'birth_date' => $this->transformDate($row['birth_date']),
                'classroom_id' => $this->classroomId,
                'school' => $this->schoolId,
                'parent_phone_number' => $this->transformNumber($row['parent_phone_number']),
                'father_name' => $row['father_name'],
                'enrollment_date' => $this->transformDate($row['enrollment_date']),
                'address' => $row['address'],
                'gender' => $this->transformNumber($row['gender']),
                'email' => $user_id,
                'password' => $randomPassword,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (Exception $e) {
            \Log::error('Error importing student: ' . $e->getMessage());
            return null;
        }
    }

    private function transformDate($value)
    {
        try {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        } catch (Exception $e) {
            return null;
        }
    }

    private function transformNumber($value)
    {
        if (is_numeric($value)) {
            return (int) $value;
        }
        return $value;
    }

    public function generateStudentNumber(): string
    {
        return (string)str('STDN-')->append($this->getLastTCID());
    }
    function getLastTCID()
    {
        $last = Student::query()->orderByDesc('student_num')->first('student_num');
        if($last != null){
            $lastNum = (string)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum +1);
        } else
            return sprintf("%06d", 1);
    }
}