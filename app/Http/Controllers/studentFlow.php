<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Student_Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\stu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;


class studentFlow extends Controller
{
    public function index()
    {
        $studentId = DB::table('students')->where('email',Session('email'))->first();
        $notifications = DB::table('notification_tables')->where('student_id',$studentId->id)
        ->where('school_id',$studentId->school)
        ->whereNull('seen_at')->get();
        $notificationCount = $notifications->count();
        return view('studentFlow.index',compact('notifications','notificationCount'));
    }

    public function showChangePasswordForm()
    {
        return view('studentFlow.change-password');
    }

    public function seenNotification($id)
    {
        $notificationData = DB::table('notification_tables')->where('id',$id)->first();

        if ($notificationData) {
            DB::table('notification_tables')
                ->where('id', $id)
                ->update(['seen_at' => now()]);
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false], 404); // Handle not found
    }

    public function changePassword(Request $request)
   {
    // Validate the request
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed|min:8',
    ]);

    $student = DB::table('students')->where('email', $request->user_id)->first();

    if ($request->current_password !== $student->password) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }
    
    DB::table('students')->where('email', $request->user_id)->update([
        'password' => $request->new_password,
    ]);

    return redirect()->route('student.changePassword')->with('success', 'Password changed successfully.');
   }

    public function exam()
    {
        return view('studentFlow.exam');
    }
    public function password(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request);
            DB::table('studentregistrations')->update([
                'password' => encrypt($request->password)
            ]);
            return redirect()->back()->with('msg', 'Password updated successfully');
        } else {
            return view('studentFlow.password');
        }
    }
    public function timetable()
    {
        return view('studentFlow.timetable');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            // dd($request);
            // Check if the email already exists in the database
            $existingUser = DB::table('studentregistrations')->where('email', $request->email)->first();
            if ($existingUser) {
                // Redirect back if the email already exists
                return redirect()->back()->with('error', 'Email already exists');
            } else {
                // Insert new user data into the database
                $data = DB::table('studentregistrations')->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'class' => $request->class,
                    'dob' => $request->dob,
                    'number' => $request->number,
                    'password' => Hash::make($request->password),
                    'student_flow' => 'student_flow',
                    'school'=>$request->school
                ]);
                // Redirect back after successful registration
                return redirect('studentFlow/login')->with('msg', 'Registration successful');
            }
        } else {
            // Display the registration form
            $classrooms = Classroom::all();
            return view('studentFlow.register',compact('classrooms'));
        }
    }


    public function logoddut()
    {
        auth()->logout();
        session()->flush();
        Auth::logout();
        return redirect('/studentFlow/login');
    }



    // public function login(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $credentials = [
    //             'email' => $request->email,
    //             'parent_phone_number' => encrypt($request->password),
    //         ];
    //         if (Auth::guard('stu')->attempt($credentials)) {
    //             return redirect('studentFlow/index');
    //         } else {
    //             return back()->withErrors(['email' => 'Invalid credentials']);
    //         }
    //     } else {
    //         return view('studentFlow.login');
    //     }
    // }
    // public function __construct()
    // {
    //     $this->middleware('student.auth');
    // }

    public function loginll(Request $request)
    {
        $rules = array (
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        );
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return redirect('studentFlow/login')
                ->withErrors($v)
                ->withInput();
        }
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('studentFlow/index');
        }
        return redirect('studentFlow/login')->withErrors(['email' => 'Invalid email or password']);
    }


    public function logout()
    {
        Auth::guard('student')->logout();
        return redirect('studentFlow/login');
    }

        public function login(Request $request)
       {
        if ($request->isMethod('post')) {
            Session::put([
                'email' => $request->email,
            ]);
            
            $student = DB::table('students')->where('email', $request->email)->first();
            
                if ($student && $request->password === $student->password) {
                return redirect('studentFlow/index');
            } else {
                return redirect()->back()->withErrors(['login' => 'Invalid email or password']);
            }
        } else {
            return view('studentFlow.login');
        }
     }

    public function video()
    {
        $data = DB::table('students')->where('email',Session('email'))->first('id');
        $studentId = $data->id;

        $videoUrlShares = DB::table('uploadurlshares')
        ->leftJoin('topics', 'uploadurlshares.topic_id', '=', 'topics.id')
        ->leftJoin('subtopics', 'uploadurlshares.sub_topic_id', '=', 'subtopics.id')
        ->leftJoin('classrooms', 'uploadurlshares.classroom_id', '=', 'classrooms.id')
        ->leftJoin('subjects', 'uploadurlshares.subject_id', '=', 'subjects.subject_code')
        ->select(
            'uploadurlshares.*', 
            'topics.course_title as topic_name', 
            'subtopics.sub_topic_name as subtopic_name',
            'classrooms.name as classroom_name',
            'subjects.name as subject_name',
        )
        ->whereRaw("FIND_IN_SET(?, uploadurlshares.students_ids)", [$studentId])
        ->get();
        // dd($videoUrlShares);
        return view('studentFlow.video', compact('videoUrlShares'));
    }

    public function class()
    {
        
        $data = DB::table('students')->where('email',Session('email'))->first('id');
        $studentId = $data->id;

        $liveclassshares = DB::table('liveclassshares')
        ->leftJoin('topics', 'liveclassshares.topic', '=', 'topics.id')
        ->leftJoin('subtopics', 'liveclassshares.sub_topic', '=', 'subtopics.id')
        ->select(
            'liveclassshares.*', 
            'topics.course_title as topic_name', 
            'subtopics.sub_topic_name as subtopic_name'
        )
        ->whereRaw("FIND_IN_SET(?, liveclassshares.students_ids)", [$studentId])
        ->orderBy('meeting_time', 'desc')
        ->get();
        
        return view('studentFlow.class', compact('liveclassshares'));
    }

    public function homeworks()
    {
        
        $data = DB::table('students')->where('email',Session('email'))->first('id');
        $studentId = $data->id;

        $homeWorksShares = DB::table('homeworkshares')
        ->leftJoin('classrooms', 'homeworkshares.classroom_id', '=', 'classrooms.id')
        ->leftJoin('subjects', 'homeworkshares.subject_id', '=', 'subjects.subject_code')
        ->leftJoin('videos', function ($join) {
            $join->on('homeworkshares.topic_id', '=', 'videos.id')
                 ->where('homeworkshares.topic_id', '!=', 0);
        })
        ->select(
            'homeworkshares.*',
            'classrooms.name as classroom_name',
            'subjects.name as subject_name',
            'videos.courses_type',
            'videos.video',
        )
        ->whereRaw("FIND_IN_SET(?, homeworkshares.students_ids)", [$studentId])
        // ->orderBy('meeting_time', 'desc')
        ->get();
        
        return view('studentFlow.homeworks', compact('homeWorksShares'));
    }

    public function diksha(){
        $data = DB::table('students')->where('email',Session('email'))->first();
        $class=DB::table('meeting_link')->where('class_room',$data->classroom_id)->get();
        $link=DB::table('game')->where('status','1')->where('classroom_id',$data->classroom_id)->get();
        return view('studentFlow.diksha', compact('data','class','link'));
    }

    public function games()
    {
        $data = DB::table('students')->where('email',Session('email'))->first('id');
        $studentId = $data->id;

        $educationGamesShares = DB::table('educationalgameshares')
        // ->leftJoin('topics', 'educationalgameshares.topic_id', '=', 'topics.id')
        // ->leftJoin('subtopics', 'educationalgameshares.sub_topic_id', '=', 'subtopics.id')
        ->leftJoin('classrooms', 'educationalgameshares.classroom_id', '=', 'classrooms.id')
        ->leftJoin('subjects', 'educationalgameshares.subject_id', '=', 'subjects.subject_code')
        ->select(
            'educationalgameshares.*', 
            // 'topics.course_title as topic_name', 
            // 'subtopics.sub_topic_name as subtopic_name',
            'classrooms.name as classroom_name',
            'subjects.name as subject_name',
        )
        ->whereRaw("FIND_IN_SET(?, educationalgameshares.students_ids)", [$studentId])
        // ->orderBy('meeting_time', 'desc')
        ->get();
        
        return view('studentFlow.games', compact('educationGamesShares'));
    }

    public function course()
    {    
        $data = DB::table('students')->where('email',Session('email'))->first('id');
        $studentId = $data->id;

        $myContentShares = DB::table('mycontentshares')
        ->leftJoin('topics', 'mycontentshares.topic_id', '=', 'topics.id')
        ->leftJoin('subtopics', 'mycontentshares.sub_topic_id', '=', 'subtopics.id')
        ->leftJoin('classrooms', 'mycontentshares.classroom_id', '=', 'classrooms.id')
        ->leftJoin('subjects', 'mycontentshares.subject_id', '=', 'subjects.subject_code')
        ->select(
            'mycontentshares.*', 
            'topics.course_title as topic_name', 
            'subtopics.sub_topic_name as subtopic_name',
            'classrooms.name as classroom_name',
            'subjects.name as subject_name',
        )
        ->whereRaw("FIND_IN_SET(?, mycontentshares.students_ids)", [$studentId])
        // ->orderBy('meeting_time', 'desc')
        ->get();
        // dd($myContentShares);
        return view('studentFlow.course' , compact('myContentShares'));
    }

}