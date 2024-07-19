@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($subject) ? 'Edit' : 'Add New' }} Requested Content
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/add_video') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="video_classroom_id" name="classroom_id"
                                                class="form-control form-control-sm" data-dependent='classroom_id' required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_name" class="col-form-label">Subject111</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="selectedVideoSubject" name="subject_name"
                                                class="form-control form-control-sm" required>
                                                {{-- <option value="">Select subject</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype" class="col-form-label">Courses Type</label>
                                            <select id="coursetype" name="coursetype" class="form-control form-control-sm"
                                                onchange="showFileTypeIcon()" required>
                                                <option value="">Select a course type</option>
                                                <option value="PDF">PDF & Files</option>
                                                <option value="Video">Video</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Content Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Course Title" value=""
                                                style="border-radius:5px;" required>
                                            <span id="fileTypeIcon" style="display:none;">
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                            </span>
                                            <input type="file" id="fileInput" name="video" accept=""
                                                style="display:none;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="video_topic_id" class="col-form-label">Topic</label>
                                            <select id="video_topic_id" name="topic_id" class="form-control form-control-sm"
                                                required>
                                                <option value="0">Select a Topic</option>
                                                <!-- Topics will be populated via AJAX -->
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="video_subtopic_id" class="col-form-label">Sub Topic</label>
                                            <select id="video_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select Topic</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function showFileTypeIcon() {
                                        var selectBox = document.getElementById("coursetype");
                                        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
                                        var fileTypeIcon = document.getElementById("fileTypeIcon");
                                        var fileInput = document.getElementById("fileInput");

                                        if (selectedValue === "PDF") {
                                            fileTypeIcon.style.display = "inline-block";
                                            fileInput.style.display = "inline-block";
                                            fileInput.setAttribute("accept", ".pdf,.doc,.docx");
                                        } else if (selectedValue === "Video") {
                                            fileTypeIcon.style.display = "inline-block";
                                            fileInput.style.display = "inline-block";
                                            fileInput.setAttribute("accept", "video/*");
                                        } else {
                                            fileTypeIcon.style.display = "none";
                                            fileInput.style.display = "none";
                                            fileInput.removeAttribute("accept");
                                        }
                                    }
                                </script>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="myTextarea" class="col-form-label">Description</label>
                                            <textarea class="form-control" name="description" id="myTextarea" rows="3" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/subject">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#classroom").change(function() {
                $('#selectedData').empty(); // Clear previous options
                var selectedClassroomId = $(this).val();

                $.ajax({
                    url: "/teacher/test/test",
                    method: "POST",
                    data: {
                        'classroom_id': selectedClassroomId,
                        '_token': '{{ csrf_token() }}' // Add CSRF token
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        data.forEach(function(item) {
                            $('#selectedData').append($('<option>', {
                                value: item.subject_code,
                                text: item.name
                            }));
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#video_classroom_id').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#selectedVideoSubject').empty();
                            $('#selectedVideoSubject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selectedVideoSubject').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selectedVideoSubject').empty();
                    $('#selectedVideoSubject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectedVideoSubject').change(function() {
                var subjectId = $(this).val();

                var classroomId = $('#video_classroom_id').val();

                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#video_topic_id').empty();
                            $('#video_topic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#video_topic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#video_topic_id').empty();
                    $('#video_topic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#video_topic_id').change(function() {
                var topicId = $(this).val();

                var subjectId = $('#selectedVideoSubject').val();

                if (subjectId != '0' && topicId != '0') {
                    console.log("Both topicId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#video_subtopic_id').empty();
                            $('#video_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#video_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#video_subtopic_id').empty();
                    $('#video_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>
@endsection
