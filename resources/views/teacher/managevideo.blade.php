@extends('layouts.app_view')

@section('content')
    <div class="main-panel">
        <!-- Container for PDF iframe -->
        <div id="pdfContainer" style="display: none; width: 100%; height: 100%; position: relative;">
            <iframe id="pdfFrame" style="width: 100%; height: calc(100% - 50px);"></iframe>
            <button class="btn btn-danger" onclick="closePDF()" style="position: absolute; bottom: 620px; right: 203px;">Close
                PDF</button>
        </div>


        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/video') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by content name....">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/video') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <h4 class="card-title">My Content</h4>

            <!-- Display videos -->
            <div id="tableContainer" class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Classroom</th>
                            <th>Subject Name</th>
                            <th>Contant title</th>
                            <th>Topic</th>
                            <th>Sub Topic</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($videos as $video)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    @if ($video->classroom_id == 1)
                                        Nursary
                                    @elseif($video->classroom_id == 2)
                                        Class 2
                                    @elseif($video->classroom_id == 3)
                                        Class 3
                                    @elseif($video->classroom_id == 4)
                                        Class 4
                                    @elseif($video->classroom_id == 5)
                                        Class 5
                                    @elseif($video->classroom_id == 6)
                                        Class 6
                                    @elseif($video->classroom_id == 7)
                                        Class 7
                                    @elseif($video->classroom_id == 8)
                                        Class 8
                                    @elseif($video->classroom_id == 9)
                                        Class 9
                                    @elseif($video->classroom_id == 10)
                                        Class 10
                                    @else
                                        Next 10 class
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $data = DB::table('subjects')
                                            ->where('subject_code', $video->subject_code)
                                            ->first();
                                    @endphp
                                    {{ $data->name }}
                                </td>
                                <td>{{ $video->course_title }}</td>
                                <td>{{ $video->topic_name }}</td>
                                <td>{{ $video->subtopic_name }}</td>
                                <td>
                                    @php
                                        $extension = pathinfo($video->video, PATHINFO_EXTENSION);
                                    @endphp

                                    @if ($extension === 'mp4' || $extension === 'webm' || $extension === 'ogg')
                                        <video width="150" height="200" controls>
                                            <source src="{{ asset('videos/' . $video->video) }}"
                                                type="video/{{ $extension }}">
                                        </video>
                                    @else
                                        @if ($video->status !== 'Pending')
                                            <a href="#"
                                                onclick="openAndTrackPDF('{{ asset('videos/' . $video->video) }}', '{{ $video->id }}', event)"
                                                class="video-pdf-link" data-id="{{ $video->id }}">
                                        @endif
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100"
                                            height="100" viewBox="0 0 48 48">
                                            <path fill="#90CAF9" d="M40 45L8 45 8 3 30 3 40 13z"></path>
                                            <path fill="#E1F5FE" d="M38.5 14L29 14 29 4.5z"></path>
                                            <path fill="#1976D2"
                                                d="M16 21H33V23H16zM16 25H29V27H16zM16 29H33V31H16zM16 33H29V35H16z"></path>
                                        </svg>
                                        @if ($video->status !== 'Pending')
                                            </a>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if ($video->status == 'Approve')
                                        <a href="" class="btn btn-success btn-rounded">Open..</a>
                                    @elseif ($video->status == 'Pending')
                                        <button class="btn btn-danger btn-rounded">{{ $video->status }}</button>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('teacher/video_delete/' . $video->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="{{ url('teacher/add_video_update/' . $video->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                            </path>
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button type="button" class="btn btn-info ti-share btn-rounded" data-toggle="modal"
                                        data-target="#ContentModal{{ $video->id }}">
                                        Share
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $videos->onEachSide(1)->links() }}
                <!-- Adjust the number in onEachSide() to set the number of pages to display on each side -->
            </div>
        </div>
    </div>



    {{-- model code  --}}
    @foreach ($videos as $video)
        <div class="modal fade" id="ContentModal{{ $video->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ContentModalLabel{{ $video->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ContentModalLabel{{ $video->id }}">Share Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/share_my_content/{{ $video->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-emails">Select Students</label>
                                <input type="text" class="form-control" id="search-students-{{ $video->id }}"
                                    placeholder="Search students by full name">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all-{{ $video->id }}">
                                    <label class="form-check-label" for="select-all-{{ $video->id }}">Select
                                        All</label>
                                </div>
                                <div class="row" id="student-list-{{ $video->id }}">
                                    @foreach ($students as $index => $student)
                                        @if ($index % 2 == 0)
                                            <div class="w-100"></div>
                                        @endif
                                        <div class="col-6 student-item" data-fullname="{{ $student->full_name }}">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input student-checkbox-{{ $video->id }}"
                                                    id="student-{{ $student->id }}-{{ $video->id }}"
                                                    name="student_ids[]" value="{{ $student->id }}">
                                                <label class="form-check-label"
                                                    for="student-{{ $student->id }}-{{ $video->id }}">{{ $student->full_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add a description textarea -->
                                <div class="form-group mt-3">
                                    <label for="description-{{ $video->id }}">Description</label>
                                    <textarea class="form-control" id="description-{{ $video->id }}" name="description" rows="3"
                                        placeholder="Add a description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Share</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- model code end  --}}

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($videos as $video)
                document.getElementById('search-students-{{ $video->id }}').addEventListener('keyup',
                    function() {
                        var searchQuery = this.value.toLowerCase();
                        var studentItems = document.querySelectorAll(
                            '#student-list-{{ $video->id }} .student-item');

                        studentItems.forEach(function(item) {
                            var fullName = item.getAttribute('data-fullname').toLowerCase();
                            if (fullName.includes(searchQuery)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });

                document.getElementById('select-all-{{ $video->id }}').addEventListener('change', function() {
                    var checkboxes = document.querySelectorAll(
                        '#student-list-{{ $video->id }} .student-item');
                    checkboxes.forEach(function(item) {
                        var checkbox = item.querySelector('.student-checkbox-{{ $video->id }}');
                        if (item.style.display !== 'none') {
                            checkbox.checked = document.getElementById(
                                'select-all-{{ $video->id }}').checked;
                        }
                    });
                });
            @endforeach
        });
    </script>

    <script>
        var openTime;

        function openAndTrackPDF(pdfPath, videoId, event) {
            event.preventDefault(); // Prevent the default link behavior
            openTime = new Date();
            console.log('PDF opened at:', openTime);

            // Hide all children of the main panel except the pdfContainer
            var mainPanel = document.querySelector('.main-panel');
            Array.from(mainPanel.children).forEach(child => {
                if (child.id !== 'pdfContainer') {
                    child.style.display = 'none';
                }
            });

            // Show the pdfContainer and load the PDF in iframe
            document.getElementById('pdfContainer').style.display = 'block';
            var pdfFrame = document.getElementById('pdfFrame');
            pdfFrame.src = pdfPath;

            // Store video ID in a global variable
            window.currentVideoId = videoId;
        }

        function closePDF() {
            var closeTime = new Date();
            console.log('PDF closed at:', closeTime);

            var timeDifference = closeTime - openTime; // time difference in milliseconds
            var timeDifferenceInMinutes = timeDifference / 1000 / 60; // convert to minutes
            console.log('PDF was open for:', timeDifferenceInMinutes.toFixed(2), 'minutes');

            // Format dates and times
            var openTimeFormatted = formatDateTime(openTime);
            var closeTimeFormatted = formatDateTime(closeTime);

            // AJAX call to store the open, close times and interval
            var videoId = window.currentVideoId; // Get the current video ID

            fetch('/teacher/store-video-log', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for Laravel
                    },
                    body: JSON.stringify({
                        video_id: videoId,
                        open_time: openTimeFormatted,
                        close_time: closeTimeFormatted,
                        interval: timeDifferenceInMinutes.toFixed(2)
                    })
                })
                .then(response => {
                    if (response.ok) {
                        console.log('PDF log stored successfully');
                    } else {
                        console.error('Failed to store PDF log');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            var mainPanel = document.querySelector('.main-panel');
            Array.from(mainPanel.children).forEach(child => {
                if (child.id !== 'pdfContainer') {
                    child.style.display = '';
                }
            });

            document.getElementById('pdfContainer').style.display = 'none';
        }

        // Function to format date and time
        function formatDateTime(date) {
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            }) + ' ' + date.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            });
        }
    </script>
@endsection
