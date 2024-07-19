@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ isset($subject) ? 'Edit' : 'Add New' }} Requested Content
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}
                            </h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/add_video_update/' . $data->id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Course Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                placeholder="Course Title" value="{{ $data->course_title }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="classroom_edit_video" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $data->classroom_id) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_code" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_code" value="subject_code" hidden>
                                            <select id="subject_edit_video_upload" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype" class="col-form-label">Courses Type</label>
                                            <select id="coursetype" name="coursetype" class="form-control form-control-sm"
                                                required>
                                                <option value="">Select a courses type</option>
                                                <option value="PDF" id="option1">PDF</option>
                                                <option value="Video" id="option2">Video</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <video width="150" height="200" controls>
                                    <source src="{{ asset('videos/' . $data->video) }}" type="video/mp4">
                                </video>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="video" class="col-form-label">Video</label>
                                            <input type="file" class="form-control" name="video" id="video"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id" class="col-form-label">Topic</label>
                                            <select id="edit_topic_id_video" name="topic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subtopic_id" class="col-form-label">Sub Topic</label>
                                            <select id="subtopic_id" name="subtopic_id" class="form-control form-control-sm"
                                                required>
                                                <option value="">Select Sub Topic</option>
                                                @foreach ($subtopics as $topic)
                                                    <option value="{{ $topic->id }}"
                                                        {{ $data->subtopic_id == $topic->id ? 'selected' : '' }}>
                                                        {{ $topic->sub_topic_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="game" class="col-form-label">Games</label>
                                            <input type="text" class="form-control" name="game" id="game"
                                                value="{{ $data->games }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="diksha" class="col-form-label">Diksh</label>
                                            <input type="text" class="form-control" name="diksha" id="diksha"
                                                value="{{ $data->diksh }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="col-form-label">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" required>{{ $data->description }}</textarea>
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
    {{-- <script>
        var selected = document.getElementById('selectedData');

        selected.disabled = true;

        $(document).ready(function() {
            $("#classroom").change(function() {
                selected.innerHTML = '';


                var selectedClassroomId = $(this).val();
                selected.disabled = false;


                $.ajax({
                    url: "{{ env('APP_URL') }}" + "/api/test",
                    method: "POST",
                    data: {
                        'classroom_id': selectedClassroomId
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        allOptions = '';
                        data.forEach(function(item) {
                            console.log(item.name);
                            let newOption = document.createElement('option');
                            newOption.innerText = item.name;
                            newOption.value = item.subject_code;
                            console.log(newOption.value)
                            //console.log(newOption);
                            selected.appendChild(newOption);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            function fetchSubjects(classroomId, selectedSubjectId = null) {
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#subject_edit_video_upload').empty();
                            $('#subject_edit_video_upload').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_video_upload').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_video_upload').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_video_upload').empty();
                    $('#subject_edit_video_upload').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_video').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_video').val() != '0') {
                console.log("chandan");
                fetchSubjects($('#classroom_edit_video').val(), '{{ $data->subject_code ?? '' }}');
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            var existingClassroomId = {{ $data->classroom_id }};
            var existingSubjectId = "{{ $data->subject_code }}";
            var existingTopicId = {{ $data->topic_id }};

            function fetchTopics(classroomId, subjectId) {
                if (subjectId != '0' && classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_topic_id_video').empty();
                            $('#edit_topic_id_video').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_topic_id_video').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_topic_id_video').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#edit_topic_id_video').empty();
                    $('#edit_topic_id_video').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#subject_edit_video_upload').change(function() {
                var subjectId = $(this).val();
                var classroomId = $('#classroom_edit_video').val();
                fetchTopics(classroomId, subjectId);
            });

            // Trigger topic fetching on page load if both classroom and subject are already selected
            if (existingClassroomId && existingSubjectId) {
                fetchTopics(existingClassroomId, existingSubjectId);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var existingSubjectId = "{{ $data->subject_code }}";
            var existingTopicId = {{ $data->topic_id }};

            function fetchSubTopics(topicId, subjectId) {
                if (topicId != '0' && subjectId != '0') {
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_video_subtopic_id').empty();
                            $('#edit_video_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_video_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_video_subtopic_id').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#edit_video_subtopic_id').empty();
                    $('#edit_video_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#edit_topic_id_video').change(function() {
                var topicId = $(this).val();
                var subjectId = $('#subject_edit_video_upload').val();
                fetchSubTopics(topicId, subjectId);
            });

            if (existingTopicId && existingSubjectId) {
                fetchSubTopics(existingTopicId, existingSubjectId);
            }
        });
    </script>
@endsection
