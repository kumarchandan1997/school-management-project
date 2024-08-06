@extends('layouts.app_view');

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
                            <h4 class="card-title">Add New Homework</h4>
                            <p class="card-description"></p>
                            <form class="forms-sample" action="{{ url('/teacher/save_homework') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="homework_title" class="col-form-label">Title</label>
                                            <input type="text" class="form-control" name="homework_title"
                                                id="homework_title" autofocus="" placeholder="Homework Title"
                                                value="" style="border-radius:5px;" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="classroom_id" class="col-form-label">Class</label>
                                            <select id="homework_classroom_id" name="classroom_id"
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
                                            <label for="subject_code" class="col-form-label">Subject</label>
                                            <input type="text" name="subject_code" value="subject_code" hidden>
                                            <select id="selectedHomeworkSubject" name="subject_code"
                                                class="form-control form-control-sm" required>
                                                {{-- <option value="">Select subject</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="content_id" class="col-form-label">Approve Content</label>
                                            <select id="content_id" name="content_id"
                                                class="form-control form-control-sm select2">
                                                <option value="">Select an option</option>
                                                @foreach ($content as $option)
                                                    <option value="{{ $option->id }}">{{ $option->course_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="homework_file" class="col-form-label">Add homework</label>
                                            <input type="file" id="homework_file" name="homework_file"
                                                accept=".pdf,.doc,.docx" style="display: inline-block;">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="col-form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Add a description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
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
            $('#homework_classroom_id').change(function() {
                var classroomId = $(this).val();
                if (classroomId != '0') {
                    $.ajax({
                        url: '{{ route('get.subjects', '') }}/' + classroomId,
                        method: 'GET',
                        success: function(data) {
                            $('#selectedHomeworkSubject').empty();
                            $('#selectedHomeworkSubject').append(
                                '<option value="">Select subject</option>');
                            $.each(data, function(key, value) {
                                $('#selectedHomeworkSubject').append('<option value="' +
                                    key +
                                    '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#selectedHomeworkSubject').empty();
                    $('#selectedHomeworkSubject').append('<option value="">Select subject</option>');
                }
            });
        });
    </script>
@endsection
