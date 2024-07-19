@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        @php
            use Carbon\Carbon;
        @endphp
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ isset($subject) ? 'Edit' : 'Add New' }} Live Class
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}
                            </h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/class_link') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="classroom_edit_live_class" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $liveClass->class_room) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_code" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_code" value="subject_code" hidden="">
                                            <select id="subject_edit_live_class" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id" class="col-form-label">Topic</label>
                                            <select id="edit_topic_id_live_class" name="topic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="live_class_subtopic_id" class="col-form-label">Sub Topic</label>
                                            <select id="live_class_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="class_link" class="col-form-label">Meeting Link</label>
                                            <input type="text" class="form-control" name="class_link" id="class_link"
                                                value="{{ $liveClass->class }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="class_time" class="col-form-label">From Meeting Time</label>
                                            <input type="datetime-local" class="form-control" name="class_time"
                                                id="class_time"
                                                value="{{ Carbon::parse($liveClass->class_time)->format('Y-m-d\TH:i') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="to_meeting_time" class="col-form-label">To Meeting Time</label>
                                            <input type="datetime-local" class="form-control" name="to_meeting_time"
                                                id="to_meeting_time"
                                                value="{{ Carbon::parse($liveClass->to_meeting_time)->format('Y-m-d\TH:i') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Get the current date and time
                                    const currentDateTime = new Date();
                                    const currentYear = currentDateTime.getFullYear();
                                    const currentMonth = (currentDateTime.getMonth() + 1).toString().padStart(2, '0');
                                    const currentDay = currentDateTime.getDate().toString().padStart(2, '0');
                                    const currentHour = currentDateTime.getHours().toString().padStart(2, '0');
                                    const currentMinute = currentDateTime.getMinutes().toString().padStart(2, '0');

                                    // Set the minimum value for the datetime-local input to the current date and time
                                    const minDateTime = `${currentYear}-${currentMonth}-${currentDay}T${currentHour}:${currentMinute}`;
                                    document.getElementById("class_time").setAttribute("min", minDateTime);
                                </script>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note" class="col-form-label">Note:</label>
                                            <input type="text" class="form-control" name="note" id="note"
                                                value="{{ $liveClass->note }}" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                {{-- <a class="btn btn-light" href="/subject">Cancel</a> --}}
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
                console.log(selectedSubjectId);
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#subject_edit_live_class').empty();
                            $('#subject_edit_live_class').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_live_class').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_live_class').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_live_class').empty();
                    $('#subject_edit_live_class').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_live_class').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_live_class').val() != '0') {
                fetchSubjects($('#classroom_edit_live_class').val(), '{{ $liveClass->subject_code ?? '' }}');
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            var existingClassroomId = {{ $liveClass->class_room }};
            var existingSubjectId = "{{ $liveClass->subject_code }}";
            var existingTopicId = {{ $liveClass->topic_id }};

            function fetchTopics(classroomId, subjectId) {
                if (subjectId != '0' && classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_topic_id_live_class').empty();
                            $('#edit_topic_id_live_class').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_topic_id_live_class').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_topic_id_live_class').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#edit_topic_id_live_class').empty();
                    $('#edit_topic_id_live_class').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#subject_edit_live_class').change(function() {
                var subjectId = $(this).val();
                var classroomId = $('#classroom_edit_live_class').val();
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
            var existingSubjectId = "{{ $liveClass->subject_code }}";
            var existingTopicId = {{ $liveClass->topic_id }};

            function fetchSubTopics(topicId, subjectId) {
                if (topicId != '0' && subjectId != '0') {
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#live_class_subtopic_id').empty();
                            $('#live_class_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#live_class_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#live_class_subtopic_id').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    $('#live_class_subtopic_id').empty();
                    $('#live_class_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#edit_topic_id_live_class').change(function() {
                var topicId = $(this).val();
                var subjectId = $('#subject_edit_live_class').val();
                fetchSubTopics(topicId, subjectId);
            });

            if (existingTopicId && existingSubjectId) {
                fetchSubTopics(existingTopicId, existingSubjectId);
            }
        });
    </script>
@endsection
