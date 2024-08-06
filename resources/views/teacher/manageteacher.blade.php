@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My Content</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Content Title</th>
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>
                                            <th>Classroom</th>
                                            <th>Content Type</th>
                                            <th>Url</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requested_data as $key => $data)
                                            <tr>
                                                <td class="py-1">
                                                    {{ $data->course_title }}
                                                </td>
                                                <td>
                                                    {{ $subject_names[$key] }}
                                                </td>
                                                <td>
                                                    {{ $data->subject_code }}
                                                </td>
                                                <td>
                                                    {{ $classroom_names[$key] }}
                                                </td>

                                                @if ($data->courses_type == 'PDF')
                                                    <td class="course_type">
                                                        <i class="fa-solid fa-file-pdf"
                                                            style="font-size:30px; padding-left:30px;"></i>

                                                    </td>
                                                @else
                                                    <td class="course_type">
                                                        <i class="fa-solid fa-circle-play"
                                                            style="font-size:30px; padding-left:30px;"></i>

                                                    </td>
                                                @endif
                                                <td class="course_link">
                                                    @if ($data->status == 'Pending')
                                                        <span class="link_achar"
                                                            style="color: grey; cursor: not-allowed;">{{ $data->url }}</span>
                                                    @else
                                                        <a href="{{ $data->url }}" class="link_achar"
                                                            onclick="storeReport(event, {{ $data->id }}, '{{ $data->url }}')">{{ $data->url }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if ($data->status == 'Approve')
                                                            <button type="button"
                                                                class="btn btn-success  btn-rounded">Approve</button>
                                                        @elseif($data->status == 'Pending')
                                                            <button type="button"
                                                                class="btn btn-danger btn-rounded">{{ $data->status }}</button>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($data->status == 'Approve')
                                                        <button type="button" class="btn btn-info ti-share btn-rounded"
                                                            data-toggle="modal"
                                                            data-target="#shareModal{{ $data->id }}">
                                                            Share
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-info ti-share btn-rounded"
                                                            disabled>
                                                            Share
                                                        </button>
                                                    @endif
                                                    <div class="btn-group">
                                                        <form action="/teacher/my-content-edit/{{ $data->id }}"
                                                            method="get">
                                                            <input type="hidden" name="_token"
                                                                value="1mt7LYzRh8E4M4M62lCBO0X8h1ohN3VBNOw1THyW"> <button
                                                                type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/teacher/my-content-delete/{{ $data->id }}"
                                                            method="post">
                                                            <input type="hidden" name="_method" value="DELETE"> <input
                                                                type="hidden" name="_token"
                                                                value="1mt7LYzRh8E4M4M62lCBO0X8h1ohN3VBNOw1THyW"> <button
                                                                onclick="return confirm('Are you sure You want to delete this?')"
                                                                type="submit" class="btn btn-danger ti-trash btn-rounded">
                                                                Delete</button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $requested_data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

    {{-- model code  --}}
    @foreach ($requested_data as $data)
        <div class="modal fade" id="shareModal{{ $data->id }}" tabindex="-1" role="dialog"
            aria-labelledby="shareModalLabel{{ $data->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalLabel{{ $data->id }}">Share Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/upload_url_shares/{{ $data->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-emails">Select Students</label>
                                <input type="text" class="form-control" id="search-students-{{ $data->id }}"
                                    placeholder="Search students by full name">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all-{{ $data->id }}">
                                    <label class="form-check-label" for="select-all-{{ $data->id }}">Select All</label>
                                </div>
                                <div class="row" id="student-list-{{ $data->id }}">
                                    @foreach ($students as $index => $student)
                                        @if ($index % 2 == 0)
                                            <div class="w-100"></div>
                                        @endif
                                        <div class="col-6 student-item" data-fullname="{{ $student->full_name }}">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input student-checkbox-{{ $data->id }}"
                                                    id="student-{{ $student->id }}-{{ $data->id }}"
                                                    name="student_ids[]" value="{{ $student->id }}">
                                                <label class="form-check-label"
                                                    for="student-{{ $student->id }}-{{ $data->id }}">{{ $student->full_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add a description textarea -->
                                <div class="form-group mt-3">
                                    <label for="description-{{ $data->id }}">Description</label>
                                    <textarea class="form-control" id="description-{{ $data->id }}" name="description" rows="3"
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

    <script>
        function storeReport(event, videoId, url) {
            event.preventDefault();
            let openTime = new Date();
            let openTimeFormatted = formatDateTime(openTime);

            fetch('/teacher/store-video-log', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        video_id: videoId,
                        open_time: openTimeFormatted,
                        table_name: 'requests',
                    })
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Log stored successfully');
                        window.location.href = url;
                    } else {
                        console.error('Failed to store log');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
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




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($requested_data as $data)
                document.getElementById('search-students-{{ $data->id }}').addEventListener('keyup',
                    function() {
                        var searchQuery = this.value.toLowerCase();
                        var studentItems = document.querySelectorAll(
                            '#student-list-{{ $data->id }} .student-item');

                        studentItems.forEach(function(item) {
                            var fullName = item.getAttribute('data-fullname').toLowerCase();
                            if (fullName.includes(searchQuery)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });

                document.getElementById('select-all-{{ $data->id }}').addEventListener('change', function() {
                    var checkboxes = document.querySelectorAll(
                        '#student-list-{{ $data->id }} .student-item');
                    checkboxes.forEach(function(item) {
                        var checkbox = item.querySelector('.student-checkbox-{{ $data->id }}');
                        if (item.style.display !== 'none') {
                            checkbox.checked = document.getElementById(
                                'select-all-{{ $data->id }}').checked;
                        }
                    });
                });
            @endforeach
        });
    </script>
@endsection
