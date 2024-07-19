<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;

class DashboardController extends Controller
{
    
    public function getdashboardclass(Request $request)
    {
      $session_role_id=session('role_id');
      $school_id=session('school_id');
      $classrooms = Classroom::where('school_id','=',$school_id)->get();
      $subjectCounts = [];
      foreach ($classrooms as $classroom) {
      $subject_detail = Subject::where('classroom_id', $classroom->id)
      ->where('school_id',$school_id)
      ->get();
      $subjectCounts[$classroom->id] = $subject_detail->count();
     }
     return view('dashboard', ['classrooms' => $classrooms, 'subjectCounts' => $subjectCounts]);
    }

   // function subject details
    public function getsubject(Request $request)
    {
        $school_id=session('school_id');
        $course_details=[];
        $class_id=$request->class;
        $subject_detail=Subject::where('classroom_id','=',$class_id)
        ->where('school_id','=',$school_id)
        ->get();
        $classroom_name=Classroom::where('id','=',$class_id)
        ->where('school_id','=',$school_id)
        ->get();
       
       foreach ($subject_detail as $subject) {
           $courses = Course::where('subject_code', $subject->subject_code)
             ->where('school_id','=',$school_id)
           ->get();
         
           $course_details[$subject->subject_code] = $courses->count();
            
        }
        return view('dashboard.classsubject',['subject_detail'=>$subject_detail, 'classroom_name'=>$classroom_name, 'course_details'=>$course_details]);
    }
    //function for courses 
       public function getcourse(Request $request)
       {
        $school_id=session('school_id');
        $className="";
        $subjectName="";
        $classroomId="";
        $subject_code_data=$request->subject_code;
        $courses_data = Course::where('subject_code', $subject_code_data)
        ->where('school_id', $school_id) 
        ->get();
    
       foreach ($courses_data as $data) {
       $classroomId = $data->classroom_id;
       $class_info = Classroom::where('id', '=', $classroomId)
       ->where('school_id', $school_id)
       ->first();
      
       $subject_info=Subject::where('subject_code','=',$subject_code_data)
       ->where('school_id', $school_id)
       ->first();
     
       if ($class_info) {
        $className = $class_info->name;
      }
      if($subject_info)
      {
        $subjectName=$subject_info->name;
      }

      }
        $pageMenu = [
            "className" => $className,
            "classroom_id" => $classroomId,
            "subjectName" => $subjectName,
            "subject_code" => $subject_code_data,
        ];
        return view('dashboard.subjectdetail',['courses_data'=>$courses_data, 'pageMenu'=> $pageMenu]);
      }

// function for  frame
      public function getFrame(Request $request)
      {
        $school_id=session('school_id');
        $code="";
        $classroomID="";
        $className="";
        $subjectName="";
        $classroomId="";
        $course_id=$request->id;
        $course_details=Course::where('id','=',$course_id)
        ->where('school_id','=',$school_id)
        ->get();
       
        foreach($course_details as $courses)
        {
          $code=$courses->subject_code;
          $classroomID=$courses->classroom_id;
          $class_info = Classroom::where('id', '=', $classroomID)
          ->where('school_id','=',$school_id)
          ->first();
          $subject_info=Subject::where('subject_code','=',$code)
           ->where('school_id','=',$school_id)
          ->first();
         
          if($subject_info)
          {
          $subjectName=$subject_info->name;
        
         }
         if ($class_info) {
        $className = $class_info->name;
       
       }

        }
         $page_data = [
            "className" => $className,
            "classroom_id" => $classroomID,
            "subjectName" => $subjectName,
            "subject_code" => $code,
        ];
        return view('dashboard.frame',['course_details'=>$course_details ,'page_data'=>$page_data]);
      }
}
