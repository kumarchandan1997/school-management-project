@extends('layouts.app_view')

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/manage_game') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by game name,topic,subtopic....">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/manage_game') }}'"
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
                            <h4 class="card-title">Games Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="classroomTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>classroom</th>
                                            <th>Subject</th>
                                            <th>Game</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($data as $game)
                                            <tr>
                                                <td class="py-1">{{ $i++ }}</td>
                                                <td>{{ $game->name }}</td>
                                                <td>{{ $game->class_name }}</td>
                                                <td>{{ $game->subject_name }}</td>
                                                {{-- <td>
                                                    <a href="{{ $game->url }}" target="_blank">View Game</a>
                                                </td> --}}
                                                <td class="course_link">
                                                    @if ($game->status == 'Pending')
                                                        <span class="link_achar"
                                                            style="color: grey; cursor: not-allowed;">{{ $game->url }}</span>
                                                    @else
                                                        <a href="{{ $game->url }}"
                                                            class="link_achar">{{ $game->url }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-info ti-share btn-rounded"
                                                        data-toggle="modal"
                                                        data-target="#shareModalGame{{ $game->id }}">
                                                        Share
                                                    </button>
                                                    <a href="{{ url('teacher/delete_game/' . $game->id) }}">
                                                        <button class="btn btn-danger ti-trash btn-rounded">Delete</button>
                                                    </a>
                                                    <a href="{{ url('teacher/edit_game/' . $game->id) }}">
                                                        <button class="btn btn-dark ti-pencil-alt btn-rounded">Edit</button>
                                                    </a>
                                                    {{-- @if ($game->status == 0)
                                                        <a href="{{ url('teacher/status/' . $game->id) }}">
                                                            <button class="btn btn-primary">Share</button>
                                                        </a>
                                                    @elseif($game->status == 1)
                                                        <a href="{{ url('teacher/status/' . $game->id) }}">
                                                            <button class="btn btn-primary">UnShare</button>
                                                        </a>
                                                    @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>


    {{-- model code  --}}
    @foreach ($data as $game)
        <div class="modal fade" id="shareModalGame{{ $game->id }}" tabindex="-1" role="dialog"
            aria-labelledby="shareModalGameLabel{{ $game->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareModalGameLabel{{ $game->id }}">Share Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/teacher/educational_games_shares/{{ $game->id }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="recipient-emails">Select Students</label>
                                <input type="text" class="form-control" id="search-students-{{ $game->id }}"
                                    placeholder="Search students by full name">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all-{{ $game->id }}">
                                    <label class="form-check-label" for="select-all-{{ $game->id }}">Select All</label>
                                </div>
                                <div class="row" id="student-list-{{ $game->id }}">
                                    @foreach ($students as $index => $student)
                                        @if ($index % 2 == 0)
                                            <div class="w-100"></div>
                                        @endif
                                        <div class="col-6 student-item" data-fullname="{{ $student->full_name }}">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    class="form-check-input student-checkbox-{{ $game->id }}"
                                                    id="student-{{ $student->id }}-{{ $game->id }}"
                                                    name="student_ids[]" value="{{ $student->id }}">
                                                <label class="form-check-label"
                                                    for="student-{{ $student->id }}-{{ $game->id }}">{{ $student->full_name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Add a description textarea -->
                                <div class="form-group mt-3">
                                    <label for="description-{{ $student->id }}">Description</label>
                                    <textarea class="form-control" id="description-{{ $student->id }}" name="description" rows="3"
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

    {{-- Include DataTables JS and CSS via CDN --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @foreach ($data as $game)
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

    {{-- Initialize DataTable --}}
    <script>
        $(document).ready(function() {
            $('#classroomTable').DataTable();
        });
    </script>
@endsection
