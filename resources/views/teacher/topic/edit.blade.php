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
                            <h4 class="card-title">Edit Topic</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ route('topic.update', $topic->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Topic Title</label>
                                            <input type="search" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Search Topic" value="{{ $topic->course_title }}"
                                                style="border-radius:5px;" required>
                                            @error('course_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom" class="col-form-label">Class</label>
                                            <select id="classroom_edit_topic" name="classroom"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $topic->classroom) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden="">
                                            <select id="subject_edit_topic" name="subject"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                            $('#subject_edit_topic').empty();
                            $('#subject_edit_topic').append('<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_topic').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_topic').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_topic').empty();
                    $('#subject_edit_topic').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_topic').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_topic').val() != '0') {
                fetchSubjects($('#classroom_edit_topic').val(), '{{ $topic->subject ?? '' }}');
            }
        });
    </script>
@endsection
