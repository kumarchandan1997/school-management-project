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
                            <h4 class="card-title">Edit Subtopic</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ route('subtopic.update', $subtopic->id) }}"
                                method="post">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="classroom_edit_subtopic" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $subtopic->classroom_id) selected @endif>
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
                                            <label for="subject_id" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_id" value="subject_id" hidden="">
                                            <select id="subject_edit_subtopic" name="subject_id"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id" class="col-form-label">Topic</label>
                                            <select id="edit_topic_id_in_subtopic" name="topic_id"
                                                class="form-control form-control-sm" required>
                                            </select>
                                            @error('topic_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sub_topic_name" class="col-form-label">Add Sub Topic</label>
                                            <input type="text" class="form-control" name="sub_topic_name"
                                                id="sub_topic_name" value="{{ $subtopic->sub_topic_name }}" required>
                                            @error('sub_topic_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Update</button>
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
            $('#course_title').on('input', function() {
                var courseTitle = $(this).val();

                $.ajax({
                    url: '{{ route('topic.check') }}',
                    type: 'GET',
                    data: {
                        course_title: courseTitle
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#edit-topic-availability').text('Topic already exists').css(
                                'color',
                                'red').show();
                        } else {
                            $('#edit-topic-availability').text('Topic available').css('color',
                                'green').show();
                        }
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
                            $('#subject_edit_subtopic').empty();
                            $('#subject_edit_subtopic').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_subtopic').append('<option value="' + key +
                                    '">' +
                                    value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_subtopic').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_subtopic').empty();
                    $('#subject_edit_subtopic').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_subtopic').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_subtopic').val() != '0') {
                fetchSubjects($('#classroom_edit_subtopic').val(), '{{ $subtopic->subject_id ?? '' }}');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            var existingClassroomId = {{ $subtopic->classroom_id }};
            var existingSubjectId = "{{ $subtopic->subject_id }}";
            var existingTopicId = {{ $subtopic->topic_id }};

            function fetchTopics(classroomId, subjectId) {
                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#edit_topic_id_in_subtopic').empty();
                            $('#edit_topic_id_in_subtopic').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#edit_topic_id_in_subtopic').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                            if (existingTopicId) {
                                $('#edit_topic_id_in_subtopic').val(existingTopicId);
                            }
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#edit_topic_id_in_subtopic').empty();
                    $('#edit_topic_id_in_subtopic').append('<option value="0">Select a Topic</option>');
                }
            }

            $('#subject_edit_subtopic').change(function() {
                var subjectId = $(this).val();
                var classroomId = $('#classroom_edit_subtopic').val();
                fetchTopics(classroomId, subjectId);
            });

            // Trigger topic fetching on page load if both classroom and subject are already selected
            if (existingClassroomId && existingSubjectId) {
                fetchTopics(existingClassroomId, existingSubjectId);
            }
        });
    </script>
@endsection
