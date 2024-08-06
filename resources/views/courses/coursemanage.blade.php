@extends('layouts.app_view')

@section('content')
    <style>
        .video-container {
            max-width: 320px;
            max-height: 240px;
            overflow: hidden;
        }

        .video-container video {
            width: 100%;
            height: auto;
        }

        .icon-container img {
            width: 50px;
            height: 50px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table td,
        .table th {
            white-space: nowrap;
        }
    </style>
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/courses/manage') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by courses title,subject name ,code & classroom...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/courses/manage') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Content Table</h4>
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses_detail as $key => $course)
                                            <tr>
                                                <td class="py-1">
                                                    {{ $course->course_title }}
                                                </td>
                                                <td>
                                                    {{ $subject_names[$key] }}
                                                </td>
                                                <td>
                                                    {{ $course->subject_code }}
                                                </td>
                                                <td>
                                                    {{ $classroom_names[$key] }}
                                                </td>
                                                <td class="icon-container">
                                                    @if ($course->courses_type === 'Video' || $course->courses_type === 'Url')
                                                        <img src="https://www.shutterstock.com/image-vector/play-button-icon-vector-illustration-260nw-1697833306.jpg"
                                                            alt="Video Icon">
                                                    @elseif ($course->courses_type === 'PDF')
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                                                            alt="PDF Icon">
                                                    @endif
                                                </td>
                                                <td class="course_link">
                                                    @if ($course->courses_type == 'Video')
                                                        <div class="video-container">
                                                            <video controls>
                                                                <source src="{{ $course->pdf_video }}" type="video/mp4">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    @else
                                                        <a class="link_achar"
                                                            href="{{ $course->courses_type == 'PDF' ? $course->pdf_video : $course->url }}">
                                                            Open
                                                        </a>
                                                    @endif
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-info ti-share btn-rounded"
                                                        data-toggle="modal"
                                                        data-target="#AdminContentModal{{ $course->id }}">
                                                        Share
                                                    </button>
                                                    <div class="btn-group">
                                                        <form action="/courses/edit_course/{{ $course->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/courses/delete/{{ $course->id }}" method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
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
                                {!! $courses_detail->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

    {{-- model code  --}}
    <!-- Modal for sharing content -->
    @foreach ($courses_detail as $course)
        <div class="modal fade" id="AdminContentModal{{ $course->id }}" tabindex="-1" role="dialog"
            aria-labelledby="ContentModalLabel{{ $course->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ContentModalLabel{{ $course->id }}">Share Content</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="share-content-form" data-course-id="{{ $course->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="classroom-select-{{ $course->id }}">Select Classroom</label>
                                <select class="form-control" id="classroom-select-{{ $course->id }}" name="classroom_id">
                                    <option value="">Select a Classroom</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="search-students-{{ $course->id }}">Select Students</label>
                                <input type="text" class="form-control" id="search-students-{{ $course->id }}"
                                    placeholder="Search students by full name">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all-{{ $course->id }}">
                                    <label class="form-check-label" for="select-all-{{ $course->id }}">Select All</label>
                                </div>
                                <div class="row" id="student-list-{{ $course->id }}">
                                    <!-- Students will be populated here based on selected classroom and search query -->
                                </div>
                                <div id="no-students-message-{{ $course->id }}" class="mt-2" style="display: none;">
                                    <p>No students available for the selected classroom.</p>
                                </div>
                                <div id="no-classroom-message-{{ $course->id }}" class="mt-2" style="display: none;">
                                    <p>No classroom available.</p>
                                </div>
                            </div>

                            <!-- Add a description textarea -->
                            <div class="form-group mt-3">
                                <label for="description-{{ $course->id }}">Description</label>
                                <textarea class="form-control" id="description-{{ $course->id }}" name="description" rows="3"
                                    placeholder="Add a description"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Share</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach




    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch and display students based on selected classroom and search query
            function fetchStudents(classroomId, query, modalId) {
                $.ajax({
                    url: '/courses/path-to-fetch-students',
                    method: 'GET',
                    data: {
                        classroom_id: classroomId,
                        query: query
                    },
                    success: function(response) {
                        const studentList = $(`#student-list-${modalId}`);
                        const noStudentsMessage = $(`#no-students-message-${modalId}`);
                        const noClassroomMessage = $(`#no-classroom-message-${modalId}`);
                        studentList.empty();

                        if (response.students.length > 0) {
                            noStudentsMessage.hide();
                            response.students.forEach(student => {
                                const studentItem = `
                            <div class="col-6 student-item">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="student-${student.id}-${modalId}" name="student_ids[]" value="${student.id}">
                                    <label class="form-check-label" for="student-${student.id}-${modalId}">${student.name}</label>
                                </div>
                            </div>
                        `;
                                studentList.append(studentItem);
                            });
                        } else {
                            noStudentsMessage.show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching students:', error);
                    }
                });
            }

            // Handle classroom selection change
            $(document).on('change', '[id^=classroom-select-]', function() {
                const classroomId = $(this).val();
                const modalId = $(this).attr('id').split('-').pop();
                const searchQuery = $(`#search-students-${modalId}`).val();
                const noClassroomMessage = $(`#no-classroom-message-${modalId}`);

                if (classroomId) {
                    noClassroomMessage.hide();
                    fetchStudents(classroomId, searchQuery, modalId);
                } else {
                    $(`#student-list-${modalId}`).empty();
                    noClassroomMessage.show();
                }
            });

            // Handle student search input
            $(document).on('keyup', '[id^=search-students-]', function() {
                const searchQuery = $(this).val();
                const modalId = $(this).attr('id').split('-').pop();
                const classroomId = $(`#classroom-select-${modalId}`).val();

                if (classroomId) {
                    fetchStudents(classroomId, searchQuery, modalId);
                }
            });

            // Handle select all checkbox
            $(document).on('change', '[id^=select-all-]', function() {
                const modalId = $(this).attr('id').split('-').pop();
                const isChecked = $(this).is(':checked');
                $(`#student-list-${modalId} .form-check-input`).prop('checked', isChecked);
            });

            // Handle form submission
            $(document).on('submit', '.share-content-form', function(e) {
                e.preventDefault();

                const form = $(this);
                const courseId = form.data('course-id');
                const formData = new FormData(this);

                $.ajax({
                    url: `/courses/share-content/${courseId}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Content shared successfully!');
                            $(`#AdminContentModal${courseId}`).modal('hide');
                            location.reload();
                        } else {
                            alert('An error occurred while sharing content.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sharing content:', error);
                        alert('An error occurred while sharing content.');
                    }
                });
            });
        });
    </script>



    {{-- model code end  --}}
@endsection
