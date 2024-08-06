<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddcoursesController extends Controller
{
    

     public function testapi(Request $request){
      
    //  return( $request->classroom_id);->where('teacher_id',$teachers->id)
    $teachers=DB::table('teachers')->where('user_id',Auth::user()->id)->first();
      $subjects = Subject::where('teacher_id',$teachers->id)->get();
       return response()->json($subjects);
        
    }

    public function deactivateSchool(Request $request)
    {
    $school_id = $request->input('id');
    $soft_login = $request->input('soft_login');

    $user = User::find($school_id);
    if ($user) {
        $user->soft_login = $soft_login;
        $user->save();
    }

    $teachers = Teacher::where('school_id', '=', $school_id)->get();
    if ($teachers->isNotEmpty()) {
        foreach ($teachers as $teacher) {
            $user_id = $teacher->user_id;
            $user_table = User::find($user_id);
            if ($user_table) {
                $user_table->soft_login = $soft_login;
                $user_table->save();
            }
        }
    }
    return response()->json(['message' => 'change updated successfully'], 200);
}


}