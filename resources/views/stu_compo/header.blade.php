
<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="shortcut icon" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('student/style.css') }}">
    <link rel="stylesheet" href="{{ asset('student/parsley/parsleycss.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

</head>
<body>
    @if ($message = Session::get('msg'))
    <input type="hidden" name="msg" id="msg" value="{{$message}}">
    @endif
    @if ($message = Session::get('error'))
    <input type="hidden" name="error" id="error" value="{{$message}}">
    @endif
    <header>
        <div class="logo" title="University Management System">
            <img src="{{ asset('student/images/profile-1.jpeg') }}" alt="">
            <h2>Smart Vidhyarthi</h2>
        </div>
        <div class="navbar">
            <a href="{{ url('studentFlow/index') }}" class="active">
                <span class="material-icons-sharp">home</span>
                <h3>Home</h3>
            </a>
            {{-- <a href="{{ url('studentFlow/timetable') }}" onclick="timeTableAll()">
                <span class="material-icons-sharp">today</span>
                <h3>Time Table</h3>
            </a>  --}}
            {{-- <a href="{{ url('studentFlow/exam') }}">
                <span class="material-icons-sharp">grid_view</span>
                <h3>Examination</h3>
            </a> --}}
            {{-- <a href="{{ url('studentFlow/password') }}">
                <span class="material-icons-sharp">password</span>
                <h3>Change Password</h3>
            </a> --}}
            <a href="{{ url('studentFlow/logout') }}"onclick="{{ url('studentFlow/logout') }}" >
                <span class="material-icons-sharp" onclick="{{ url('studentFlow/logout') }}">logout</span>
                <h3>Logout</h3>
            </a>
        </div>
        <div id="profile-btn">
            <span class="material-icons-sharp">person</span>
        </div>
        <div class="theme-toggler">
            <span class="material-icons-sharp active">light_mode</span>
            <span class="material-icons-sharp">dark_mode</span>
        </div>        
    </header>