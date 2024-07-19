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
                            <h4 class="card-title">Add Topic</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ route('topic.save') }}" method="post">
                                @csrf

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Topic Title</label>
                                            <input type="search" class="form-control" name="course_title" id="course_title"
                                                autofocus="" placeholder="search Topic" value=""
                                                style="border-radius:5px;" required="">
                                            @error('course_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label id="topic-availability" class="col-form-label"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom" class="col-form-label">Class</label>
                                            <select id="topic_classroom" name="classroom"
                                                class="form-control form-control-sm" data-dependent='subject' required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden="">
                                            <select id="selectedtopicSubject" name="subject"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                            </select>
                                            @error('subject')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/teacher/add-topic">Cancel</a>
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
            $('#topic_classroom').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#selectedtopicSubject').empty();
                            $('#selectedtopicSubject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selectedtopicSubject').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selectedtopicSubject').empty();
                    $('#selectedtopicSubject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>
@endsection
