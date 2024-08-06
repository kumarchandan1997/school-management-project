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
                            <form class="forms-sample" action="{{ route('update_courses', $courses->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype">Content Type</label>
                                            <select id="Editcoursetype" name="coursetype"
                                                class="form-control form-control-sm" required
                                                onchange="toggleSectionsEdit()">
                                                <option value="">Select Content Type</option>
                                                <option value="PDF"
                                                    {{ isset($courses) && $courses->courses_type == 'PDF' ? 'selected' : '' }}>
                                                    PDF</option>
                                                <option value="Video"
                                                    {{ isset($courses) && $courses->courses_type == 'Video' ? 'selected' : '' }}>
                                                    Video</option>
                                                <option value="Url"
                                                    {{ isset($courses) && $courses->courses_type == 'Url' ? 'selected' : '' }}>
                                                    Url</option>
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

                                            <!-- Section to show existing file -->
                                            <div id="existingFileSection"
                                                class="{{ isset($courses) && ($courses->courses_type == 'PDF' || $courses->courses_type == 'Video') && $courses->pdf_video ? '' : 'd-none' }}">
                                                <p>Current File: <a href="{{ $courses->pdf_video }}"
                                                        target="_blank">{{ $courses->pdf_video }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}
                                <div class="row">
                                    <div id="urlSectionEdit" class="row d-none">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="url">URL</label>
                                                <input type="text" class="form-control" name="url"
                                                    value="{{ $courses->url ?? old('url') }}" id="url">
                                                @error('url')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                                <a class="btn btn-light" href="">Cancel</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            toggleSectionsEdit(); // Call initially to set the correct state
        });

        function toggleSectionsEdit() {
            const coursetype = document.getElementById('Editcoursetype').value;
            const fileUploadSection = document.getElementById('fileUploadSection');
            const urlSection = document.getElementById('urlSectionEdit');

            if (coursetype === 'PDF' || coursetype === 'Video') {
                fileUploadSection.classList.remove('d-none');
                urlSection.classList.add('d-none');
            } else if (coursetype === 'Url') {
                fileUploadSection.classList.add('d-none');
                urlSection.classList.remove('d-none');
            } else {
                fileUploadSection.classList.add('d-none');
                urlSection.classList.add('d-none');
            }
        }
    </script>
@endsection
