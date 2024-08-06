<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Requested;
use App\Models\Video;
use Illuminate\Support\Facades\DB;




use Illuminate\Http\Request;

class CoursesController extends Controller
{
  
  
    public function create(Request $request)
    {
        $school_id=session('school_id');
        $teachers=Teacher::where('school_id','=',$school_id)->get();
   
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.school_id', '=', $school_id)
        ->where('classrooms.school_id', '=', $school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');

        return view('courses/addcourse', compact('classrooms','teachers'));
    }



    public function store(Request $request)
    {
    $rules = [
        'course_title' => 'required|string|max:255',
        'classroom_id' => 'required|exists:classrooms,id',
        'subject_name' => 'required|string|max:255',
        'coursetype' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    // Additional rules based on coursetype
    if ($request->coursetype == 'PDF' || $request->coursetype == 'Video') {
        $rules['pdf_video'] = 'required|file|mimes:pdf,mp4';
    } elseif ($request->coursetype == 'Url') {
        $rules['url'] = 'required|url';
    }

    $messages = [
        'classroom_id.exists' => 'The selected classroom does not exist.',
        'pdf_video.required' => 'A file is required for PDF/Video content.',
        'url.required' => 'A URL is required for URL content.',
    ];

    $validatedData = $request->validate($rules, $messages);
    
    try {
        $currentTimestamp = now();
        $session_school_id = session('school_id');

        // Initialize courseData array
        $courseData = [
            'course_title' => $validatedData['course_title'],
            'classroom_id' => $validatedData['classroom_id'],
            'subject_code' => $validatedData['subject_name'],
            'courses_type' => $validatedData['coursetype'],
            'description' => $validatedData['description'] ?? null,
            'school_id' => $session_school_id,
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
        ];

        if ($request->hasFile('pdf_video') && ($validatedData['coursetype'] == 'PDF' || $validatedData['coursetype'] == 'Video')) {
            $file = $request->file('pdf_video');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');
            $courseData['pdf_video'] = '/storage/' . $path;
        }

        // Handle URL for URL content type
        if ($validatedData['coursetype'] == 'Url') {
            $courseData['url'] = $validatedData['url'];
        }

        DB::table('courses')->insert($courseData);

        return redirect()->back()->with('success', 'Course saved successfully');
    } catch (\Exception $exception) {
        // dd($exception->getMessage());
        return redirect()->back()->withErrors($exception->getMessage());
    }
}


    public function updatecourses(Request $request, $id)
    {
        $rules = [
            'course_title' => 'required|string|max:255',
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_code' => 'required|string|max:255',
            'coursetype' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|string|url',
        ];

        $messages = [
            'classroom_id.exists' => 'The selected classroom does not exist.',
        ];

        $validatedData = $request->validate($rules, $messages);

        try {
            $currentTimestamp = now();
            $session_school_id = session('school_id');

            $courseData = [
                'course_title' => $validatedData['course_title'],
                'classroom_id' => $validatedData['classroom_id'],
                'subject_code' => $validatedData['subject_code'],
                'courses_type' => $validatedData['coursetype'],
                'description' => $validatedData['description'],
                'school_id' => $session_school_id,
                'updated_at' => $currentTimestamp,
            ];

            if ($request->hasFile('pdf_video') && ($validatedData['coursetype'] == 'PDF' || $validatedData['coursetype'] == 'Video')) {
                $file = $request->file('pdf_video');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
                $courseData['pdf_video'] = '/storage/' . $path;
            }
            
            if ($validatedData['coursetype'] == 'Url') {
                $courseData['url'] = $validatedData['url'];
            }

            DB::table('courses')->where('id', $id)->update($courseData);

            return redirect()->back()->with('success', 'Course updated successfully!');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }



    public function managedata(Request $request)
    {
      $school_id=session('school_id');
      $query = Course::where('school_id', '=', $school_id);
      
        if ($request->has('search')) {
          $searchTerm = $request->input('search');

          // Get subjects and classrooms to filter by name
          $subjectIds = Subject::where('name', 'like', '%' . $searchTerm . '%')->pluck('subject_code');
          $classroomIds = Classroom::where('name', 'like', '%' . $searchTerm . '%')->pluck('id');

          // Filter courses based on search criteria
          $query->where(function ($q) use ($searchTerm, $subjectIds, $classroomIds) {
              $q->where('course_title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('subject_code', 'like', '%' . $searchTerm . '%')
                  ->orWhereIn('subject_code', $subjectIds)
                  ->orWhereIn('classroom_id', $classroomIds);
          });
      }

      $courses_detail = $query->orderBy('created_at', 'desc')->paginate(10);
      
      $classroom_names = [];
      $subject_names = [];
      
      foreach ($courses_detail as $course) {
          $name = Classroom::find($course->classroom_id)->name;
          $classroom_names[] = $name;

          $subject = Subject::where('subject_code', '=', $course->subject_code)->first();
          $sub_name = $subject ? $subject->name : '';
          $subject_names[] = $sub_name;
      }

      $classrooms = DB::table('classrooms')->where('school_id',$school_id)->get();

        
      return view('courses.coursemanage', [
        'courses_detail' => $courses_detail,
        'classroom_names' => $classroom_names,
        'subject_names' => $subject_names,
        'classrooms' => $classrooms
    ]);
    
    }


  // In StudentController.php
    public function getStudentsByClassroomAndQuery(Request $request)
    {
        $classroomId = $request->query('classroom_id');
        $query = $request->query('query');

        $students = DB::table('students')
            ->select('id', DB::raw("CONCAT(first_name, ' ', surname) AS name"))
            ->where('classroom_id', $classroomId)
            ->where('school', session('school_id'))
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%$query%")
                ->orWhere('surname', 'like', "%$query%");
            })
            ->get();

        return response()->json(['students' => $students]);
    }

    public function shareAdminContent(Request $request, $course_id)
    {
        $validated = $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'student_ids' => 'array',
            'student_ids.*' => 'exists:students,id',
            'description' => 'nullable|string',
        ]);

        $classroomId = $validated['classroom_id'];
        $studentIds = $validated['student_ids'] ?? [];
        $description = $validated['description'] ?? '';

        $contentDeatils = DB::table('courses')->where('id',$course_id)->first();

        $studentIdsString = implode(',', $studentIds);
        // dd($contentDeatils);

            DB::table('mycontentshares')->insert([
                'students_ids' => $studentIdsString,
                'teacher_id' => $contentDeatils->teacher_id ?? '0',
                // 'topic' => 0,
                'classroom_id' => $contentDeatils->classroom_id ?? '0',
                'subject_id' => $contentDeatils->subject_code ?? '-',
                'content_title' => $contentDeatils->course_title ?? '',
                'course_type' => $contentDeatils->courses_type ?? '',
                'status' => 'admin',
                'content_link' => $contentDeatils->pdf_video ?? '0',
                // 'meeting_time' => '-',
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }




    public function getrequestedcourse_courses()
    {
      $school_id=session('school_id');
      $teacher_details = [];
      $classroom_details=[];
      $subject_details=[];
      $requested_data = Requested::where('school_id','=',$school_id)->orderBy('created_at', 'desc')->Paginate(10);
     
     
      foreach ($requested_data as $request) {
          $teacher_id = $request->teacher_id;
        
          $classroom_id = $request->classroom_id;
          $subject_code = $request->subject_code;
          $teacher = Teacher::find($teacher_id);
         

           if ($teacher) {
            $teacher_details[$teacher_id] = [
                'name' => $teacher->first_name . ' ' . $teacher->surname,
            ];
          }
            $classroom=Classroom::find($classroom_id);
            if($classroom)
            {
              $classroom_details[$classroom_id]=
              [
                'id'=>$classroom->id,
                'name'=>$classroom->name,
              ];
            }

        $subject = Subject::where('subject_code', $subject_code)->first();

          if ($subject) {
            $subject_details[$subject_code] = [
                'id' => $subject->id,
                'name' => $subject->name,
            ];
          }
    }
   
     return view('courses.requestedcourse', [
        'requested_data' => $requested_data,
        'teacher_details' => $teacher_details,
        'classroom_details' => $classroom_details,
        'subject_details' => $subject_details,
    ]);
    }



    public function videomanager(Request $request) {
        $school_id = session('school_id');
        $search = $request->input('search');
    
        $query = DB::table('approve_contents')
            ->leftJoin('classrooms', 'approve_contents.classroom_id', '=', 'classrooms.id')
            ->leftJoin('subjects', 'approve_contents.subject_code', '=', 'subjects.subject_code')
            ->leftJoin('teachers', 'approve_contents.teacher_id', '=', 'teachers.id')
            ->select(
                'approve_contents.*', 
                'classrooms.name as classroom_name', 
                'subjects.name as subject_name', 
                DB::raw("CONCAT(teachers.first_name, ' ', teachers.surname) as teacher_name")
            )
            ->where('approve_contents.schoole_id', $school_id);
    
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('subjects.name', 'LIKE', "%{$search}%")
                        ->orWhere('classrooms.name', 'LIKE', "%{$search}%")
                        ->orWhere(DB::raw("CONCAT(teachers.first_name, ' ', teachers.surname)"), 'LIKE', "%{$search}%");
                });
            }
    
