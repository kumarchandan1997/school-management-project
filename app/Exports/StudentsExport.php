<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection ,WithHeadings
{
    protected $students;

    public function __construct($students)
    {
        $this->students = $students;
    }
    
    public function collection()
    {
        return $this->students;
    }

    public function headings(): array
    {
        return [
            'ID', 
            'First Name', 
            'Surname', 
            'Student Number', 
            'Birth Date', 
            'Address', 
            'Parent Phone Number', 
            'Father Name', 
            'Gender', 
            'Classroom ID', 
            'Enrollment Date', 
            'School', 
            'Email',
            'Password',
            'Created At', 
            'Updated At'
        ];
    }
}