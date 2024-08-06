<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherAddUpdateRequest;
use App\Models\class_link;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Course;
use App\Models\Requested;
use App\Models\Video;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use mysql_xdevapi\Exception;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Topic;
use App\Models\Subtopic;
use App\Models\Homework;
use App\Models\Reportlog;
use App\Models\NotificationTable;
use App\Models\Mycontentshare;
use App\Models\Uploadurlshare;
use App\Models\Liveclassshare;
use App\Models\Educationalgameshare;
use App\Models\Homeworkshare;
use App\Models\ApproveContent;
use Illuminate\Support\Facades\Storage;


class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $school_id=session('school_id');
      
        $query = Teacher::with('subjects')
        ->where('school_id',$school_id)
        ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('teacher_num', 'like', '%' . $search . '%')
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', surname)"), 'like', '%' . $search . '%');
            });
        }

        $teachers = $query->paginate(10);

        return view('teacher.index',compact('teachers'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $schools=DB::table('users')->where('role_id',1)->get();
        return view('teacher.view',compact('classrooms','schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TeacherAddUpdateRequest $request
     * @return false|Application|RedirectResponse|Response|Redirector|string
     */
    // public function store(TeacherAddUpdateRequest $request)
    // {
    //     try {
            
    //         // Safely perform set of DB related queries if fail rollback all.
    //         DB::transaction(function () use ($request){
    //             if ($request->hasFile('photo')) {
    //                 $path = Str::of('Teachers/')->append($request->get('surname'));
    //                 // Save the file locally in the public/images folder under a new folder named /Teachers
    //                 $photo = $request->file('photo');
    //                 $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
    //             }
               


    //             Teacher::insert([
    //                 'teacher_num' => $this->generateTeacherNumber(),
    //                 // 'first_name' => $request->get('first_name'),
    //                 // 'surname' => $request->get('surname'),
    //                 'birth_date' => $request->get('birth_date'),
    //                 // 'email' => $request->get('email'),
    //                 'phone_number' => $request->get('phone_number'),
    //                 'photo_path' => $photo_path,
    //                 'address' => $request->get('address'),
    //                 'gender' => $request->get('gender'),
    //             ]);
                
    //         });
    //     }catch (\Exception $exception){
    //         // Back to form with errors
    //         return redirect('/teacher/create')
    //             ->withErrors($exception->getMessage());
    //     }
    //     return redirect('/teacher')->with('success', 'A New Teacher Added Successfully.');
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $classrooms = Classroom::all();
        $teacher = Teacher::findOrFail($id);
        $passwordRecord = DB::table('users')->where('id', $teacher->user_id)->select('password', 'show_password')->first();
        return view('teacher.edit_teacher', compact('teacher', 'classrooms','passwordRecord'));
    }

    public function update(Request $request, int $id)
   {
    $teacher = Teacher::findOrFail($id);
    $teacher_user_id = $teacher->user_id;
    $user = User::findOrFail($teacher_user_id);

     $this->validate($request, [
        'first_name' => 'required|max:30',
        'surname' => 'required|max:30',
        'birth_date' => 'required',
        'email' => ['required', Rule::unique('teachers', 'email')->ignore($id),],
        'phone_number' => 'required|regex:/[0-9]{10}/',
        'photo' => 'required|mimes:jpeg,bmp,png,jpg|max:2048',
        'address' => 'required',
     ]);

    try {
        DB::transaction(function () use ($request, $teacher, $user) {
            if ($request->hasFile('photo')) {
                try {
                    unlink(public_path('/images/' . $teacher->photo_path));
                } catch (\Exception $exception) {
                }
                $path = Str::of('Teachers/')->append($request->get('surname'));
                
                $photo = $request->file('photo');
                $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
            }
            $teacher->first_name = $request->first_name;
            $teacher->surname = $request->surname;
            $teacher->birth_date = $request->birth_date;
            $teacher->email = $request->email;
            $teacher->phone_number = $request->phone_number;
            $teacher->photo_path = $photo_path;
            $teacher->address = $request->address;
            $teacher->gender = $request->gender;
            $teacher->save();

            $user->email = $request->email;
            $user->name = $request->first_name . " " . $request->surname;
            $user->phone_number = $request->phone_number;
            $user->photo_path = $photo_path;
            if($request->has('password') && !empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        });
    } catch (\Exception $exception) {
        return redirect('/teacher/edit/' . $id)
            ->withErrors($exception->getMessage())->withInput();
    }
    return redirect('/teacher')->with('success', 'A Teacher Updated Successfully.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
   public function destroy(int $id)
    {
    try {
        $teacher = Teacher::findOrFail($id); // Find the Teacher record by ID
        $user = User::where('email', $teacher->email)->first(); // Find the User record by email

        if ($teacher && $user) {
            $teacher->delete();
            $user->delete();
        } else {
              Teacher::destroy($id);
            return redirect('/teacher')->with('error', 'Teacher or User not found.');
        }

    } catch (Exception $exception) {
        return redirect('/teacher')->with('error', $exception->getMessage());
    }

    return redirect('/teacher')->with('success', 'Teacher and User Deleted Successfully.');
}



    


public function student_create(Request $request){
    if($request->isMethod('post')){
       
    }else{
        $classrooms=Classroom::all();
        $school=user::where('role_id','=','1')->where('soft_login','=','1')->get();
       return view('student_add.class_select',compact('classrooms','school'));
    }
}

public function manage_student(){
    return view('student_add.studen_regi');
}

    public function getSubjects($id)
    {
        $subs = Subject::query()->where('classroom_id', $id)->get();
        $outputhtml = '<option value="">Select a Subject</option>';
        foreach ($subs as $sub) {
            $outputhtml .= '<option value="' . $sub->id . '">' . $sub->name . '</option>';
        }
        echo $outputhtml;
    }

    //Todo: Marge generateTeacherNumber, generateStudentNumber and generateSubjectNumber to be one generic function.
    public function generateTeacherNumber(): string
    {
        return (string)str('TN-')->append($this->getLastTCID());
    }
    function getLastTCID()
    {
        $last = Teacher::query()->orderByDesc('teacher_num')->first('teacher_num');
        if($last != null){
            $lastNum = (string)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum +1);
        } else
            return sprintf("%06d", 1);
    }

    public function changePassword(Request $request)
    {
    $validated = $request->validate([
        'currentPassword' => 'required|string',
        'newPassword' => 'required|string',
    ]);

    $teacherId = session('teacher_id');
    $userId = DB::table('teachers')->where('id',$teacherId)->first('user_id');
    $user = DB::table('users')->where('id',$userId->user_id)->first();

 

    if (!Hash::check($validated['currentPassword'], $user->password)) {
        return response()->json(['success' => false, 'message' => 'Current password is incorrect.']);
    }

        DB::table('users')
        ->where('id', $userId->user_id)
        ->update([
            'password' => Hash::make($validated['newPassword']),
            'show_password' => $validated['newPassword'],
        ]);

    return response()->json(['success' => true, 'message' => 'Password changed successfully.']);
  }



    public function getteacherdata(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
            'birth_date' => 'required|date',
            'phone_number' => 'required|string|max:11|regex:/^\d+$/',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:500',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
            if ($validator->fails()) {
                return redirect('/teacher/create')
                            ->withErrors($validator)
                            ->withInput();
            }

        
        try {
            DB::beginTransaction();
    
            $school_id = session('school_id');
            $teacher_role_id = 2;
            $soft_login = 1;
            $photo_path = null;
    
            if ($request->hasFile('photo')) {
                $path = Str::of('Teachers/')->append($request->get('surname'));
                $photo = $request->file('photo');
                $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
            }
    
            $new_entry = new User();
            $new_entry->name = $request->get('first_name') . ' ' . $request->get('surname');
            $new_entry->email = $request->get('email');
            $new_entry->photo_path = $photo_path;
            $new_entry->password = bcrypt($request->get('password'));
            $new_entry->show_password = $request->get('password');
            $new_entry->phone_number = $request->get('phone_number');
            $new_entry->role_id = $teacher_role_id;
            $new_entry->soft_login = $soft_login;
            $new_entry->save();
    
            $user_id = $new_entry->id;
    
            Teacher::create([
                'teacher_num' => $this->generateTeacherNumber(),
                'first_name' => $request->get('first_name'),
                'surname' => $request->get('surname'),
                'birth_date' => $request->get('birth_date'),
                'email' => $request->get('email'),
                'phone_number' => $request->get('phone_number'),
                'photo_path' => $photo_path,
                'address' => $request->get('address'),
                'gender' => $request->get('gender'),
                'school_id' => $school_id,
                'user_id' => $user_id,
            ]);
    
            DB::commit();
    
            return redirect('/teacher/create')->with('success', 'A Teacher Updated Successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect('/teacher/create')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function Teacherupdate(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'phone_number' => 'required|string|max:11|regex:/^\d+$/',
            'email' => 'required|email|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email',
            // 'password' => 'nullable|string|min:6|confirmed',
            'address' => 'required|string|max:500',
            'gender' => 'required|integer|in:0,1',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Find the existing teacher and user
            $teacher = Teacher::findOrFail($id);
            $user = User::findOrFail($teacher->user_id);

            $photo_path = $teacher->photo_path; // Keep the existing photo path

            if ($request->hasFile('photo')) {
                $path = Str::of('Teachers/')->append($request->get('surname'));
                $photo = $request->file('photo');
                $photo_path = $photo->storeAs($path, $photo->getClientOriginalName(), 'images');
            }

            $user->name = $request->get('first_name') . ' ' . $request->get('surname');
            $user->email = $request->get('email');
            $user->photo_path = $photo_path;
            if ($request->filled('password')) {
                // $user->password = bcrypt($request->get('password'));
                $user->password = $request->get('password');
            }
            $user->phone_number = $request->get('phone_number');
            $user->save();

            $teacher->teacher_num = $teacher->teacher_num;
            $teacher->first_name = $request->get('first_name');
            $teacher->surname = $request->get('surname');
            $teacher->birth_date = $request->get('birth_date');
            $teacher->email = $request->get('email');
            $teacher->phone_number = $request->get('phone_number');
            $teacher->photo_path = $photo_path;
            $teacher->address = $request->get('address');
            $teacher->gender = $request->get('gender');
            $teacher->save();

            DB::commit();

            return redirect('/teacher')->with('success', 'Teacher updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/teacher')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    

     
//this code for teacher login 


public function getTeacherDashboard(){
      
        $teacher_id = session('teacher_id');
        $teacher_school_id=session('school_id');
   
        $classroom_ids = Subject::select('classroom_id')
        ->where('teacher_id', $teacher_id)
        ->where('school_id', $teacher_school_id) 
        ->distinct()
        ->get()
        ->toArray();

        $classroom_details = Classroom::whereIn('id', $classroom_ids)
        ->where('school_id', $teacher_school_id) 
        ->get();
  
        $total_subjects = 0;
        $total_subjects = [];
        foreach($classroom_ids as $classroom_id){
        $subjects = Subject::where('teacher_id', $teacher_id)
        ->where('school_id', $teacher_school_id) 
        ->where('classroom_id', $classroom_id['classroom_id'])->get();
        $total_subjects[$classroom_id['classroom_id']] = count($subjects);
        }

      return view('teacher.teacher_dashboard', ['classroom_details' => $classroom_details, 'total_subjects'=>$total_subjects]);
    }


    public function teacher_subject(Request $request){
      
       $teacher_id=session('teacher_id');
       $school_id=session('school_id');
       $classroomName="";
       $class_id=$request->id;
     
       $classroom_detail=Classroom::where('id','=',$class_id)
       ->where('school_id','=',$school_id)
       ->first();
       $subject_data = Subject::where('classroom_id', '=', $class_id)
                ->where('teacher_id', '=', $teacher_id)
                ->where('school_id','=',$school_id)
                ->get();
               
        if($classroom_detail) 
        {
            $classroomName=$classroom_detail->name;  
        }  
        $course_counts = []; 
      foreach ($subject_data as $subject) {
        $subject_code = $subject->subject_code;
        $total_course = Course::where('subject_code', '=', $subject->subject_code)
        ->where('school_id','=',$school_id)
        ->count();
        $course_counts[$subject_code] = $total_course;
        }
        return view('teacher.subject_page', ['subject_data'=>$subject_data, 
        'classroomName'=>$classroomName, 'course_counts'=>$course_counts]);
     }
    

     public function totalcourses(Request $request)
     {
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        $classroom_Name="";

        $subject_code=$request->subject_code;
        $subject = Subject::where('subject_code', '=', $subject_code)
        ->where('school_id','=',$school_id)
        ->first();
        $subjectName=$subject->name;

        $courses_detail=Course::where('subject_code','=',$subject_code)
        ->where('school_id','=',$school_id)
        ->get();
        //dd($courses_detail);
        foreach ($courses_detail as $course_detail) {
        $classroom_id = $course_detail->classroom_id;
        $classroom = Classroom::where('id', $classroom_id)->first(['name']); 
        if ($classroom) {
            $classroom_name = $classroom->name;
        }
       }
        $new_data=[
            'class_name'=>$classroom_name,
            'classroom_id'=>$classroom_id,
            'subject_code'=>$subject_code,
            'subjectName'=>$subjectName,
        ];

        return view('teacher.teachercourse',['courses_detail'=>$courses_detail, 'new_data'=>$new_data]);
     }


     public function teacherframe(Request $request)
     {
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        $course_id=$request->id;
        $class_id="";
        $className="";
        $subjectName="";
        $subject_code="";
      
        $course_data=Course::where('id','=',$course_id)
         ->where('school_id','=',$school_id)
        ->first();
        $course_detail=Course::where('id','=',$course_id)
         ->where('school_id','=',$school_id)
        ->get();
        if ($course_data)
        {
            $class_id=$course_data->classroom_id;
            $subject_code=$course_data->subject_code;
        }
        $class_data=Classroom::where('id','=',$class_id)->first('name');
        $subject_data=Subject::where('subject_code','=',$subject_code)
        ->where('school_id','=',$school_id)
        ->first('name');
        $className=$class_data['name'];
        $subjectName=$subject_data['name'];
        $pageMenu = [
                "className" => $className,
                "classroom_id" => $class_id,
                "subjectName" => $subjectName,
                "subject_code" => $subject_code,
            ];

        return view('teacher.teacher_frame',['course_detail'=>$course_detail,'pageMenu'=>$pageMenu]);
     }


// this code when teacher requested  any course  teacher view
     public function addnew_requested_course()
     {
        
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
         $classrooms = DB::table('subjects')
            ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
            ->where('subjects.teacher_id', '=', $teacher_id)
            ->where('subjects.school_id', '=', $school_id)
            ->where('classrooms.school_id', '=', $school_id)
            ->distinct()
            ->pluck('classrooms.name','subjects.classroom_id');

        $topics = Topic::all();
        $subtopic = Subtopic::all();
        return view('teacher.requestednewcourse',['classrooms'=>$classrooms,'topics'=>$topics,'subtopic'=>$subtopic]);
    }

    public function commonGetSubjects($classroomId ,$type = null)
    {
        if($type == 'admin')
        {
            $subjects = DB::table('subjects')
            ->where('classroom_id', $classroomId)
            ->where('school_id',session('school_id'))
            ->pluck('name', 'subject_code');
        }else{
            $subjects = DB::table('subjects')
            ->where('classroom_id', $classroomId)
            ->where('teacher_id', '=', session('teacher_id'))
            ->where('school_id',session('school_id'))
            ->pluck('name', 'subject_code');
        }
        // dd($subjects);
       
    
        return response()->json($subjects);
    }

    public function commongetTopics($classroomId, $subjectId)
    {
        $topics = DB::table('topics')
        ->where('classroom', $classroomId)
        ->where('subject', '=', $subjectId)
        ->pluck('course_title', 'id');

    return response()->json($topics);
   }
   public function commongetSubTopics($topicId, $subjectId)
   {
       $subtopics = DB::table('subtopics')
       ->where('topic_id', $topicId)
       ->where('subject_id', '=', $subjectId)
       ->pluck('sub_topic_name', 'id');

   return response()->json($subtopics);
  }
    

    public function editmycontent($id)
    {
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        
       $classrooms = DB::table('subjects')
       ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
       ->where('subjects.teacher_id', '=', $teacher_id)
       ->where('subjects.school_id', '=', $school_id)
       ->where('classrooms.school_id', '=', $school_id)
       ->distinct()
       ->pluck('classrooms.name','subjects.classroom_id');
       
       
        $topics = Topic::all();
        $subtopics = Subtopic::all();
        $mycontent = Requested::find($id);

        return view('teacher.mycontent_edit', compact('topics', 'classrooms', 'subtopics','mycontent'));
    }

    public function addTopic()
    {
        $teacher_school_id=session('school_id');
        $teacher_id = session('teacher_id');

        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=', $teacher_id)
        ->where('subjects.school_id', '=', $teacher_school_id)
        ->where('classrooms.school_id', '=', $teacher_school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
   
        return view('teacher.topic.addtopic', ['classrooms' => $classrooms]);
        
    }

    public function saveTopic(Request $request)
    {
        $request->validate([
            'course_title' => 'required|string|max:255',
            'classroom' => 'required|exists:classrooms,id',
            'subject' => 'required',
        ]);

        try {
            DB::table('topics')->insert([
                'course_title' => $request->course_title,
                'classroom' => $request->classroom,
                'subject' => $request->subject,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('topic.index')->with('success', 'Topic saved successfully.');
        } catch (Exception $e) {
            // dd($e->getMessage());
            Log::error('Error saving topic: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while saving the topic. Please try again.')->withInput();
        }
    }

    public function checkTopic(Request $request)
   {
    $exists = DB::table('topics')->where('course_title', $request->course_title)->exists();

    return response()->json(['exists' => $exists]);
  }

  public function editTopic(int $id)
   {
        $topic = Topic::find($id);

        $teacher_school_id=session('school_id');
        $teacher_id = session('teacher_id');

        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=', $teacher_id)
        ->where('subjects.school_id', '=', $teacher_school_id)
        ->where('classrooms.school_id', '=', $teacher_school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        
        $subjects = Subject::where('teacher_id', $teacher_id)
        ->where('school_id', $teacher_school_id)->pluck('name', 'subject_code');

        return view('teacher.topic.edit', compact('topic','classrooms','subjects'));
    }

    public function topicUpdate(Request $request, $id)
   {
    $validatedData = $request->validate([
        'course_title' => 'required|string|max:255',
        'classroom' => 'required|exists:classrooms,id',
        'subject' => 'required',
    ]);

    $topic = Topic::find($id);
    $topic->course_title = $validatedData['course_title'];
    $topic->classroom = $validatedData['classroom'];
    $topic->subject = $validatedData['subject'];
    $topic->save();

    return redirect()->route('manage.topic.index')->with('success', 'Topic updated successfully.');
   }
    public function deleteTopic($id)
    {
        $topic = Topic::findOrFail($id);
        $topic->delete();

        return redirect()->route('manage.topic.index')->with('success', 'Topic deleted successfully.');
    }

   


  public function manageTopic(Request $request)
  {
    try {
        $search = $request->input('search');

        $query = DB::table('topics')
            ->join('classrooms', 'topics.classroom', '=', 'classrooms.id')
            ->join('subjects', 'topics.subject', '=', 'subjects.subject_code')
            ->select('topics.*', 'classrooms.name as classroom_name', 'subjects.name as subject_name');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('topics.course_title', 'LIKE', "%{$search}%")
                    ->orWhere('classrooms.name', 'LIKE', "%{$search}%")
                    ->orWhere('subjects.name', 'LIKE', "%{$search}%");
            });
        }

        $topics = $query->paginate(10);

        return view('teacher.topic.topiclist', compact('topics', 'search'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while fetching data.');
    }
  }


    public function addSubTopic()
    {
        $teacher_school_id=session('school_id');
        $teacher_id = session('teacher_id');

        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=', $teacher_id)
        ->where('subjects.school_id', '=', $teacher_school_id)
        ->where('classrooms.school_id', '=', $teacher_school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');

        $topic = Topic::all();
        

        
        return view('teacher.subtopic.addsubtopic', ['classrooms' => $classrooms ,'topic' => $topic]);
        
    }

    public function saveSubTopic(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required',
            'topic_id' => 'required',
            'sub_topic_name' => 'required|string',
        ]);
        try {
            DB::table('subtopics')->insert([
                'classroom_id' => $request->input('classroom_id'),
                'subject_id' => $request->input('subject_id'),
                'topic_id' => $request->input('topic_id'),
                'sub_topic_name' => $request->input('sub_topic_name'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('subtopic.create')->with('success', 'Sub Topic saved successfully.');
        } catch (Exception $e) {
            // dd($e->getMessage());
            Log::error('Error saving topic: ' . $e->getMessage());
            return redirect()->back()->withErrors('An error occurred while saving the topic. Please try again.')->withInput();
        }
    }

    public function manageSubTopic(Request $request)
   {
    try {
        $search = $request->input('search');

        $query = DB::table('subtopics')
            ->join('classrooms', 'subtopics.classroom_id', '=', 'classrooms.id')
            ->join('subjects', 'subtopics.subject_id', '=', 'subjects.subject_code')
            ->join('topics', 'subtopics.topic_id', '=', 'topics.id')
            ->select('subtopics.*', 'classrooms.name as classroom_name', 'subjects.name as subject_name','topics.course_title as topic_name');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('topics.course_title', 'LIKE', "%{$search}%")
                    ->orWhere('classrooms.name', 'LIKE', "%{$search}%")
                    ->orWhere('subjects.name', 'LIKE', "%{$search}%")
                    ->orWhere('subtopics.sub_topic_name', 'LIKE', "%{$search}%");
            });
        }

        $subtopics = $query->paginate(10);

        return view('teacher.subtopic.subtopiclist', compact('subtopics', 'search'));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'An error occurred while fetching data.');
    }
   }

    public function editSubTopic(int $id)
    {
      $subtopic = Subtopic::find($id);

      $teacher_school_id=session('school_id');
      $teacher_id = session('teacher_id');
 
      $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=', $teacher_id)
        ->where('subjects.school_id', '=', $teacher_school_id)
        ->where('classrooms.school_id', '=', $teacher_school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        // dd($classrooms);

      $topic = Topic::all();

      return view('teacher.subtopic.edit', compact('subtopic','classrooms','topic'));
    }

  public function subtopicUpdate(Request $request, $id)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'subject_id' => 'required',
            'topic_id' => 'required|exists:topics,id',
            'sub_topic_name' => 'required|string',
        ]);

        $subtopic = Subtopic::findOrFail($id);
        $subtopic->update([
            'classroom_id' => $request->input('classroom_id'),
            'subject_id' => $request->input('subject_id'),
            'topic_id' => $request->input('topic_id'),
            'sub_topic_name' => $request->input('sub_topic_name'),
        ]);

          return redirect()->route('manage.subtopic.index')->with('success', 'Subtopic updated successfully!');
    }

    public function deleteSubTopic($id)
    {
        $subtopic = Subtopic::findOrFail($id);
        $subtopic->delete();

        return redirect()->route('manage.subtopic.index')->with('success', 'Topic deleted successfully.');
    }

    public function addHomework()
    {
        $teacher_school_id=session('school_id');
        $teacher_id = session('teacher_id');
   
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=',session('teacher_id'))
        ->where('subjects.school_id', '=', session('school_id'))
        ->where('classrooms.school_id', '=', session('school_id'))
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');

        $content = DB::table('videos')->where('status','Approve')->get();

        return view('teacher.homework.create', ['classrooms' => $classrooms,'content'=>$content]);
    }

    public function homeworkStore(Request $request)
    {
        $request->validate([
            'homework_title' => 'nullable|string',
            'classroom_id' => 'nullable|integer',
            'topic_id' => 'nullable|integer',
            'subtopic_id' => 'nullable|integer',
            'homework_file' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data = $request->all();
        // dd($data);

        if ($request->hasFile('homework_file')) {
            $file = $request->file('homework_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('homeworks', $filename, 'public');
            $data['homework_file'] = $path;
        }

        Homework::create($data);

        return redirect()->back()->with('success', 'Homework added successfully');
    }

    public function manageHomework(Request $request)
    {
     try {
         $search = $request->input('search');
 
         $query = DB::table('homework')
             ->join('classrooms', 'homework.classroom_id', '=', 'classrooms.id')
             ->join('subjects', 'homework.subject_code', '=', 'subjects.subject_code')
             ->select('homework.*', 'classrooms.name as classroom_name', 'subjects.name as subject_name');
 
         if (!empty($search)) {
             $query->where(function ($q) use ($search) {
                 $q->where('subjects.name', 'LIKE', "%{$search}%")
                     ->orWhere('classrooms.name', 'LIKE', "%{$search}%");
                    //  ->orWhere('subtopics.sub_topic_name', 'LIKE', "%{$search}%");
             });
         }
 
         $homeworks = $query->paginate(10);
        //  dd($homeworks);

         $classroom_ids = Subject::select('classroom_id')
            ->where('teacher_id', session('teacher_id'))
            ->where('school_id', session('school_id'))
            ->distinct()
            ->pluck('classroom_id')
            ->toArray();
        
            $students = DB::table('students')
                ->select('id', 'student_num', DB::raw("CONCAT(first_name, ' ', surname) as full_name"))
                ->where('school', session('school_id'))
                ->whereIn('classroom_id', $classroom_ids)
                ->get();
 
         return view('teacher.homework.index', compact('homeworks','students'));
     } catch (\Exception $e) {
        // dd($e->getmessage());
         return redirect()->back()->with('error', 'An error occurred while fetching data.');
     }
    }

    public function editHomework($id)
    {
        $homework = Homework::findOrFail($id);
        // $classroom_details = Classroom::all();
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=',session('teacher_id'))
        ->where('subjects.school_id', '=', session('school_id'))
        ->where('classrooms.school_id', '=', session('school_id'))
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        $content = DB::table('videos')->where('status','Approve')->get();


        return view('teacher.homework.edit', compact('homework', 'classrooms','content'));
    }

    public function updateHomework(Request $request, $id)
   {
    $homework = Homework::findOrFail($id);

    $request->validate([
        'homework_title' => 'nullable|string',
        'classroom_id' => 'nullable|integer',
        'homework_file' => 'nullable|file|mimes:pdf,doc,docx',
    ]);

    $data = $request->all();

    if ($request->hasFile('homework_file')) {
        // Delete the old file if it exists
        if ($homework->homework_file) {
            Storage::disk('public')->delete($homework->homework_file);
        }

        $file = $request->file('homework_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('homeworks', $filename, 'public');
        $data['homework_file'] = $path;
    }

    $homework->update($data);

    return redirect()->route('manage.homework.index')->with('success', 'Homework updated successfully!');
 }

    public function destroyHomework($id)
    {
        $homework = Homework::findOrFail($id);

        // Delete the file from storage
        if ($homework->homework_file) {
            Storage::disk('public')->delete($homework->homework_file);
        }

        // Delete the homework record
        $homework->delete();

        return redirect()->back()->with('success', 'Homework deleted successfully');
    }

    public function editLiveClass($id)
    {
        $liveClass = DB::table('meeting_link')->where('id',$id)->first();
        // $classroom_details = Classroom::all();
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=',session('teacher_id'))
        ->where('subjects.school_id', '=', session('school_id'))
        ->where('classrooms.school_id', '=', session('school_id'))
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        
        $topics = Topic::all();
        $subtopics = Subtopic::all();

        return view('teacher.edit_live_class', compact('liveClass', 'classrooms', 'topics', 'subtopics'));
    }


    public function manageLiveClass(Request $request)
    {

        $search = $request->input('search');

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
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('topics.course_title', 'LIKE', "%{$search}%")
                    ->orWhere('classrooms.name', 'LIKE', "%{$search}%")
                    ->orWhere('subtopics.sub_topic_name', 'LIKE', "%{$search}%");
            });
        }

        $meetingLinks = $query->paginate(10);


        $teacher_id = session('teacher_id');
        $teacher_school_id=session('school_id');
   
        $classroom_ids = Subject::select('classroom_id')
            ->where('teacher_id', $teacher_id)
            ->where('school_id', $teacher_school_id)
            ->distinct()
            ->pluck('classroom_id')
            ->toArray();
        
            $students = DB::table('students')
                ->select('id', 'student_num', DB::raw("CONCAT(first_name, ' ', surname) as full_name"))
                ->where('school', $teacher_school_id)
                ->whereIn('classroom_id', $classroom_ids)
                ->get();
        return view('teacher.manageliveclass',compact('meetingLinks','students'));
    }

    public function shareLiveClass(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $meetingId = $id;
        $teacher_school_id=session('school_id');
        $liveClassDetails = DB::table('meeting_link')->where('id',$meetingId)->first();
        $studentIds = implode(',', $request->input('student_ids'));


        Liveclassshare::create([
            'students_ids' => $studentIds,
            'teacher_id' => $liveClassDetails->teacher_id ?? 0,
            'topic' => $liveClassDetails->topic_id,
            'sub_topic' => $liveClassDetails->subtopic_id,
            'description' => $request->description,
            // 'status' => 'done',
            'meeting_link' => $liveClassDetails->class,
            'meeting_time' => $liveClassDetails->class_time,
        ]);

        $studentArray = $request->input('student_ids');

        // Store notification for each student
        foreach ($studentArray as $studentId) {
            NotificationTable::create([
                'school_id' => $teacher_school_id,
                'student_id' => $studentId,
                'teacher_id' => $liveClassDetails->teacher_id ?? 0,
                'notification_type' => 'live_class',
                'description' => 'one live class is added',
                'notification_url' => $liveClassDetails->class,
                'seen_at' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Live class shared successfully.');
    }

    public function shareMyContent(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $meetingId = $id;
        $liveVideoDetails = DB::table('videos')->where('id',$meetingId)->first();
        // dd($liveVideoDetails);
        $studentIds = implode(',', $request->input('student_ids'));


        Mycontentshare::create([
            'students_ids' => $studentIds,
            'teacher_id' => $liveVideoDetails->teacher_id ?? 0,
            'topic_id' => $liveVideoDetails->topic_id,
            'sub_topic_id' => $liveVideoDetails->subtopic_id,
            'description' => $request->description,
            'classroom_id' => $liveVideoDetails->classroom_id,
            'subject_id' => $liveVideoDetails->subject_code,
            'content_title' => $liveVideoDetails->course_title,
            'course_type' => $liveVideoDetails->courses_type,
            // 'status' => 'done',
            'content_link' => $liveVideoDetails->video,
            // 'content_time' => $liveVideoDetails->class_time,
        ]);

        return redirect()->back()->with('success', 'My content shared successfully.');
    }

    public function uploadUrlShares(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $meetingId = $id;
        $liveUploadUrlDetails = DB::table('requests')->where('id',$meetingId)->first();
        $studentIds = implode(',', $request->input('student_ids'));
        // dd($request->all());


        Uploadurlshare::create([
            'students_ids' => $studentIds,
            'teacher_id' => $liveUploadUrlDetails->teacher_id ?? 0,
            'topic_id' => $liveUploadUrlDetails->topic_id,
            'sub_topic_id' => $liveUploadUrlDetails->subtopic_id,
            'description' => $request->description,
            'classroom_id' => $liveUploadUrlDetails->classroom_id,
            'subject_id' => $liveUploadUrlDetails->subject_code,
            'course_title' => $liveUploadUrlDetails->course_title,
            // 'status' => 'done',
            'course_link' => $liveUploadUrlDetails->url,
            // 'course_time' => $liveUploadUrlDetails->class_time,
        ]);

        return redirect()->back()->with('success', 'My content shared successfully.');
    }

    public function educationGamesShares(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $meetingId = $id;
        $gamesDetails = DB::table('games')->where('id',$meetingId)->first();
        $studentIds = implode(',', $request->input('student_ids'));
        // dd($gamesDetails);


        Educationalgameshare::create([
            'students_ids' => $studentIds,
            'teacher_id' => $gamesDetails->teacher_id ?? 0,
            'topic_id' => $gamesDetails->topic_id,
            'sub_topic_id' => $gamesDetails->subtopic_id,
            'description' => $request->input('description'),
            'classroom_id' => $gamesDetails->classroom_id,
            'subject_id' => $gamesDetails->subject_code ?? 0,
            'game_title' => $gamesDetails->name ?? 0,
            // 'status' => 'done',
            'game_link' => $gamesDetails->url,
            // 'game_time' => $gamesDetails->class_time,
        ]);

        return redirect()->back()->with('success', 'My content shared successfully.');
    }

    public function homeworksShares(Request $request, $id)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $meetingId = $id;
        $homeworkDetails = DB::table('homework')->where('id',$meetingId)->first();
        $studentIds = implode(',', $request->input('student_ids'));
        $teacher_school_id=session('school_id');


        Homeworkshare::create([
            'students_ids' => $studentIds,
            'teacher_id' => $homeworkDetails->teacher_id ?? 0,
            'topic_id' => $homeworkDetails->content_id ?? 0,
            'sub_topic_id' => $homeworkDetails->subtopic_id ?? 0,
            'description' => $request->description,
            'classroom_id' => $homeworkDetails->classroom_id ?? 0,
            'subject_id' => $homeworkDetails->subject_code ?? 0,
            'homework_title' => $homeworkDetails->homework_title ?? 0,
            'homework_link' => $homeworkDetails->homework_file ?? 0,
        ]);

        $studentArray = $request->input('student_ids');

        // Store notification for each student
        foreach ($studentArray as $studentId) {
            NotificationTable::create([
                'school_id' => $teacher_school_id,
                'student_id' => $studentId,
                'teacher_id' => $homeworkDetails->teacher_id ?? 0,
                'notification_type' => 'home work',
                'description' => 'Home is Added !',
                'notification_url' => $homeworkDetails->homework_file,
                'seen_at' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Home work shared successfully.');
    }



  



    public function testapi(Request $request)
    {
        $teachers=DB::table('teachers')->where('user_id',Auth::user()->id)->first();
          $subjects = Subject::where('classroom_id', '=',$request->classroom_id)->where('teacher_id','=',$teachers->id)->get();
           return response()->json($subjects);        
        }
   


    public function add_video(Request $request) {
        if ($request->isMethod('post')) {
            $video = video($request);
            $teacher_id = session('teacher_id');
            $school_id = session('school_id');
            
            $Add_Requested_video = Video::create([
                'classroom_id'=>$request->classroom_id,
                'teacher_id' => $teacher_id,
                'course_title' => $request->input('course_title'),
                'subject_code' => $request->input('subject_name'),
                'courses_type' => $request->input('coursetype'),
                'topic_id' => $request->input('topic_id'),
                'subtopic_id' => $request->input('subtopic_id'),
                'video' => $video,
                'games' => $request->game,
                'diksh' => $request->diksha,
                'description' => $request->input('description'),
                'school_id' => $school_id,
            ]);

            $requestedId = $Add_Requested_video->id;

            $Add_ForApproval_courses = ApproveContent::create([
                'classroom_id' => $request->classroom_id,
                'subject_code' => $request->input('subject_name'),
                'teacher_id' => $teacher_id,
                'content' => $video,
                'schoole_id' => $school_id,
                'description' => 'videos , ' . $requestedId,
            ]);
    
            return redirect()->back()->with('success', 'A Teacher Updated Successfully.');
        } else {
            $teacher_id = session('teacher_id');
            $school_id = session('school_id');
    
            $classrooms = DB::table('subjects')
                ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
                ->where('subjects.teacher_id', '=', $teacher_id)
                ->where('subjects.school_id', '=', $school_id)
                ->where('classrooms.school_id', '=', $school_id)
                ->distinct()
                ->pluck('classrooms.name','subjects.classroom_id');
            $data = Video::where('teacher_id', $teacher_id)->get();
            $topics = Topic::all();
            $subtopic = Subtopic::all();

            return view('teacher.add_video', compact('data','topics','subtopic','classrooms'));
        }
    }
    


    public function add_video_update(Request $request ,$id){
        if($request->isMethod('post')){
            // dd($request->all());
            $data=video($request);
            $teacher_id=session('teacher_id');
            $school_id=session('school_id');
            $Add_Requested_courses=Video::where('id',$id)->update([
            'teacher_id' => $teacher_id,
            'course_title'=>$request->input('course_title'),
            'topic_id'=>$request->input('topic_id'),
            'subtopic_id'=>$request->input('subtopic_id'),
            'classroom_id'=>$request->input('classroom_id'),
            'subject_code'=>$request->input('subject_code'),
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
        // $classrooms=Classroom::where('school_id','=',$school_id)->get();
        $classrooms = DB::table('subjects')
                ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
                ->where('subjects.teacher_id', '=', $teacher_id)
                ->where('subjects.school_id', '=', $school_id)
                ->where('classrooms.school_id', '=', $school_id)
                ->distinct()
                ->pluck('classrooms.name','subjects.classroom_id');
        $data=Video::where('teacher_id',$teacher_id)->where('id',$id)->first();
        $topics= Topic::all();
        $subtopics = Subtopic::all();
        return view('teacher.updata_video',['classrooms'=>$classrooms],compact('data','topics','subtopics'));
        }
    }



    public function content_delete($id){
        $Add_Requested_courses=ApproveContent::where('id',$id)->delete();
       return  redirect()->back()->with('success', 'This Content is Deleted Successfully.');    
    }




    public function video(Request $request){
        $teacher_id = session('teacher_id');
        $school_id=session('school_id');
        $requested_data = Video::where('teacher_id', $teacher_id)
        ->where('school_id','=',$school_id)
        ->orderBy('created_at', 'desc')->Paginate(10);
         $classroom_names = [];
         $subject_names = [];
     foreach ($requested_data as $record) {
         $classroom = Classroom::find($record->classroom_id);
         $sub = $record->subject_code;
         $subject = Subject::where('subject_code', $sub)->first();
         if ($classroom) {
             $classroom_names[] = $classroom->name;
         }
         if ($subject) {
             $subject_names[] = $subject->name;
         }
     }

        $data = Video::query()
        ->leftJoin('topics', 'videos.topic_id', '=', 'topics.id')
        ->leftJoin('subtopics', 'videos.subtopic_id', '=', 'subtopics.id')
        ->where('videos.teacher_id', $teacher_id)
        ->where('videos.school_id', session('school_id')) // Assuming you want to filter by school_id as well
        ->select('videos.*', 'topics.course_title as topic_name', 'subtopics.sub_topic_name as subtopic_name');

    if ($request->has('search')) {
        $search = $request->input('search');
        $data->where(function ($query) use ($search) {
            $query->where('videos.name', 'like', "%{$search}%")
                ->orWhere('topics.course_title', 'like', "%{$search}%")
                ->orWhere('subtopics.sub_topic_name', 'like', "%{$search}%");
        });
    }

    $videos = $data->paginate(10);

    $classroom_ids = Subject::select('classroom_id')
            ->where('teacher_id', $teacher_id)
            ->where('school_id', $school_id)
            ->distinct()
            ->pluck('classroom_id')
            ->toArray();
            
    $students = DB::table('students')
                ->select('id', 'student_num', DB::raw("CONCAT(first_name, ' ', surname) as full_name"))
                ->where('school', $school_id)
                ->whereIn('classroom_id', $classroom_ids)
                ->get();

     return view('teacher.managevideo', [
         'requested_data' => $requested_data,
         'classroom_names' => $classroom_names,
         'subject_names' => $subject_names,
         'data'=>$data,
         'videos'=>$videos,
         'students' => $students,
     ]);
    }

    public function storeReportContent(Request $request)
    {
    try {
        $contentDetails = null;
        if ($request->table_name == 'requests') {
            $contentDetails = DB::table('requests')->where('id', $request->video_id)->first();
        } else {
            $contentDetails = DB::table('videos')->where('id', $request->video_id)->first();
        }

        if (!$contentDetails) {
            return response()->json(['message' => 'Content not found'], 404);
        }

        $log = new Reportlog();
        $log->video_id = $request->video_id;
        $log->content_name = $contentDetails->course_title;
        $log->teacher_id = $contentDetails->teacher_id;
        $log->classroom_id = $contentDetails->classroom_id;
        $log->subject_code = $contentDetails->subject_code;
        $log->content_table_name = $request->table_name;

        if ($request->table_name == 'requests') {
            $log->content = $contentDetails->url;
            $log->content_type = 'url';
        } else {
            $log->content = $contentDetails->video;
            $log->content_type = $contentDetails->courses_type;
        }

        $log->open_time = $request->open_time;
        $log->close_time = $request->close_time ?? '-';
        $log->interval = $request->interval ?? '-';
        $log->description = session('school_id') ?? '-';
        $log->save();

        $message = ($request->table_name == 'requests') ? 'PDF log stored successfully' : 'Video log stored successfully';
        return response()->json(['message' => $message], 200);

    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error('Error storing report content: ' . $e->getMessage());

        // Return a response indicating a server error
        return response()->json(['message' => 'An error occurred while storing the report content'], 500);
    }
  }


    public function add_diksh(){
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        $classrooms=Classroom::where('school_id','=',$school_id)->get();
        return view('teacher.add_diksh',['classrooms'=>$classrooms]);

    }

    public function video_delete($id)
    {
        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return redirect()->back()->with('success', 'Video deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Error deleting video: ' . $e->getMessage());
        }
    }


    public function add_game(Request $request){
        if($request->isMethod('post')){
            // dd($request->all());
            $teacher_id = session('teacher_id');
            $school_id = session('school_id');
            $data=DB::table('games')->insert([
                   'name'=>$request->course_title,
                   'classroom_id'=>$request->classroom_id,
                   'teacher_id'=>$teacher_id,
                   'subject_code'=>$request->subject_code,
                   'school_id'=>$school_id,
                //    'topic_id'=>$request->topic_id,
                //    'subtopic_id'=>$request->subtopic_id,
                   'status'=>0,
                   'url'=>$request->coursetype,
            ]);
            return redirect()->back();
        }else{
            $teacher_id=session('teacher_id');
            $school_id=session('school_id');

            $classrooms = DB::table('subjects')
            ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
            ->where('subjects.teacher_id', '=', $teacher_id)
            ->where('subjects.school_id', '=', $school_id)
            ->where('classrooms.school_id', '=', $school_id)
            ->distinct()
            ->pluck('classrooms.name','subjects.classroom_id');

            // $teachers=DB::table('teachers')->where('user_id',Auth::user()->id)->first();
            // $classrooms = DB::table('subjects')->where('teacher_id', '=', $teachers->id)->get();
            return view('teacher.add_game',['classrooms'=>$classrooms]);
        }
    
    }


    public function manage_game(){
        
        $search = request()->input('search');

        $data = DB::table('games')
            ->leftJoin('classrooms', 'games.classroom_id', '=', 'classrooms.id')
            ->leftJoin('subjects', 'games.subject_code', '=', 'subjects.subject_code')
            ->where('games.teacher_id', session('teacher_id'))
            ->where('games.school_id', session('school_id'))
            ->select('games.*', 'classrooms.name as class_name', 'subjects.name as subject_name')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('games.name', 'like', "%{$search}%")
                        ->orWhere('subjects.name', 'like', "%{$search}%")
                        ->orWhere('classrooms.name', 'like', "%{$search}%");
                });
            })
            ->get();

            $classroom_ids = Subject::select('classroom_id')
            ->where('teacher_id', session('teacher_id'))
            ->where('school_id', session('school_id'))
            ->distinct()
            ->pluck('classroom_id')
            ->toArray();
        
            $students = DB::table('students')
                ->select('id', 'student_num', DB::raw("CONCAT(first_name, ' ', surname) as full_name"))
                ->where('school', session('school_id'))
                ->whereIn('classroom_id', $classroom_ids)
                ->get();
        

        return view('teacher.manage_game',compact('data','students'));
    }

    public function status(Request $request,$id){
        $data=DB::table('game')->where('id',$id)->first();
        if($data->status==0){
            $res=DB::table('game')->where('id',$id)->update([
                'status'=>1
            ]);
            return redirect()->back();
        }else{
            $res=DB::table('game')->where('id',$id)->update([
                'status'=>0
            ]);
            return redirect()->back();
        }
       
    }

    public function edit_game(Request $request,$id){
        if($request->isMethod('post')){
            $res=DB::table('games')->where('id',$id)->update([
                'url'=>$request->coursetype,
                'subject_code'=>$request->subject_code,
                'classroom_id'=>$request->classroom_id,
                'name'=>$request->course_title,
            ]);
            return redirect()->back();
        }else{
            $classrooms = DB::table('subjects')
            ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
            ->where('subjects.teacher_id', '=', session('teacher_id'))
            ->where('subjects.school_id', '=', session('school_id'))
            ->where('classrooms.school_id', '=', session('school_id'))
            ->distinct()
            ->pluck('classrooms.name','subjects.classroom_id');
            
            $data=DB::table('games')->where('id',$id)->first();
             return view('teacher.game_edit',compact('data','classrooms'));
        }
    }

    public function delete_game($id){
          $res=DB::table('games')->where('id',$id)->delete();
          return redirect()->back();
    }

    public function store_requested_data(Request $request)
   {
    try {
        // Retrieve teacher_id and school_id from the session
        $teacher_id = session('teacher_id');
        $school_id = session('school_id');

        // Create a new Requested course entry
        $Add_Requested_courses = Requested::create([
            'teacher_id' => $teacher_id,
            'course_title' => $request->input('course_title'),
            'classroom_id' => $request->input('classroom'),
            'subject_code' => $request->input('subject'),
            'topic_id' => $request->input('topic_id'),
            'subtopic_id' => $request->input('subtopic_id'),
            'courses_type' => 8,
            'url' => $request->input('url'),
            'school_id' => $school_id,
            'description' => $request->input('description')
        ]);

        $requestedId = $Add_Requested_courses->id;


        $Add_ForApproval_courses = ApproveContent::create([
            'classroom_id' => $request->input('classroom'),
            'subject_code' => $request->input('subject'),
            'teacher_id' => $teacher_id,
            'content' => $request->input('url'),
            'schoole_id' => $school_id,
            'description' => 'requests , ' . $requestedId,
        ]);

        // Redirect with success message
        return redirect('/teacher/request_course')->with('success', 'Url Added Successfully.');
    } catch (\Exception $e) {
        // Log the error message
        dd($e->getMessage());
        \Log::error('Error storing requested data: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'There was an error processing your request. Please try again.');
    }
   }

   public function updatemycontent(Request $request, $id)
   {
    try {
        $requested_course = Requested::findOrFail($id);

        // Retrieve teacher_id and school_id from the session
        $teacher_id = session('teacher_id');
        $school_id = session('school_id');

        // Update the requested course entry
        $requested_course->teacher_id = $teacher_id;
        $requested_course->course_title = $request->input('course_title');
        $requested_course->classroom_id = $request->input('classroom');
        $requested_course->subject_code = $request->input('subject_name');
        $requested_course->topic_id = $request->input('topic_id');
        $requested_course->subtopic_id = $request->input('subtopic_id');
        $requested_course->courses_type = 8;
        $requested_course->url = $request->input('url');
        $requested_course->school_id = $school_id;
        $requested_course->description = $request->input('description');

        $requested_course->save();

        return redirect('/teacher/manage')->with('success', 'Content updated successfully.');
    } catch (\Exception $e) {
        // dd($e->getMessage());
        \Log::error('Error updating content: ' . $e->getMessage());
        return redirect()->back()->with('error', 'There was an error processing your request. Please try again.');
    }
  }





    public function show_requeted_list(Request $request)
    {
       $teacher_id = session('teacher_id');
       $school_id=session('school_id');
       $requested_data = Requested::where('teacher_id', $teacher_id)
       ->where('school_id','=',$school_id)
       ->orderBy('created_at', 'desc')->Paginate(10);
        
        $classroom_names = [];
        $subject_names = [];

    foreach ($requested_data as $record) {
        $classroom = Classroom::find($record->classroom_id);
        $sub = $record->subject_code;
        $subject = Subject::where('subject_code', $sub)->first();
        if ($classroom) {
            $classroom_names[] = $classroom->name;
        }
        if ($subject) {
            $subject_names[] = $subject->name;
        }
    }

    $classroom_ids = Subject::select('classroom_id')
            ->where('teacher_id', $teacher_id)
            ->where('school_id', $school_id)
            ->distinct()
            ->pluck('classroom_id')
            ->toArray();
        
            $students = DB::table('students')
                ->select('id', 'student_num', DB::raw("CONCAT(first_name, ' ', surname) as full_name"))
                ->where('school', $school_id)
                ->whereIn('classroom_id', $classroom_ids)
                ->get();

                
    return view('teacher.manageteacher', [
        'requested_data' => $requested_data,
        'classroom_names' => $classroom_names,
        'subject_names' => $subject_names,
        'students' => $students,
    ]);
}

    public function destroyMycontent($id)
    {
        try {
            $content = Requested::findOrFail($id);
            $content->delete();

            return redirect()->route('mycontent.index')->with('success', 'My content deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error deleting topic: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error deleting the topic. Please try again.');
        }
    }


// this code school view of requested course 
public function  getrequestedcourse_status(Request $request)
{
    //dd('hellow');
       $teacher_id = session('teacher_id');
       $school_id=session('school_id');
       $course_id=$request->id;
       $teacher_details = [];
       $subject_details=[];

      $requested_data = Requested::where('id','=',$course_id)
      ->where('school_id','=',$school_id)
      ->get();
      foreach($requested_data as $data)
      {
        //$teacher_id = $data->teacher_id;
        $subject_code=$data->subject_code;
      }
      $teachers=Teacher::where('id','=', $teacher_id)->get();
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

    return view('teacher.viewrequestedcourse',['requested_data' => $requested_data, 'subject_details'=>$subject_details ,'teacher_details'=>$teacher_details]);
}


public function share($id){
    if(DB::table('vieos')->where('id',$id)->where('share','0')->first()){
        DB::table('vieos')->where('id',$id)->where('share','0')->update(
            [
             'share'=>'1'
            ]
            );
            return redirect()->back();
    }elseif(DB::table('vieos')->where('id',$id)->where('share','1')->first()){
        DB::table('vieos')->where('id',$id)->where('share','1')->update(
            [
             'share'=>'0'
            ]
            );
            return redirect()->back();

    }

}

public function class_link(Request $request){
    if($request->isMethod('post')){
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        $Add_Requested_courses=class_link::create([
        'teacher_id' => $teacher_id,
        'topic_id'=>$request->input('topic_id'),
        'subtopic_id'=>$request->input('subtopic_id'),
        'subject_code'=>$request->input('subject_name'),
        // 'courses_type'=>$request->input('coursetype'),
        'class_time'=>$request->class_time,
        'to_meeting_time'=>$request->to_meeting_time,
        'class'=>$request->class_link,
        'school_id'=>$school_id,
        'class_room'=>$request->classroom_id,
        'note'=>$request->note
         ]);
       return redirect()->bacK()->with('msg','Send successfullly');
    }else{
        $teacher_id=session('teacher_id');
        $school_id=session('school_id');
        
        $classrooms = DB::table('subjects')
        ->leftJoin('classrooms', 'subjects.classroom_id', '=', 'classrooms.id')
        ->where('subjects.teacher_id', '=', $teacher_id)
        ->where('subjects.school_id', '=', $school_id)
        ->where('classrooms.school_id', '=', $school_id)
        ->distinct()
        ->pluck('classrooms.name','subjects.classroom_id');
        
        return view('teacher.class_link',['classrooms'=>$classrooms]);
        
    }
    
}




}