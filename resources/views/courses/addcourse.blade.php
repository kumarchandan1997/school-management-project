@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($course) ? 'Edit' : 'Add New' }} Content
                                {{ isset($course) ? 'with The Number: ' . $course->subject_code : '' }}</h4>
                            <form class="forms-sample"
                                action="{{ isset($course) ? '/courses/update/' . $course->id : route('storecourses') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title">Content Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Content Title"
                                                value="{{ isset($course) ? $course->course_title : old('course_title') }}"
                                                style="border-radius:5px;" required>
                                            @error('course_title')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id">Class</label>
                                            <select id="content_admin_classroom_id" name="classroom_id"
                                                class="form-control form-control-sm" data-dependent='classroom_id' required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                            @error('classroom_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_name">Subject</label>
                                            <select id="selected_content_Subject" name="subject_name"
                                                class="form-control form-control-sm" required>
                                            </select>
                                            @error('subject_name')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype">Content Type</label>
                                            <select id="coursetype" name="coursetype" class="form-control form-control-sm"
                                                required onchange="toggleSections()">
                                                <option value="">Select Content Type</option>
                                                <option value="PDF">PDF</option>
                                                <option value="Video">Video</option>
                                                <option value="Url">Url</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="fileUploadSection" class="row d-none">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pdf_video">Upload File</label>
                                            <input type="file" class="form-control" name="pdf_video" id="pdf_video">
                                            @error('pdf_video')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div id="urlSection" class="row d-none">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="url">URL</label>
                                            <input type="text" class="form-control" name="url"
                                                value="{{ isset($course) ? $course->url : old('url') }}" id="url">
                                            @error('url')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" required>{{ isset($course) ? $course->description : old('description') }}</textarea>
                                            @error('description')
                                                <div class="alert alert-danger">{{ $message }}</div>
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
            $('#content_admin_classroom_id').change(function() {
                var classroomId = $(this).val();
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
                            console.log(data);
                            $('#selected_content_Subject').empty();
                            $('#selected_content_Subject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selected_content_Subject').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#selected_content_Subject').empty();
                    $('#selected_content_Subject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selected_content_Subject').change(function() {
                var subjectId = $(this).val();

                var classroomId = $('#content_admin_classroom_id').val();

                if (subjectId != '0' && classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#content_admin_topic_id').empty();
                            $('#content_admin_topic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#content_admin_topic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#content_admin_topic_id').empty();
                    $('#content_admin_topic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#content_admin_topic_id').change(function() {
                var topicId = $(this).val();

                var subjectId = $('#selected_content_Subject').val();

                if (subjectId != '0' && topicId != '0') {
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#content_admin_subtopic_id').empty();
                            $('#content_admin_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#content_admin_subtopic_id').append(
                                    '<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#content_admin_subtopic_id').empty();
                    $('#content_admin_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });


        function toggleSections() {
            const coursetype = document.getElementById('coursetype').value;
            const fileUploadSection = document.getElementById('fileUploadSection');
            const urlSection = document.getElementById('urlSection');
            const urlInput = document.getElementById('url');
            const fileInput = document.getElementById('pdf_video');

            if (coursetype === 'PDF' || coursetype === 'Video') {
                fileUploadSection.classList.remove('d-none');
                fileInput.required = true;
                urlSection.classList.add('d-none');
                urlInput.required = false;
            } else if (coursetype === 'Url') {
                fileUploadSection.classList.add('d-none');
                fileInput.required = false;
                urlSection.classList.remove('d-none');
                urlInput.required = true;
            } else {
                fileUploadSection.classList.add('d-none');
                fileInput.required = false;
                urlSection.classList.add('d-none');
                urlInput.required = false;
            }
        }

        document.addEventListener('DOMContentLoaded', (event) => {
            toggleSections();
        });
    </script>
@endsection
