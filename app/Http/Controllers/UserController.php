<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberParseException;

class UserController extends Controller
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
     $school_role_id='1';
     $search = $request->input('search');
     $query = User::where('role_id',$school_role_id);

     if(!empty($search))
     {
        $query->where(function($q) use ($search){
            $q->where('name','like',"%{$search}%")
            ->orWhere('email','like',"%{$search}%");
        });
     }
     $managers= $query->paginate(10);
    return view('user.index', compact('managers'));
    }



    public function create()
    {
        return view('user.view');
    }

    public function store(Request $request)
    {
        try {
            $role_id_school = 1;
            $soft_login = 1;  // 1 for soft login active 

            DB::transaction(function () use ($request, $role_id_school, $soft_login) {
                $user = new User();
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->photo_path = 'users/blank-profile.png';
                $user->phone_number = $request->input('phone_number');
                $user->role_id = $role_id_school;
                $user->soft_login = $soft_login;
                $user->save();
            });

            return redirect('/manager')->with('success', 'A New manager Added Successfully.');
        } catch (\Exception $exception) {
            return redirect('/subject/create')->withErrors($exception->getMessage());
        }
    }



    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // dd($id);
      $user=User::findOrFail($id);
      //dd($user);
      return  view('user.edituser',['user'=>$user]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // dd($request);
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->phone_number=$request->phone_number;
        $user->save();
       // dd($user);
       return  redirect('/manager')->with('success', 'A Subject Updated Successfully.');;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        //Don't delete your self.
        if (auth()->user()->id!=$id){
            try {
                User::destroy($id);
            } catch (\Exception $exception){
                echo $exception->getMessage();
            }
        }

        return redirect('/manager');
    }
}