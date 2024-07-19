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
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ route('store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label"
                                                style="margin-bottom: 0;">Course Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Course Title" value=""
                                                style="border-radius:5px; margin-top: 0;" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom" class="col-form-label"
                                                style="margin-bottom: 0;">Class</label>
                                            <select id="Upload_url_classroom" name="classroom"
                                                class="form-control form-control-sm" data-dependent='subject' required
                                                style="margin-top: 0;">
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedurlSubject" class="col-form-label"
                                                style="margin-bottom: 0;">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="selectedurlSubject" name="subject"
                                                class="form-control form-control-sm" required style="margin-top: 0;">
                                                <option value="">Select subject</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="upload_url_topic_id" class="col-form-label"
                                                style="margin-bottom: 0;">Topic</label>
                                            <select id="upload_url_topic_id" name="topic_id"
                                                class="form-control form-control-sm" required style="margin-top: 0;">
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
                                            <label for="upload_url_subtopic_id" class="col-form-label"
                                                style="margin-bottom: 0;">Sub Topic</label>
                                            <select id="upload_url_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required style="margin-top: 0;">
                                                <option value="">Select Topic</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="url" class="col-form-label"
                                                style="margin-bottom: 0;">URL</label>
                                            <input type="text" class="form-control" name="url" id="url"
                                                required style="margin-top: 0;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="myTextarea" class="col-form-label"
                                                style="margin-bottom: 0;">Description</label>
                                            <textarea class="form-control" name="description" id="myTextarea" rows="3" required style="margin-top: 0;"></textarea>
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
            $('#Upload_url_classroom').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#selectedurlSubject').empty();
                            $('#selectedurlSubject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selectedurlSubject').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selectedurlSubject').empty();
                    $('#selectedurlSubject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectedurlSubject').change(function() {
                var subjectId = $(this).val();

                var classroomId = $('#Upload_url_classroom').val();

                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#upload_url_topic_id').empty();
                            $('#upload_url_topic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#upload_url_topic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#upload_url_topic_id').empty();
                    $('#upload_url_topic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#upload_url_topic_id').change(function() {
                var topicId = $(this).val();

                var subjectId = $('#selectedurlSubject').val();

                if (subjectId != '0' && topicId != '0') {
                    console.log("Both topicId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#upload_url_subtopic_id').empty();
                            $('#upload_url_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#upload_url_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#upload_url_subtopic_id').empty();
                    $('#upload_url_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>
@endsection
