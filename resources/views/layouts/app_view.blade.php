<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('/vendors/base/vendor.bundle.base.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('intl_tel_input/css/intlTelInput.css') }}"> -->

    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo me-5" href=""><img
                        src="{{ asset('/images/smart_vidharti_logo.png') }}" class="me-2"alt="logo"
                        style="height: 54px; width:61px;" /></a>
                <a class="navbar-brand brand-logo-mini" href="/"><img
                        src="{{ asset('/images/smart_vidharti_logo.png') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="ti-view-list"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    {{--                <li class="nav-item nav-search d-none d-lg-block">
                    <div class="input-group">
                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                 <i class="ti-search"></i>
                </span>
                        </div>
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                               aria-label="search" aria-describedby="search">
                    </div>
                </li> --}}
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    {{--                <li class="nav-item dropdown me-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                       id="messageDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="ti-email mx-0"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">David Grey
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    The meeting is cancelled
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">Tim Cook
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    New product launch
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal"> Johnson
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    Upcoming board meeting
                                </p>
                            </div>
                        </a>
                    </div>
                </li> --}}
                    {{--                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                       data-bs-toggle="dropdown">
                        <i class="ti-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                         aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-success">
                                    <i class="ti-info-alt mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Application Error</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Just now
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-warning">
                                    <i class="ti-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Settings</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Private message
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-info">
                                    <i class="ti-user mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">New user registration</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    2 days ago
                                </p>
                            </div>
                        </a>
                    </div>
                </li> --}}
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                            id="profileDropdown">
                            Hi! {{ auth()->user()->name }}
                            <img src="{{ url('/images/' . auth()->user()->photo_path) }}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="route('logout')"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    <i class="ti-power-off">
                                        {{ __('Log Out') }}</i>
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="ti-view-list"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar" style="border-Right: 3px solid #e8e7ec;">
                <ul class="nav">
                    <li class="nav-item">
                        @if (session()->get('role_id') == 1)
                            <a class="nav-link" href="/">
                                <i class="ti-shield menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        @elseif(session()->get('role_id') == 2)
                            <a class="nav-link" href="/teacher/teacher_dashboard">
                                <i class="ti-shield menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        @else
                            <a class="nav-link" href="/">
                                <i class="ti-shield menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        @endif
                    </li>
                    @if (session()->get('role_id') == 1)
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-classroom" aria-expanded="false"
                                aria-controls="ui-classroom">
                                <i class="ti-menu-alt menu-icon"></i>
                                <span class="menu-title">Class Management </span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-classroom">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="/classroom/create">Add new
                                            classroom</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="/classroom">Manage Classrooms</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-teacher" aria-expanded="false"
                                aria-controls="ui-teacher">
                                <i class="ti-briefcase menu-icon"></i>
                                <span class="menu-title">Teachers Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-teacher">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="/teacher/create">Add Teacher</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/teacher">Manage Teachers</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-teacher" aria-expanded="false"
                                aria-controls="ui-teacher">
                                <i class="ti-briefcase menu-icon"></i>
                                <span class="menu-title">Student Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-teacher">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="{{ url('student/create') }}">Add
                                            Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('student/manage') }}">Manage Students</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/student/add-csv-data"> Add Bulk
                                            Student</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-subject" aria-expanded="false"
                                aria-controls="ui-subject">
                                <i class="ti-ruler-pencil menu-icon"></i>
                                <span class="menu-title">Subjects Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-subject">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="/subject/create">Add Subject</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="/subject">Manage Subjects</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-courses" aria-expanded="false"
                                aria-controls="users">
                                <i class="ti-pencil-alt menu-icon"></i>
                                <span class="menu-title">Content Management</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-courses">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"><a class="nav-link" href="/courses/create"> Add new
                                            Content</a></li>
                                    <li class="nav-item"><a class="nav-link" href="/courses/manage"> Manage
                                            Content</a>
                                    </li>
                                    {{-- <li class="nav-item"><a class="nav-link" href="/courses/requested_course"> Requested Content</a> --}}
                        </li>

                        <li class="nav-item"><a class="nav-link" href="/courses/videomanager"> Requested Content</a>
                        </li>

                </ul>
        </div>
        </li>




        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#liveclass-manage" aria-expanded="false"
                aria-controls="users">
                <i class="ti-pencil-alt menu-icon"></i>
                <span class="menu-title">LiveClass Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="liveclass-manage">
                <ul class="nav flex-column sub-menu">

                    <li class="nav-item"><a class="nav-link" href="/courses/liveclass-manager"> Manage
                            Liveclass</a>
                    </li>

        </li>


        </ul>
    </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-report" aria-expanded="false"
            aria-controls="users">
            <i class="ti-pencil-alt menu-icon"></i>
            <span class="menu-title">Report Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-report">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="/classroom/report"> Report</a>
                </li>
    </li>

    </ul>
    </div>
    </li>
    @endif
    @if (session()->get('role_id') == 2)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-Request" aria-expanded="false"
                aria-controls="users">
                <i class="ti-pencil-alt menu-icon"></i>
                <span class="menu-title">Content Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-Request">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/teacher/request_course">Upload URL</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/add_video"> Request Content(Video &
                            Files)</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" href="/teacher/add_diksh"> Request Diksh</a></li>
                            <li class="nav-item"><a class="nav-link" href="/teacher/add_game"> Request Game</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage"> My Content(URL)</a>
                    <li class="nav-item"><a class="nav-link" href="/teacher/video">My Content(Video & Files)</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/class_link">Live Class</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage-live-class">Manage Live
                            Class</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/add_game"> Educational Games</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage_game">Manage Games</a></li>
        </li>
        </ul>
        </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#topic-Request" aria-expanded="false"
                aria-controls="users">
                <i class="ti-pencil-alt menu-icon"></i>
                <span class="menu-title">Topic Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="topic-Request">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/teacher/add-topic">Add Topic</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage-topic">Manage Topic</a></li>
        </li>
        </ul>
        </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#sub-topic-Request" aria-expanded="false"
                aria-controls="users">
                <i class="ti-pencil-alt menu-icon"></i>
                <span class="menu-title">Sub Topic Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sub-topic-Request">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/teacher/add-sub-topic">Add Sub Topic</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage-subtopic">Manage Sub Topic</a>
                    </li>
        </li>
        </ul>
        </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#Homework-Request" aria-expanded="false"
                aria-controls="users">
                <i class="ti-pencil-alt menu-icon"></i>
                <span class="menu-title">Homeworks</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="Homework-Request">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/teacher/add-homework">Add Homework</a></li>
                    <li class="nav-item"><a class="nav-link" href="/teacher/manage-homework">Manage Homework</a></li>
        </li>
        </ul>
        </div>
        </li>
    @endif
    @if (session()->get('role_id') == 0)
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="false"
                aria-controls="users">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">School Management</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/manager/create"> Add School </a></li>
                    <li class="nav-item"><a class="nav-link" href="/manager"> Manage Schools </a>
                    </li>
                </ul>
            </div>
        </li>
    @endif
    </ul>
    </nav>
    <!-- partial -->

    @yield('content')

    <!-- main-panel ends -->

    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- partial:partials/footer -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright &copy; SmartVidyarthi
                {{ date('Y') }}. Designed & Developed by <a href='https://innologic.in' style="color: green;"
                    target="blank">Innologic Lab</a></span>

        </div>
    </footer>
    <!-- partial -->


    <script type="text/javascript">
        $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {
                if (imgPreviewPlaceholder.files) {
                    imgPreviewPlaceholder.files.clear();
                }
                if (input.files) {
                    var filesAmount = input.files.length;
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function(event) {
                            var $clone = $($.parseHTML('<img>'));
                            $clone.attr('class', 'image_pr');
                            $clone.attr('style', 'max-width: 200px;');
                            $clone.attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }
                        reader.readAsDataURL(input.files[i]);

                    }
                }
            };
            $('#images').on('change', function() {
                multiImgPreview(this, 'div.preview-image');
            });
            $('#photo').on('change', function() {
                // To delete the uploaded photo from preview after selecting new photo
                var arr = document.getElementsByClassName('image_pr');
                if (arr.length) {
                    for (var i = 0; i < arr.length; i++) {
                        arr[i].remove();
                    }
                }
                multiImgPreview(this, 'div.preview-image');
            });
        });
    </script>

    <!-- <script src="{{ asset('intl_tel_input/js/intlTelInput.js') }}"></script>
    <script>
        var input = document.querySelector("#contact");
        window.intlTelInput(input, {
            hiddenInput: "full_phone",
            nationalMode: false,
            placeholderNumberType: "",
            preferredCountries: ['in'],
            separateDialCode: true,
            utilsScript: "{{ asset('intl_tel_input/js/utils.js') }}"
        });
    </script> -->
    <!-- plugins:js -->

    <script src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" type="text/javascript">
    </script>

    <!-- Custom js for dashboard-->
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <!-- End custom js for dashboard-->



</body>

</html>
