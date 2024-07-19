@extends('stu_compo.main')

@section('main-container')
    <div class="container">
        <aside>
            <div class="profile">
                <div class="top">
                    <div class="profile-photo">
                        <img src="{{ asset('student/images/profile-1.jpeg') }}" alt="">
                    </div>
                    <div class="info">
                        <h3>User ID</h3> {{ Session('email') }}
                        <!-- Button to open the change password modal -->
                        <button type="button" class="btn btn-primary mt-2">
                            <a href="{{ route('student.changePassword') }}" class="text-white text-decoration-none">Change
                                Password</a>
                        </button>
                    </div>
                </div>
                <div class="about">
                </div>
            </div>
        </aside>

        <main>
            <h1>Attendance</h1>

            <div class="subjects">
                <div class="eg">
                    <span class="material-icons-sharp">architecture</span>
                    <a href="{{ url('studentFlow/games') }}">
                        <h3>Educational Games</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>

                <div class="mth">
                    <span class="material-icons-sharp">functions</span>
                    <a href="{{ url('studentFlow/diksha') }}">
                        <h3>Diksha Portal</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <div class="cs">
                    <span class="material-icons-sharp">computer</span>
                    <a href="{{ url('studentFlow/video') }}">
                        <h3>Video Link</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <div class="cg">
                    <span class="material-icons-sharp">dns</span>
                    <a href="{{ url('studentFlow/course') }}">
                        <h3>Course Materials</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <div class="net">
                    <span class="material-icons-sharp">router</span>
                    <a href="{{ url('studentFlow/class') }}">
                        <h3>Live Class</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
                <div class="net">
                    <span class="material-icons-sharp">dns</span>
                    <a href="{{ url('studentFlow/homeworks') }}">
                        <h3>Home Works</h3>
                    </a>
                    <small class="text-muted">Last 24 Hours</small>
                </div>
            </div>
        </main>

        <div class="right">
            <div class="announcements1">
                <h2>
                    Announcements
                    <span id="notification-count" class="notification-count"
                        style="cursor: pointer;">{{ $notificationCount }}</span>
                </h2>
                <div class="updates" style="display: none;" id="updates">
                    <ul>
                        @foreach ($notifications as $notification)
                            <li>
                                <a href="{{ $notification->notification_url }}" class="notification-link"
                                    data-id="{{ $notification->id }}" target="_self">{{ $notification->description }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        .right {
            /* Add any specific styling for the right section */
        }

        .announcements1 {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .notification-count {
            color: #007bff;
            /* Change this color as needed */
            font-weight: bold;
            margin-left: 10px;
        }

        .updates {
            margin-top: 10px;
        }

        .updates ul {
            list-style-type: none;
            padding: 0;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.notification-link').on('click', function(e) {
                // Prevent default behavior
                e.preventDefault();

                // Get the notification ID from data attribute
                const notificationId = $(this).data('id');

                $.ajax({
                    url: '/studentFlow/seen_notification/' + notificationId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('Notification marked as seen:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error marking notification as seen:', error);
                    }
                });
            });

            const notificationCount = $('#notification-count');
            const updates = $('#updates');

            notificationCount.on('click', function() {
                updates.toggle();
            });
        });
    </script>
@endsection
