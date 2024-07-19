@extends('layouts.auth_app')
@section('content')
<div class="auth-form-transparent text-left p-3">
    <div class="brand-logo">
         <div class="row" style="display:flex;justify-content:center">
            <div class="col-lg-4">
                <img src="{{asset('/images/smart_vidharti_logo.png')}}" alt="logo"/>
            </div>
        </div>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <h4>Welcome back!</h4>
    <h6 class="font-weight-light">Happy to see you again!</h6>
    <form class="pt-3" method="POST" action="{{ url('stu/registration') }}">
        @csrf
        <div class="form-group">
            <label for="exampleInputLogin">Name</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-user text-primary"></i>
                      </span>
                </div>
                <input type="text" name="name" class="form-control form-control-lg border-left-0" id="login" required autofocus placeholder="Enter Your Full Name">
            </div>
        </div>

        {{-- <div class="form-group">
            <label for="exampleInputLogin">School Phone number</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-user text-primary"></i>
                      </span>
                </div>
                <input type="text" name="school_number" class="form-control form-control-lg border-left-0" id="login" required autofocus placeholder="Email or MobileNo.">
            </div>
        </div> --}}


        <div class="form-group">
            <label for="exampleInputLogin">Email | Phone No.</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-user text-primary"></i>
                      </span>
                </div>
                <input type="email" name="email" class="form-control form-control-lg border-left-0" id="login" required autofocus placeholder="Email or MobileNo.">
            </div>
        </div>


        <div class="form-group">
            <label for="exampleInputPassword">Password</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                </div>
                <input type="password" class="form-control form-control-lg border-left-0"
                       name="password"
                       required autocomplete="current-password"
                       id="password" placeholder="Password">
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword">School Name</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                </div>
                <input type="password" class="form-control form-control-lg border-left-0"
                       name="password"
                       required autocomplete="current-password"
                       id="password" placeholder="school">
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword"></label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                </div>
                <input type="password" class="form-control form-control-lg border-left-0"
                       name="role_id" hidden value="6"
                       required autocomplete="current-password"
                       id="password" placeholder="Password">
            </div>
        </div>

        <div class="form-group">
            <label for="exampleInputPassword"></label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                </div>
                <input type="password" class="form-control form-control-lg border-left-0"
                       name="soft" hidden value="1"
                       required autocomplete="current-password"
                       id="password" placeholder="Password">
            </div>
        </div>

        {{-- <div class="form-group">
            <label for="exampleInputPassword">School Name</label>
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="ti-lock text-primary"></i>
                      </span>
                </div>
                <input type="text" class="form-control form-control-lg border-left-0"
                       name="school_name"
                       required autocomplete="current-password"
                        placeholder="Password">
            </div>
        </div> --}}

        <div class="my-2 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <label class="form-check-label text-muted">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    {{ __('Remember me') }}
                </label>
            </div>
            @if (Route::has('password.request'))
                <!-- <a class="auth-link text-black" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a> -->
            @endif
        </div>
        <div class="my-3">
            <button class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" type="submit">{{ __('Log in') }}</button>
        </div>
        {{--<div class="mb-2 d-flex">
            <button type="button" class="btn btn-facebook auth-form-btn flex-grow me-1">
                <i class="ti-facebook me-2"></i>Facebook
            </button>
            <button type="button" class="btn btn-google auth-form-btn flex-grow ms-1">
                <i class="ti-google me-2"></i>Google
            </button>
        </div>--}}
{{--        <div class="text-center mt-4 font-weight-light">
            Don't have an account? <a href="{{route('/register')}}" class="text-primary">Create</a>
        </div>--}}
    </form>
</div>
@endsection
