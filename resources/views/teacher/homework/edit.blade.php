@extends('layouts.app_view')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
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
                            <h4 class="card-title">Edit Homework</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('/teacher/update_homework', $homework->id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="homework_title" class="col-form-label">Title</label>
                                            <input type="text" class="form-control" name="homework_title"
                                                id="homework_title" placeholder="Homework Title"
                                                value="{{ old('homework_title', $homework->homework_title) }}" required>
                                            @error('homework_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="classroom_edit_homework" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $homework->classroom_id) selected @endif>
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
                                            <select id="subject_edit_homework" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select subject</option>
                                                <!-- Subjects will be populated here via AJAX -->
                                            </select>
                                            @error('subject_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_id" class="col-form-label">Approve Content</label>
                                            <select id="content_id" name="content_id"
                                                class="form-control form-control-sm select2" required>
                                                <option value="">Select an option</option>
                                                @foreach ($content as $option)
                                                    <option value="{{ $option->id }}"
                                                        {{ $homework->content_id == $option->id ? 'selected' : '' }}>
                                                        {{ $option->course_title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('content_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="homework_file" class="col-form-label">Add Homework</label>
                                            <input type="file" id="homework_file" name="homework_file"
                                                accept=".pdf,.doc,.docx" style="display: inline-block;">
                                            @if ($homework->homework_file)
                                                <p>Current file: <a
                                                        href="{{ asset('storage/' . $homework->homework_file) }}"
                                                        target="_blank">View</a></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="col-form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Add a description">{{ $homework->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Update</button>
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
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#subject_edit_homework').empty();
                            $('#subject_edit_homework').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_homework').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_homework').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_homework').empty();
                    $('#subject_edit_homework').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_homework').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_homework').val() != '0') {
                fetchSubjects($('#classroom_edit_homework').val(), '{{ $homework->subject_code ?? '' }}');
            }
        });
    </script>
@endsection
