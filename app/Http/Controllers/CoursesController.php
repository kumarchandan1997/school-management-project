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
      // dd($request->all());
      
      $currentTimestamp = now();
      $session_school_id = session('school_id');
    
     $courseData = [
        'course_title' => $request->input('course_title'),
        'classroom_id' => $request->input('classroom_id'),
        'subject_code' => $request->input('subject_name'),
        'courses_type' => $request->input('coursetype'),
        'topic_id' => $request->input('topic_id'),
        'sub_topic_id' => $request->input('subtopic_id'),
        'url' => $request->input('url'),
        'description' => $request->input('description'),
        'school_id' => $session_school_id,
        'created_at' => $currentTimestamp, 
        'updated_at' => $currentTimestamp,
    ];
      DB::table('courses')->insert($courseData);
      return redirect()->back()->with('success', 'Course saved successfully');
    }

    public function updatecourses(Request $request, $id)
    {
        $currentTimestamp = now();
        $session_school_id = session('school_id');

        $courseData = [
            'course_title' => $request->input('course_title'),
            'classroom_id' => $request->input('classroom_id'),
            'subject_code' => $request->input('subject_code'),
            'courses_type' => $request->input('coursetype'),
            'topic_id' => $request->input('topic_id'),
            'sub_topic_id' => $request->input('subtopic_id'),
            'url' => $request->input('url'),
            'description' => $request->input('description'),
            'school_id' => $session_school_id,
            'updated_at' => $currentTimestamp,
        ];

        DB::table('courses')->where('id', $id)->update($courseData);

        return redirect()->back()->with('success', 'Course updated successfully!');
    }

    public function managedata(Request $request)
    {
      //dd($request);
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

        
      return view('courses.coursemanage', [
        'courses_detail' => $courses_detail,
        'classroom_names' => $classroom_names,
        'subject_names' => $subject_names
    ]);
    
    }

    public function getrequestedcourse_courses()
    {
       // dd('heel');
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
      $teacher_details = [];
      $classroom_details = [];
      $subject_details = [];
  
      // Initial query for requests
      $pendingRequests = DB::table('requests')
          ->where('school_id', $school_id)
          ->select(
              'id',
              'url',
              'classroom_id',
              'teacher_id',
              'topic_id',
              'subtopic_id',
              'subject_code',
              'status',
              DB::raw('NULL as created_at'),
              DB::raw("'requests' as table_name")
          );
  
      // Initial query for videos
      $pendingVideos = DB::table('videos')
          ->where('school_id', $school_id)
          ->select(
              'id',
              'video as url',
              'classroom_id',
              'teacher_id',
              'topic_id',
              'subtopic_id',
              'subject_code',
              'status',
              'created_at',
              DB::raw("'videos' as table_name")
          )
          ->union($pendingRequests);
  
      // Combined query for games
      $pendingItems = DB::table('games')
          ->where('school_id', $school_id)
          ->select(
              'id',
              'url',
              'classroom_id',
              'teacher_id',
              'topic_id',
              'subtopic_id',
              DB::raw('NULL as subject_code'),
              'status',
              'created_at',
              DB::raw("'games' as table_name")
          )
          ->union($pendingVideos);
  
      // Search functionality
      if ($request->has('search')) {
          $search = $request->input('search');
          $pendingItems = DB::table(DB::raw("({$pendingItems->toSql()}) as sub"))
              ->mergeBindings($pendingItems)
              ->leftJoin('classrooms', 'sub.classroom_id', '=', 'classrooms.id')
              ->leftJoin('subjects', 'sub.subject_code', '=', 'subjects.subject_code')
              ->where(function($query) use ($search) {
                  $query->where('subjects.name', 'like', "%$search%")
                      ->orWhere('classrooms.name', 'like', "%$search%");
              })
              ->select('sub.*')
              ->orderBy('sub.created_at', 'desc');
      } else {
          $pendingItems = $pendingItems->orderBy('created_at', 'desc');
      }
  
      // Paginate the results
      $requested_data = $pendingItems->paginate(10);
  
      // Populate teacher_details, classroom_details, and subject_details arrays
      foreach ($requested_data as $request) {
          $teacher_id = $request->teacher_id;
          $classroom_id = $request->classroom_id;
          $subject_code = $request->subject_code;
  
          // Fetch teacher details
          $teacher = Teacher::find($teacher_id);
          if ($teacher) {
              $teacher_details[$teacher_id] = [
                  'name' => $teacher->first_name . ' ' . $teacher->surname,
              ];
          }
  
          // Fetch classroom details
          $classroom = Classroom::find($classroom_id);
          if ($classroom) {
              $classroom_details[$classroom_id] = [
                  'id' => $classroom->id,
                  'name' => $classroom->name,
              ];
          }
  
          // Fetch subject details
          $subject = Subject::where('subject_code', $subject_code)->first();
          if ($subject) {
              $subject_details[$subject_code] = [
                  'id' => $subject->id,
                  'name' => $subject->name,
              ];
          }
      }
  
      // Pass data to the view
      return view('courses.videomanage', [
          'requested_data' => $requested_data,
          'teacher_details' => $teacher_details,
          'classroom_details' => $classroom_details,
          'subject_details' => $subject_details,
      ]);
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
        // $classrooms =Classroom::where('school_id','=',$school_id)->get();
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.school_id', '=', $school_id)
        ->where('classrooms.school_id', '=', $school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        // $teachers=Teacher::where('school_id','=',$school_id)->get();
        $courses= Course::findOrFail($id);
        // $subject = Subject::where('classroom_id', '=', $course->classroom_id)->where('school_id','=',$school_id)->get();
       
       return view ('courses.editcourse',['classrooms'=>$classrooms,'courses'=>$courses]);
   }



   public function update(Request  $request,int $id)
   {  
      $course=Course::findOrFail($id);
     // dd($course);
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
        $table = $request->input('table_name');

        // Assuming you want to toggle the status between 'Pending' and 'Approve'
        $status = DB::table($table)->where('id', $id)->value('status');
        $newStatus = ($status == 'Pending') ? 'Approve' : 'Pending';

        DB::table($table)->where('id', $id)->update(['status' => $newStatus]);

        return redirect()->back()->with('status', 'Status updated successfully');
    }


}