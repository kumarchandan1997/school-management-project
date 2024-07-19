@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">
                                {{ isset($subject) ? 'Edit' : 'Add New' }} Requested Content
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}
                            </h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/edit_game/' . $data->id) }}" method="post">
                                {{-- CSRF token for secure form requests --}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Game Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Game Title" value="{{ $data->name }}"
                                                style="border-radius:5px;" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="classroom_edit_games" name="classroom_id"
                                                class="form-control form-control-sm" required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}"
                                                        @if ($classroomId == $data->classroom_id) selected @endif>
                                                        {{ $classroomName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('classroom_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_code" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_code" value="subject_code" hidden="">
                                            <select id="subject_edit_games" name="subject_code"
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
                                            <label for="coursetype" class="col-form-label">Games Url</label>
                                            <input type="text" name="coursetype" class="form-control form-control-sm"
                                                placeholder="Enter Games url" value="{{ $data->url }}" required>
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
        var selected = document.getElementById('selectedData');

        selected.disabled = true;

        $(document).ready(function() {
            $("#classroom").change(function() {
                selected.innerHTML = '';


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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var selected = document.getElementById('selectedData');
        selected.disabled = true;
        // Assuming $teachers contains the teacher data

        $(document).ready(function() {
            $("#classroom").change(function() {
                selected.innerHTML = '';
                var selectedClassroomId = $(this).val();
                selected.disabled = false;

                $.ajax({
                    url: "{{ env('APP_URL') }}/api/test",
                    method: "POST",
                    data: {
                        'classroom_id': selectedClassroomId,

                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        data.forEach(function(item) {
                            let newOption = document.createElement('option');
                            newOption.innerText = item.name;
                            newOption.value = item.subject_code;
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
            function fetchSubjects(classroomId, selectedSubjectId = null) {
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#subject_edit_games').empty();
                            $('#subject_edit_games').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#subject_edit_games').append('<option value="' + key +
                                    '">' + value + '</option>');
                            });

                            if (selectedSubjectId) {
                                $('#subject_edit_games').val(selectedSubjectId);
                            }
                        }
                    });
                } else {
                    $('#subject_edit_games').empty();
                    $('#subject_edit_games').append('<option value="">Select subject</option>');
                }
            }

            $('#classroom_edit_games').change(function() {
                var classroomId = $(this).val();
                fetchSubjects(classroomId);
            });

            // Trigger change event on page load if classroom is already selected
            if ($('#classroom_edit_games').val() != '0') {
                fetchSubjects($('#classroom_edit_games').val(), '{{ $data->subject_code ?? '' }}');
            }
        });
    </script>
@endsection
