<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;



class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    //  public function credentials(Request $request){

    //         $login = $request->input('login');
            
    //         // Check if the input is a valid email address
    //         if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
    //             return [
    //                 'email' => $login,
    //                 'password' => $request->input('password'),
    //             ];
    //         }
            
    //         // Check if the input is a valid 10-digit numeric mobile number
    //         if (preg_match('/^\d{10}$/', $login)) {
    //             return [
    //                 'mobile_no' => $login,
    //                 'password' => $request->input('password'),
    //             ];
    //         }
            
    //         // If neither email nor mobile number, return an error
    //         return [
    //             'invalid' => true,
    //         ];
    //     }

    public function authenticate(Request $request)
    {
        $credentials = $this->credentials($request);

        if (isset($credentials['invalid'])) {
            return back()->withErrors([
                'login' => 'Please provide a valid email address or a 10-digit mobile number.',
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'login' => 'These credentials do not match our records.',
        ]);
    }

    public function rules()
    {
        return [
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }


    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */


     // this code for role check
   public function store(LoginRequest $request)
   {
    $teacher_id = '';
    $login = $request->input('login');
    $password = $request->input('password');

    $credentials = [
        'password' => $password,
    ];

    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $credentials['email'] = $login;
    } elseif (preg_match('/^\d{10}$/', $login)) {
        $credentials['phone_number'] = $login;
    } else {
        return back()->withErrors([
            'login' => 'Please provide a valid email address or a 10-digit mobile number.',
        ]);
    }
    $user_data = null;
    $teacher = null;

    if (isset($credentials['email'])) {
        $user_data = User::where('email', $credentials['email'])->first();
        $teacher = Teacher::where('email', $credentials['email'])->first();
    }

    if (isset($credentials['phone_number'])) {
        $user_data = $user_data ?? User::where('phone_number', $credentials['phone_number'])->first();
        $teacher = $teacher ?? Teacher::where('phone_number', $credentials['phone_number'])->first();
    }

    if ($teacher) {
        session(['teacher_id' => $teacher->id]);
        // session(['school_id' => $teacher->school_id]);
    }

    if ($user_data) {
        session(['role_id' => $user_data->role_id]);
    }

    if ($user_data) {
    if ($user_data->soft_login==1) {
        session(['role_id' => $user_data->role_id]);
    } else {
        return back()->withErrors([
            'login' => 'this Account is Deactivate. Please contact the Site and its administrator.',
        ]);
    }
 }

 
// Rest of your code


    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if ($user_data && $user_data->role_id == 2) {
          session(['school_id' => $teacher->school_id]);
            return redirect()->route('teacher_dashboard');
        } elseif ($user_data && $user_data->role_id == 1) {
      
            session(['school_id' => $user_data->id]);
            return redirect()->intended(RouteServiceProvider::HOME);
        } else if ($user_data && $user_data->role_id == 3){
            return redirect()->route('manager.user');
        } else if ($user_data && $user_data->role_id==0)
        {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }


    return back()->withErrors([
        'login' => 'These credentials do not match our records.',
    ]);
}


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
