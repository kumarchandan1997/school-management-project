<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAddUpdateRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Exports\StudentsExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class StudentController extends Controller
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
    $schools = DB::table('users')->where('role_id', 1)->get();
    $query = Student::with('classroom')->join('classrooms', 'students.classroom_id', '=', 'classrooms.id')->orderBy('students.id', 'desc');

    if ($request->has('search')) {
        $searchTerm = $request->input('search');

        $query->where(function ($q) use ($searchTerm) {
            $q->where('students.student_num', 'like', '%' . $searchTerm . '%')
                ->orWhere('students.father_name', 'like', '%' . $searchTerm . '%')
                ->orWhere('students.email', 'like', '%' . $searchTerm . '%')
                ->orWhere(DB::raw("CONCAT(students.first_name, ' ', students.surname)"), 'like', '%' . $searchTerm . '%')
                ->orWhere('classrooms.name', 'like', '%' . $searchTerm . '%');
        });
    }

    $students = $query->select('students.*')->paginate(10);

    return view('student.index', compact('students'));
  }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $classrooms = DB::table('classrooms')->where('school_id',session('school_id'))->get();
        $schools=DB::table('users')->where('role_id',1)->get();
        return view('student.view', compact('classrooms','schools'));
    }

    public function downloadStudentDetails(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $students = DB::table('students')->where('classroom_id', $classroomId)->get();
        $fileName = 'student_details_classroom_' . $classroomId . '.xlsx';
        return Excel::download(new StudentsExport($students), $fileName);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentAddUpdateRequest $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'classroom' => 'required',
            'enrollment_date' => 'required|date',
            // 'email' => 'required|email|unique:students,email',
            // 'password' => 'required|string|min:6',
            'first_name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'gender' => 'required|in:0,1',
            'birth_date' => 'required|date',
            'parent_phone_number' => 'required|string|max:11|regex:/^\d+$/',
            'father_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);
    
        if ($validator->fails()) {
            return redirect('/student/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        try {   
            
            $user_id = $request->get('first_name').'_'.$request->get('surname').'_'.($request->get('parent_phone_number') ?? '123456789');
            
              $randomPassword = Str::random(10);
       
            Session::put([
                'classroom' => $request->classroom,
                'school'=>$request->school,
                'first_name' => $request->get('first_name'),
                'surname' => $request->get('surname'),
                'birth_date' => $request->get('birth_date'),
                'classroom_id' => $request->get('classroom'),
                'parent_phone_number' =>($request->get('parent_phone_number')),
                'father_name' => $request->get('father_name'),
                'enrollment_date' => $request->get('enrollment_date'),
                'address' => $request->get('address'),
                'gender' => $request->get('gender'),
                'email'=>$user_id,
                'password' => $randomPassword,
            ]);

              $school=Auth::user()->id;
                    Student::insert([
                        'student_num' => $this->generateStudentNumber(),
                        'first_name' => $request->get('first_name'),
                        'surname' => $request->get('surname'),
                        'birth_date' => $request->get('birth_date'),
                        'classroom_id' => $request->get('classroom'),
                        'school'=>$school,
                        'parent_phone_number' =>($request->get('parent_phone_number')),
                        'father_name' => $request->get('father_name'),
                        'enrollment_date' => $request->get('enrollment_date'),
                        'address' => $request->get('address'),
                        'gender' => $request->get('gender'),
                        'email'=>$user_id,
                        'password' => $randomPassword,
                    ]);
              
            } catch (\Exception $exception){
                return redirect('/student/create')
                    ->withErrors($exception->getMessage());
            }
             return redirect('/student/manage')->with('success', 'A New Student Added Successfully.');
        
    }
     
       
    

    public function stu_store(Request $request)
    {
         DB::table('users')->insert([
           'name'=>Session('first_name'),
           'email'=>Session('email'),
           'password'=>Session('password'),
           'role_name'=>('student'),
           'role_id'=>888,
      ] );
     Session()->forget(['name','email','password','role_name','role_id']);
      return redirect('student/create');
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
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
        $classrooms = DB::table('classrooms')->where('school_id',session('school_id'))->get();
        $student = Student::findOrFail($id);
        return view('student.edit_student', compact('student', 'classrooms' ));
    }

    
    public function Studentupdate(Request $request, int $id)
    {
    $request->validate([
        'first_name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        // 'email' => 'required|email|max:255',
        'enrollment_date' => 'required|date',
        'birth_date' => 'required|date',
        'gender' => 'required|in:0,1',
        'parent_phone_number' => 'required|string|max:11|regex:/^\d+$/',
        'father_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'classroom' => 'required|integer',
    ]);

    $student = Student::findOrFail($id);
    $student->first_name = $request->first_name;
    $student->surname = $request->surname;
    $student->email = $request->email;
    $student->enrollment_date = $request->enrollment_date;
    $student->birth_date = $request->birth_date;
    $student->gender = $request->gender;
    $student->parent_phone_number = $request->parent_phone_number;
    $student->father_name = $request->father_name;
    $student->address = $request->address;
    $student->classroom_id = $request->classroom;
    $student->password = $request->password;

    $student->save();

    return redirect('/student/manage')->with('success', 'Student updated successfully.');
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
            Student::destroy($id);
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
        return redirect('/student/manage');
    }

    //Todo: Marge generateTeacherNumber with generateStudentNumber to be one generic function.
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


    public function Student_login(Request $request){
        if ($request->isMethod('post')) {
            $data = [
                'email' => $request->email,
                'password' => $request->password,
                // 'school'=>$request->school_name,
                // 'phone_number'=>$request->phone_number
            ];

            

            $user = User::where('email', $request->email)->where('role_id', '6')->first();
            $remember = $request->has('remember') ? true : false;
            if (Auth::attempt($data, $remember)) {
                // if (Auth::user()->user_type == "") {
                //     Auth::logout();
                //     return redirect('admin_login')->with('error', "'You'r not a Authenticated person");
                // }
                return redirect('stu/student_dashboard')->with('msg', 'Successfully login');
            } else {
                if ($user) {
                    return redirect('stu/login')->with('error', 'Please Check Email ID and Password');
                } else {
                    return redirect('stu/login')->with('error', 'Email not found');
                }
            }

        } else{
            return view('studentFlow.login');
        }
    }

    public function Student_registration(Request $request){
        if($request->isMethod("post")){
           dd($request);
            $data=$request->all();
           $data=User::create([  
            'name'=>$request->name,
            'email'=>$request->email,
            // 'phone_number'=>bcrypt($request->school_number),
            // 'password'=>$request->password,
            'password' => bcrypt($request->password),
            // 'school_name'=>$request->school_name,
            'soft_login'=>$request->soft,
            'role_id'=>$request->role,
            'school'=>$request->school
        ]);
        return redirect('login')->with('msg','Register Susscessfully');
        }else{
            return view('studentFlow.registration');
         }
    }

    public function student_dashboard(){
        return view('studentFlow.dashboard');
    }

    public function addcsvview(){
        $classrooms = DB::table('classrooms')->where('school_id',session('school_id'))->get();
        return view('student.addbulkdata', compact('classrooms'));
    }


        public function uploadExcel(Request $request)
        {
        $request->validate([
            'excelFile' => 'required|file|mimes:xlsx,xls',
            'classroom' => 'required|exists:classrooms,id',
        ]);
    

        $file = $request->file('excelFile');
        $classroomId = $request->input('classroom');
        $schoolId = Auth::user()->id;

        try {
            Excel::import(new StudentsImport($classroomId, $schoolId), $file);
            return redirect()->back()->with('success', 'Students uploaded successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            return redirect()->back()->withErrors($errorMessages);
        }
    }
}