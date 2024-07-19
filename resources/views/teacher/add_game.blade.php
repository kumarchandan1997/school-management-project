@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ isset($subject) ? 'Edit' : 'Add New' }} Requested Content
                                {{ isset($subject) ? 'with The Number: ' . $subject->subject_code : '' }}</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('teacher/add_game') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_title" class="col-form-label">Game Title</label>
                                            <input type="text" class="form-control" name="course_title" id="course_title"
                                                autofocus placeholder="Game Title" value="" style="border-radius:5px;"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="games_classroom_id" name="classroom_id"
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
                                            <label for="subject_code" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_code" value="subject_code" hidden>
                                            <select id="selected_games_Subject" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                {{-- <option value="">Select subject</option> --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="coursetype" class="col-form-label">Games Url</label>
                                            <input type="text" name="coursetype" class="form-control form-control-sm"
                                                placeholder="Enter Games url" required>
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
            $('#games_classroom_id').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#selected_games_Subject').empty();
                            $('#selected_games_Subject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selected_games_Subject').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selected_games_Subject').empty();
                    $('#selected_games_Subject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>
@endsection
