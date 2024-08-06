<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Exception;

class StudentsImport implements ToModel ,WithHeadingRow,WithValidation,WithBatchInserts
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
        $user_id = $row['first_name'].'_'.$row['surname'].'_'.$this->transformNumber($row['parent_phone_number']);
        $randomPassword = \Illuminate\Support\Str::random(10);
        
        $gender = strtolower($row['gender']) == 'male' ? 0 : (strtolower($row['gender']) == 'female' ? 1 : null);

        $studentData = [
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
            'gender' => $gender,
            'email' => $user_id,
            'password' => $randomPassword,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        \Log::info('Student data to insert: ' . json_encode($studentData));

        return new Student($studentData);

  }

    public function rules(): array
    {
        return [
            '*.first_name' => 'required|string',
            '*.surname' => 'required|string',
            '*.birth_date' => 'required',
            '*.parent_phone_number' => 'required|numeric|digits_between:10,15',
            '*.father_name' => 'required|string',
            '*.enrollment_date' => 'required',
            '*.address' => 'required|string',
            '*.gender' => ['required', Rule::in(['male', 'female'])],
            '*.unique_combination' => 'unique_combination'
        ];
    }

        public function customValidationMessages()
        {
            return [
                '*.first_name.required' => 'The first name field is required.',
                '*.surname.required' => 'The surname field is required.',
                '*.birth_date.required' => 'The birth date field is required.',
                '*.parent_phone_number.required' => 'The parent phone number field is required.',
                '*.parent_phone_number.numeric' => 'The parent phone number must be a number.',
                '*.parent_phone_number.digits_between' => 'The parent phone number must be between 10 and 15 digits.',
                '*.father_name.required' => 'The father name field is required.',
                '*.enrollment_date.required' => 'The enrollment date field is required.',
                '*.address.required' => 'The address field is required.',
                '*.gender.required' => 'The gender field is required.',
                '*.gender.in' => 'The gender must be either male or female.',
                '*.unique_combination.unique_combination' => 'The combination of first name, surname, birth date, parent phone number, and father name must be unique across all rows.'
            ];
        }

        public function withValidator($validator)
        {
            $validator->after(function ($validator) {
                $rows = $validator->getData();
                $seenRows = [];
    
                foreach ($rows as $key => $row) {
                    $uniqueKey = $row['first_name'].'-'.$row['surname'].'-'.$row['birth_date'].'-'.$row['parent_phone_number'].'-'.$row['father_name'];
    
                    // Check for duplicates within the uploaded file
                    if (in_array($uniqueKey, $seenRows)) {
                        $validator->errors()->add($key, 'The combination of first name, surname, birth date, parent phone number, and father name must be unique across all rows.');
                    } else {
                        $seenRows[] = $uniqueKey;
                    }
    
                    // Check for duplicates in the database
                    $existingStudent = Student::where('first_name', $row['first_name'])
                        ->where('surname', $row['surname'])
                        ->where('birth_date', $this->transformDate($row['birth_date']))
                        ->where('parent_phone_number', $this->transformNumber($row['parent_phone_number']))
                        ->where('father_name', $row['father_name'])
                        ->where('classroom_id', $this->classroomId)
                        ->exists();
    
                    if ($existingStudent) {
                        $validator->errors()->add($key, 'The student with the same details already exists in the specified class.');
                    }
                }
            });
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

    public function batchSize(): int
    {
        return 1000;
    }
}