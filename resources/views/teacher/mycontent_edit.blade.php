@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($subject) ? 'Edit' : 'Add New' }} Requested Content
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}</h4>
                            <p class="card-description">
                            </p>
                            <form class="forms-sample" action="{{ route('mycontent.update', $mycontent->id) }}"
                                method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="course_title" class="col-form-label"
                                                style="margin-bottom: 0;">Course Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                value="{{ $mycontent->course_title }}" placeholder="Course Title"
                                                style="margin-top: 0;" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="classroom" class="col-form-label"
                                                style="margin-bottom: 0;">Class</label>
                                            <select id="classroom_edit_upload_url" name="classroom"
                                                class="form-control form-control-sm" style="margin-top: 0;" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $mycontent->classroom_id) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="subject_name" class="col-form-label"
                                                style="margin-bottom: 0;">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="subject_edit_upload_url" name="subject_name"
                                                class="form-control form-control-sm" style="margin-top: 0;" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="topic_id" class="col-form-label"
                                                style="margin-bottom: 0;">Topic</label>
                                            <select id="edit_topic_id_upload_url" name="topic_id"
                                                class="form-control form-control-sm" style="margin-top: 0;" required>
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="subtopic_id" class="col-form-label" style="margin-bottom: 0;">Sub
                                                Topic</label>
                                            <select id="edit_upload_url_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" style="margin-top: 0;" required>
                                                <option value="">Select Sub Topic</option>
                                                @foreach ($subtopics as $subtopic)
                                                    <option value="{{ $subtopic->id }}"
                                                        {{ $subtopic->id == $mycontent->subtopic_id ? 'selected' : '' }}>
                                                        {{ $subtopic->sub_topic_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="url" class="col-form-label"
                                                style="margin-bottom: 0;">URL</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                                value="{{ $mycontent->url }}" style="margin-top: 0;" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group" style="display: flex; flex-direction: column;">
                                            <label for="description" class="col-form-label"
                                                style="margin-bottom: 0;">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" style="margin-top: 0;" required>{{ $mycontent->description }}</textarea>
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
            function fetchSubjects(classroomId, selectedSubjectId = null) {
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#subject_edit_upload_url').empty();
                            $('#subject_edit_upload_url').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_upload_url').append('<option value="' + key +
                                    '">' +
                                    value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_upload_url').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_upload_url').empty();
                    $('#subject_edit_upload_url').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_upload_url').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_upload_url').val() != '0') {
                fetchSubjects($('#classroom_edit_upload_url').val(), '{{ $mycontent->subject_code ?? '' }}');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var existingClassroomId = {{ $mycontent->classroom_id }};
            var existingSubjectId = "{{ $mycontent->subject_code }}";
            var existingTopicId = {{ $mycontent->topic_id }};

            function fetchTopics(classroomId, subjectId) {
                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_topic_id_upload_url').empty();
                            $('#edit_topic_id_upload_url').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_topic_id_upload_url').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_topic_id_upload_url').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#edit_topic_id_upload_url').empty();
                    $('#edit_topic_id_upload_url').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#subject_edit_upload_url').change(function() {
                var subjectId = $(this).val();
                var classroomId = $('#classroom_edit_upload_url').val();
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
            // var existingClassroomId = {{ $mycontent->classroom_id }};
            var existingSubjectId = "{{ $mycontent->subject_code }}";
            var existingTopicId = {{ $mycontent->topic_id }};

            function fetchSubTopics(topicId, subjectId) {
                if (topicId != '0' && subjectId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#edit_uploar_url__subtopic_id').empty();
                            $('#edit_uploar_url__subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_uploar_url__subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_uploar_url__subtopic_id').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#edit_uploar_url__subtopic_id').empty();
                    $('#edit_uploar_url__subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#edit_topic_id_upload_url').change(function() {
                var topicId = $(this).val();
                var subjectId = $('#subject_edit_upload_url').val();
                fetchSubTopics(topicId, subjectId);
            });

            if (existingTopicId && existingSubjectId) {
                fetchSubTopics(existingTopicId, existingSubjectId);
            }
        });
    </script>
@endsection
