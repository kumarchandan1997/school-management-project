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
                                method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title">Content Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Content Title"
                                                value="{{ isset($course) ? $course->course_title : old('course_title') }}"
                                                style="border-radius:5px;" required>
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
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="selectedData">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="selected_content_Subject" name="subject_name"
                                                class="form-control form-control-sm" required>
                                                {{-- <option value="">Select subject</option> --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id">Topic</label>
                                            <select id="content_admin_topic_id" name="topic_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Topic</option>
                                                <!-- Topics will be populated via AJAX -->
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
                                            <select id="content_admin_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select Topic</option>
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
                                                    value="{{ isset($course) ? $course->url : old('url') }}" id="url"
                                                    required>
                                            @else
                                                <input type="text" class="form-control" name="url" value=""
                                                    id="url" required>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="myTextarea">Description</label>
                                            <textarea class="form-control" name="description" id="myTextarea" rows="3" required>
                                        {{ isset($course) ? $course->description : old('description') }}
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
        var selected = document.getElementById('selectedData');

        selected.disabled = false;
        // console.log(selected);
        $(document).ready(function() {
            $("#classroom").change(function() {
                selected.innerHTML = '';

                //  selected.selectedIndex = -1;
                var selectedClassroomId = $(this).val();
                selected.disabled = false;


                $.ajax({
                    url: "{{ env('APP_URL') }}" + "/api/test",
                    method: "POST",
                    data: {
                        'classroom_id': selectedClassroomId
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        allOptions = '';
                        data.forEach(function(item) {
                            console.log(item.name);
                            let newOption = document.createElement('option');
                            newOption.innerText = item.name;
                            newOption.value = item.subject_code;
                            console.log(newOption.value)
                            //console.log(newOption);
                            selected.appendChild(newOption);
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
    </script>

@endsection
