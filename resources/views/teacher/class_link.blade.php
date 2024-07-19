@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($subject) ? 'Edit' : 'Add New' }} Live class
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/class_link') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="live_class_classroom_id" name="classroom_id"
                                                class="form-control form-control-sm" data-dependent='classroom_id' required>
                                                <option value="0">Select a Class</option>
                                                @foreach ($classrooms as $classroomId => $classroomName)
                                                    <option value="{{ $classroomId }}">{{ $classroomName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subject_name" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_name" value="subject_name" hidden>
                                            <select id="selectedLiveClassSubject" name="subject_name"
                                                class="form-control form-control-sm" required>
                                                {{-- <option value="">Select subject</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="topic_id" class="col-form-label">Topic</label>
                                            <select id="live_class_topic_id" name="topic_id"
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
                                            <label for="subtopic_id" class="col-form-label">Sub Topic</label>
                                            <select id="live_class_subtopic_id" name="subtopic_id"
                                                class="form-control form-control-sm" required>
                                                <option value="">Select Topic</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="class_link" class="col-form-label">Meeting Link</label>
                                            <input type="text" class="form-control" name="class_link" id="url"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="class_time" class="col-form-label">From Meeting Time</label>
                                            <input type="datetime-local" class="form-control" name="class_time"
                                                id="class_time" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to_meeting_time" class="col-form-label">To Meeting Time</label>
                                            <input type="datetime-local" class="form-control" name="to_meeting_time"
                                                id="to_meeting_time" required>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Get the current date and time
                                    const currentDateTime = new Date();
                                    const currentYear = currentDateTime.getFullYear();
                                    const currentMonth = (currentDateTime.getMonth() + 1).toString().padStart(2, '0');
                                    const currentDay = currentDateTime.getDate().toString().padStart(2, '0');
                                    const currentHour = currentDateTime.getHours().toString().padStart(2, '0');
                                    const currentMinute = currentDateTime.getMinutes().toString().padStart(2, '0');

                                    // Set the minimum value for the datetime-local input to the current date and time
                                    const minDateTime = `${currentYear}-${currentMonth}-${currentDay}T${currentHour}:${currentMinute}`;
                                    document.getElementById("class_time").setAttribute("min", minDateTime);
                                </script>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note" class="col-form-label">Note</label>
                                            <input type="text" class="form-control" name="note" id="note"
                                                required>
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
            $("#classroom").change(function() {
                $('#selectedData').empty(); // Clear previous options
                var selectedClassroomId = $(this).val();

                $.ajax({
                    url: "/teacher/test/test",
                    method: "POST",
                    data: {
                        'classroom_id': selectedClassroomId,
                        '_token': '{{ csrf_token() }}' // Add CSRF token
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        data.forEach(function(item) {
                            $('#selectedData').append($('<option>', {
                                value: item.subject_code,
                                text: item.name
                            }));
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
            $('#live_class_classroom_id').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            console.log(data);
                            $('#selectedLiveClassSubject').empty();
                            $('#selectedLiveClassSubject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selectedLiveClassSubject').append(
                                    '<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selectedLiveClassSubject').empty();
                    $('#selectedLiveClassSubject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectedLiveClassSubject').change(function() {
                var subjectId = $(this).val();

                var classroomId = $('#live_class_classroom_id').val();

                if (subjectId != '0' && classroomId != '0') {
                    console.log("Both classroomId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.topics', ['classroom' => 'classroomId', 'subject' => 'subjectId']) }}'
                            .replace('classroomId', classroomId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#live_class_topic_id').empty();
                            $('#live_class_topic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#live_class_topic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#live_class_topic_id').empty();
                    $('#live_class_topic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#live_class_topic_id').change(function() {
                var topicId = $(this).val();

                var subjectId = $('#selectedLiveClassSubject').val();

                if (subjectId != '0' && topicId != '0') {
                    console.log("Both topicId and subjectId are non-zero. Making AJAX call.");
                    $.ajax({
                        url: '{{ route('get.subtopics', ['topic' => 'topicId', 'subject' => 'subjectId']) }}'
                            .replace('topicId', topicId)
                            .replace('subjectId', subjectId),
                        method: 'GET',
                        success: function(data) {
                            $('#live_class_subtopic_id').empty();
                            $('#live_class_subtopic_id').append(
                                '<option value="0">Select a Topic</option>');
                            $.each(data, function(key, value) {
                                $('#live_class_subtopic_id').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    console.log("Either classroomId or subjectId is zero. Defaulting to empty option.");
                    $('#live_class_subtopic_id').empty();
                    $('#live_class_subtopic_id').append('<option value="0">Select a Topic</option>');
                }
            });
        });
    </script>
@endsection