            $approvedContentRequest = $query->paginate(10);

        return view('courses.videomanage',compact('approvedContentRequest'));
    }
    
    
  


    public function getframe(Request $request)
    {
      $school_id=session('school_id');
      $course_id=$request->course_id;
       $teacher_details = [];
       $subject_details=[];

      $requested_data = Requested::where('id','=',$course_id)
      ->where('school_id','=',$school_id)
      ->get();

     // dd($requested_data);
      foreach($requested_data as $data)
      {
         $teacher_id = $data->teacher_id;
         $subject_code=$data->subject_code;
      }
      $teachers=Teacher::where('id','=', $teacher_id)
      ->where('school_id','=',$school_id)
      ->get();
      foreach ($teachers as $teacher) {
       $teacher_details[$teacher->id] = [
        'name' => $teacher->first_name . ' ' . $teacher->surname,
      ];
      }
      
       $subject=Subject::where('subject_code','=',$subject_code)
       ->where('school_id','=',$school_id)
       ->first();
       if ($subject) {
            $subject_details[$subject_code] = [
                'id' => $subject->id,
                'name' => $subject->name,
            ];
          }

      return view('courses.courseframe',['requested_data' => $requested_data, 'subject_details'=>$subject_details ,'teacher_details'=>$teacher_details]);
    }


    public function getframe_test(Request $request)
    {
      $school_id=session('school_id');
      $course_id=$request->course_id;
       $teacher_details = [];
       $subject_details=[];

      $requested_data = Video::where('id','=',$course_id)
      ->where('school_id','=',$school_id)
      ->get();

     // dd($requested_data);
      foreach($requested_data as $data)
      {
         $teacher_id = $data->teacher_id;
         $subject_code=$data->subject_code;
      }
      $teachers=Teacher::where('id','=', $teacher_id)
      ->where('school_id','=',$school_id)
      ->get();
      foreach ($teachers as $teacher) {
       $teacher_details[$teacher->id] = [
        'name' => $teacher->first_name . ' ' . $teacher->surname,
      ];
      }
      
       $subject=Subject::where('subject_code','=',$subject_code)
       ->where('school_id','=',$school_id)
       ->first();
       if ($subject) {
            $subject_details[$subject_code] = [
                'id' => $subject->id,
                'name' => $subject->name,
            ];
          }

      return view('courses.courseframe',['requested_data' => $requested_data, 'subject_details'=>$subject_details ,'teacher_details'=>$teacher_details]);
    }
