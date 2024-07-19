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
                            <h4 class="card-title">Add Sub Topic</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ route('subtopic.save') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subtopic_classroom" class="col-form-label">Class</label>
                                            <select id="subtopic_classroom" name="classroom_id"
                                                class="form-control form-control-sm" data-dependent="subject" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subtopic_subject" class="col-form-label">Subject</label>
                                            <select id="subtopic_subject" name="subject_id"
                                                class="form-control form-control-sm" data-dependent="topic" required>
                                                <option value="0">Select a Subject</option>
                                                <!-- Subjects will be populated via AJAX -->
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="create_topic_id" class="col-form-label">Topic</label>
                                            <select id="create_topic_id" name="topic_id"
                                                class="form-control form-control-sm" required>
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
                                            <!-- Empty column for alignment -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sub_topic_name" class="col-form-label">Add Sub Topic</label>
                                            <input type="text" class="form-control" name="sub_topic_name"
                                                id="sub_topic_name" required="">
                                            @error('sub_topic_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                            $('#topic-availability').text('Topic already exists').css('color',
                                'red').show();
                        } else {
                            $('#topic-availability').text('Topic available').css('color',
                                'green').show();
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#subtopic_classroom').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#subtopic_subject').empty();
                            $('#subtopic_subject').append(
                                '<option value="0">Select a Subject</option>');
                            $.each(data, function(key, value) {
                                $('#subtopic_subject').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#subtopic_subject').empty();
                    $('#subtopic_subject').append('<option value="0">Select a Subject</option>');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#subtopic_subject').change(function() {
                var subjectId = $(this).val();

                var classroomId = $('#subtopic_classroom').val();

                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#create_topic_id').empty();
                            $('#create_topic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#create_topic_id').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#create_topic_id').empty();
                    $('#create_topic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>
@endsection
