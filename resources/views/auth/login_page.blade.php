<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login Page</title>
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .btn-animate {
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn-animate:hover {
            transform: scale(1.1);
        }

        .btn-admin {
            background-color: #1088f7;
            border: none;
            width: 100%;
            font-size: 1.5rem;
            padding: 1rem;
        }

        .btn-teacher {
            background-color: #f69414;
            border: none;
            width: 100%;
            font-size: 1.5rem;
            padding: 1rem;
        }

        .btn-student {
            background-color: #12ee42;
            border: none;
            width: 100%;
            font-size: 1.5rem;
            padding: 1rem;
        }
    </style>
</head>

<body>

    <!-- Section: Design Block -->
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('images/login_image.png') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 d-flex flex-column align-items-center">
                    <a href="/login" class="btn btn-admin btn-animate mb-3" data-mdb-ripple-init>Admin Login</a>

                    <a href="/login" class="btn btn-teacher btn-animate mb-3" data-mdb-ripple-init>Teacher
                        Login</a>
                    <a href="/studentFlow/login" class="btn btn-student btn-animate mb-3" data-mdb-ripple-init>Student
                        Login</a>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2024. All rights reserved by DKDMinfotech.com
            </div>
            <!-- Copyright -->
        </div>
    </section>

    <!-- Add Font Awesome icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/cbe897d4cf.js" crossorigin="anonymous"></script>
</body>

</html>
