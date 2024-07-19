@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/manage-homework') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by Homework name , classroom,topic,sub topic...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/manage-homework') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Manage Homework</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Title</th>
                                            <th>Classroom</th>
                                            <th>Subject</th>
                                            {{-- <th> Sub Topic</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($homeworks as $home)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $home->homework_title }}</td>
                                                <td>{{ $home->classroom_name }}</td>
                                                <td>{{ $home->subject_name }}</td>
                                                {{-- <td>{{ $home->subtopic_name }}</td> --}}
                                                <td>
                                                    <button type="button" class="btn btn-info ti-share btn-rounded"
                                                        data-toggle="modal"
                                                        data-target="#shareModalHomework{{ $home->id }}">
                                                        Share
                                                    </button>
                                                    <div class="btn-group">
                                                        <form action="/teacher/edit_homework/{{ $home->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/teacher/homework-delete/{{ $home->id }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button
                                                                onclick="return confirm('Are you sure You want to delete this?')"
                                                                type="submit" class="btn btn-danger ti-trash btn-rounded">
                                                                Delete</button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No homework found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $homeworks->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>

    {{-- model code  --}}
    @foreach ($homeworks as $home)
        <div class="modal fade" id="shareModalHomework{{ $home->id }}" tabindex="-1" role="dialog"
            aria-labelledby="shareModalHomeworkLabel{{ $home->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalHomeworkLabel{{ $home->id }}">Share Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/homeworks_shares/{{ $home->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-emails">Select Students</label>
                                <input type="text" class="form-control" id="search-students-{{ $home->id }}"
                                    placeholder="Search students by full name">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all-{{ $home->id }}">
                                    <label class="form-check-label" for="select-all-{{ $home->id }}">Select All</label>
                                </div>
                                <div class="row" id="student-list-{{ $home->id }}">
                                    @foreach ($students as $index => $student)
                                        @if ($index % 2 == 0)
                                            <div class="w-100"></div>
                                        @endif
                                        <div class="col-6 student-item" data-fullname="{{ $student->full_name }}">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input student-checkbox-{{ $home->id }}"
                                                    id="student-{{ $student->id }}-{{ $home->id }}"
                                                    name="student_ids[]" value="{{ $student->id }}">
                                                <label class="form-check-label"
                                                    for="student-{{ $student->id }}-{{ $home->id }}">{{ $student->full_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add a description textarea -->
                                <div class="form-group mt-3">
                                    <label for="description-{{ $home->id }}">Description</label>
                                    <textarea class="form-control" id="description-{{ $home->id }}" name="description" rows="3"
                                        placeholder="Add a description"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Share</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- model code end  --}}

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($homeworks as $game)
                document.getElementById('search-students-{{ $game->id }}').addEventListener('keyup',
                    function() {
                        var searchQuery = this.value.toLowerCase();
                        var studentItems = document.querySelectorAll(
                            '#student-list-{{ $game->id }} .student-item');

                        studentItems.forEach(function(item) {
                            var fullName = item.getAttribute('data-fullname').toLowerCase();
                            if (fullName.includes(searchQuery)) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });

                document.getElementById('select-all-{{ $game->id }}').addEventListener('change', function() {
                    var checkboxes = document.querySelectorAll(
                        '#student-list-{{ $game->id }} .student-item');
                    checkboxes.forEach(function(item) {
                        var checkbox = item.querySelector('.student-checkbox-{{ $game->id }}');
                        if (item.style.display !== 'none') {
                            checkbox.checked = document.getElementById(
                                'select-all-{{ $game->id }}').checked;
                        }
                    });
                });
            @endforeach
        });
    </script>
@endsection