// this for stauts update api code 


public function add_video_update(Request $request ,$id){
  if($request->isMethod('post')){
      $data=video($request);
      $teacher_id=session('teacher_id');
      $school_id=session('school_id');
      $Add_Requested_courses=Video::where('id',$id)->update([
      'teacher_id' => $teacher_id,
      'course_title'=>$request->input('course_title'),
      'classroom_id'=>$request->input('classroom'),
      'subject_code'=>$request->input('subject'),
      'courses_type'=>$request->input('coursetype'),
      'video'=>$data,
      'games'=>$request->game,
      'diksh'=>$request->diksha,
      'description'=>$request->input('description'),
      'school_id'=>$school_id,
       ]);
     return redirect()->back()->with('success', 'A Teacher Updated Successfully.');
    
  }else{
  $teacher_id=session('teacher_id');
  $school_id=session('school_id');
  $classrooms=Classroom::where('school_id','=',$school_id)->get();
  $data=Video::where('teacher_id',$teacher_id)->where('id',$id)->first();
  return view('teacher.updata_video',['classrooms'=>$classrooms],compact('data'));
  }
}



public function video_delete($id){
  $Add_Requested_courses=Video::where('id',$id)->delete();
return  redirect()->back()->with('error', 'This Video is Deleted Successfully.');  
}



    public function updatestatus(Request $request)
    {
         $courseId = $request->input('id');
         $newStatus = $request->input('status');
         $course = Requested::find($courseId);
          if (!$course) {
              return response()->json(['message' => 'Course not found'], 404);
          }
          $course->status = $newStatus;
          $course->save();
          return response()->json(['message' => 'Status updated successfully']);
    }
 // this code for csv file

  // public function addcsvview(){
  //     return view('courses.addbulkdata');
  //   }

  //   public function addCSVData(Request $request){
  //     // Validate the uploaded file

  //     $school_id=session('school_id');
  //     $request->validate([
  //         'csvFile' => 'required|file',
  //     ]);
  
  //     $file = $request->file('csvFile');
  //     $allowedExtensions = ['csv', 'xlsx', 'xls'];
  //     $extension = strtolower($file->getClientOriginalExtension());
  
  //     if (!in_array($extension, $allowedExtensions)) {
  //         return redirect()->back()->withErrors(['csvFile' => 'Invalid file format. Please upload a CSV, XLSX, or XLS file.']);
  //     }

  //     // Get the uploaded CSV file
  //     $uploadedFile = $request->file('csvFile');

  //     // Process the CSV data and insert into the database
  //     if (($handle = fopen($uploadedFile->path(), 'r')) !== false) {
  //       $firstRow = true;
  //       $datarow = 1;
  //       while (($data = fgetcsv($handle)) !== false) {
  //           // Create a new instance of your model and fill it with CSV data
  //           if ($firstRow){
  //             // skip the first row containing heading 
  //             $firstRow = false;
  //             continue;
  //           }
  //           // Skip lines starting with //
  //           if (strpos($data[0], '//') === 0) {
  //             continue;
  //           }
  //           $data = array_map(function ($item) {
  //             return trim($item, '"');
  //           }, $data);

  //           // if any row data is empty then redirect back
  //           if ($data[0] == '' || $data[1] == '' || $data[2] == '' || $data[3] == '' || $data [4] == ''){
  //             return redirect()->back()->with('error',"Error in row $datarow : Some fields are empty");
  //           }
  //           $csvData = new Course();  
  //           $csvData->course_title = $data[0];
  //           $csvData->subject_code = $data[1]; 
  //           $csvData->description = $data[2];
  //           // get the details of classroom id from subject table 
  //           $get_classroom_id = Subject::where("subject_code",$data[1])->first();
  //           // if subject not found
  //           if ($get_classroom_id == null){
  //             return redirect()->back()->with('error',"Error in row $datarow: Subject code not found. All data above is Added.");
  //           }
            
  //           $csvData->classroom_id = $get_classroom_id->classroom_id;
  //           $csvData->url = $data[3];
  //           if (strtolower($data[4]) == "video" || strtolower($data[4]) == "pdf"){
  //             ($data[4] == "pdf") ? ($data[4] = "PDF") : ($data[4] = "Video");
  //             $csvData->courses_type = $data[4]; 
  //           }
  //           else{
  //             return redirect()->back()->with('error',"Error in row $datarow: Course type should be either video or pdf. All data above is added.");
  //           }
  //           // this is add by amrita singh
  //             $csvData->school_id = $school_id;
  //           // Save the data to the database
  //           $csvData->save();
  //           $datarow++;
  //       }
  //       fclose($handle);
  //     }

  //     return redirect()->back()->with('success', 'CSV data imported successfully.');
  // }

  public function manageLiveclass(Request $request)
    {

        $search = $request->input('search');
        $school_id=session('school_id');

        $query = DB::table('meeting_link')
            ->leftJoin('topics', 'meeting_link.topic_id', '=', 'topics.id')
            ->leftJoin('subtopics', 'meeting_link.subtopic_id', '=', 'subtopics.id')
            ->leftJoin('classrooms', 'meeting_link.class_room', '=', 'classrooms.id')
            ->leftJoin('subjects', 'meeting_link.subject_code', '=', 'subjects.subject_code')
            ->select(
                'meeting_link.*', 
                'topics.course_title as topic_name', 
                'subtopics.sub_topic_name as subtopic_name', 
                'classrooms.name as classroom_name',
                'subjects.name as subject_name'
            )->where('meeting_link.school_id','=',$school_id);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('topics.course_title', 'LIKE', "%{$search}%")
                    ->orWhere('classrooms.name', 'LIKE', "%{$search}%")
                    ->orWhere('subtopics.sub_topic_name', 'LIKE', "%{$search}%");
            });
        }

        $meetingLinks = $query->paginate(10);

        return view('courses.manageliveclass',compact('meetingLinks'));
    }






  public function edit(int $id)
   {
       $school_id=session('school_id');
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.school_id', '=', $school_id)
        ->where('classrooms.school_id', '=', $school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        $courses= Course::findOrFail($id);
       
       return view ('courses.editcourse',['classrooms'=>$classrooms,'courses'=>$courses]);
   }



   public function update(Request  $request,int $id)
   {  
      $course=Course::findOrFail($id);
     dd($course);
      $course->course_title =$request->course_title;
      $course->subject_code= $request->subject;
      $course->description=$request->description;
      $course->url=$request->url;
      $course->classroom_id=$request->classroom;
      $course->courses_type=$request->coursetype;
      $course->save();
    //  return view('courses.addcourse');
     return redirect('/courses/manage')->with('success', 'A Subject Updated Successfully.');
   }
   

   public function destroy( int $id)
   {
   //dd($request);
    try {
            Course::destroy($id);
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
      return redirect('/courses/manage');
   }


  

 

    public function status($id){
      if(DB::table('vieos')->where('id',$id)->where('status','Pending')->first()){
        DB::table('vieos')->where('id',$id)->where('status','Pending')->update([
          'status'=>'Approve'
      ]);
      return redirect()->back();
      }elseif(DB::table('vieos')->where('id',$id)->where('status','Approve')->first()){
        DB::table('vieos')->where('id',$id)->where('status','Approve')->update([
          'status'=>'Pending'
      ]);
      return redirect()->back();
      }
    }

    public function updateStatusContent(Request $request)
    {
        $id = $request->input('id');
        $tableAndId = $request->input('table_and_id');
        $parts = explode(' , ',$tableAndId);
       
        $table = $parts[0];
        $real_table_id = $parts[1];

        $status = DB::table($table)->where('id', $real_table_id)->value('status');
        $newStatus = ($status == 'Pending') ? 'Approve' : 'Pending';

        DB::table($table)->where('id', $real_table_id)->update(['status' => $newStatus]);


        $approve_contents_status = DB::table('approve_contents')->where('id', $id)->value('status');
        $newStatus = ($status == 'Pending') ? 'Approve' : 'Pending';

        DB::table('approve_contents')->where('id', $id)->update(['status' => $newStatus]);

        return redirect()->back()->with('status', 'Status updated successfully');
    }


}