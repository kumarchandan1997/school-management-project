@extends('layouts.app_view');

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($courses) ? 'Edit' : 'Add New' }} Content
                                {{ isset($courses) ? 'with The Number: ' . $courses->subject_code : '' }}</h4>
                            <form class="forms-sample"
                                action="{{ isset($courses) ? route('updatecourses', $courses->id) : route('storecourses') }}"
                                method="post">
                                @csrf
                                @if (isset($courses))
                                    @method('POST')
                                @endif
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title">Content Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Content Title" value="{{ $courses->course_title }}"
                                                style="border-radius:5px;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id">Class</label>
                                            <select id="classroom_edit_admin_content" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Classroom</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $courses->classroom_id) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedData">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="subject_edit_content_admin" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id">Topic</label>
                                            <select id="edit_topic_id_admin_content" name="topic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="teacher">Sub Topic</label>
                                            <select id="admin_content_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype">Content Type</label>
                                            <select id="coursetype" name="coursetype" class="form-control form-control-sm"
                                                required>
                                                @if (isset($course->courses_type))
                                                    @if ($course->courses_type == 'PDF')
                                                        <option value="PDF" selected>PDF</option>
                                                        <option value="Video">Video</option>
                                                    @else
                                                        <option value="Video" selected>Video</option>
                                                        <option value="PDF">PDF</option>
                                                    @endif
                                                @else
                                                    <option value="">Select Content Type</option>
                                                    <option value="PDF" id="option1">PDF</option>
                                                    <option value="Video" id="option1">Video</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="url">URL</label>
                                            @if (isset($course))
                                                <input type="text" class="form-control" name="url"
                                                    value="{{ $courses->url }}" id="url" required>
                                            @else
                                                <input type="text" class="form-control" name="url"
                                                    value="{{ $courses->url }}" id="url" required>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="myTextarea">Description</label>
                                            <textarea class="form-control" name="description" id="myTextarea" rows="3" required>
                                        {{ $courses->description }}
                                    </textarea>
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
            function fetchSubjects(classroomId, selectedSubjectId = null) {
                var type_user = 'admin';

                var url =
                    '{{ route('get.subjects', ['classroomId' => 'CLASSROOM_ID', 'type' => 'TYPE_USER']) }}';

                url = url.replace('CLASSROOM_ID', encodeURIComponent(classroomId));

                if (type_user) {
                    url = url.replace('TYPE_USER', encodeURIComponent(type_user));
                } else {
                    url = url.replace('/TYPE_USER', '');
                }

                if (classroomId != '0') {
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(data) {
                            $('#subject_edit_content_admin').empty();
                            $('#subject_edit_content_admin').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_content_admin').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_content_admin').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_content_admin').empty();
                    $('#subject_edit_content_admin').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_admin_content').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_admin_content').val() != '0') {
                fetchSubjects($('#classroom_edit_admin_content').val(), '{{ $courses->subject_code ?? '' }}');
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            var existingClassroomId = {{ $courses->classroom_id }};
            var existingSubjectId = "{{ $courses->subject_code }}";
            var existingTopicId = {{ $courses->topic_id }};

            function fetchTopics(classroomId, subjectId) {
                if (subjectId != '0' && classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_topic_id_admin_content').empty();
                            $('#edit_topic_id_admin_content').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_topic_id_admin_content').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_topic_id_admin_content').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#edit_topic_id_admin_content').empty();
                    $('#edit_topic_id_admin_content').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#subject_edit_content_admin').change(function() {
                var subjectId = $(this).val();
                var classroomId = $('#classroom_edit_admin_content').val();
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
            var existingSubjectId = "{{ $courses->subject_code }}";
            var existingTopicId = {{ $courses->topic_id }};

            function fetchSubTopics(topicId, subjectId) {
                if (topicId != '0' && subjectId != '0') {
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#admin_content_subtopic_id').empty();
                            $('#admin_content_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#admin_content_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#admin_content_subtopic_id').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#admin_content_subtopic_id').empty();
                    $('#admin_content_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#edit_topic_id_admin_content').change(function() {
                var topicId = $(this).val();
                var subjectId = $('#subject_edit_content_admin').val();
                fetchSubTopics(topicId, subjectId);
            });

            if (existingTopicId && existingSubjectId) {
                fetchSubTopics(existingTopicId, existingSubjectId);
            }
        });
    </script>

@endsection
