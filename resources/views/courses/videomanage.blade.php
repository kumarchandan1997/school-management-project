@extends('layouts.app_view')

@section('content')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/courses/videomanager') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/courses/videomanager') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Content Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Class</th>
                                            <th>Subject</th>
                                            {{-- <th>Course Title</th> --}}
                                            <th>Teacher Name</th>
                                            {{-- <th>Courses Type</th> --}}
                                            <th>Video/pdf/url</th>
                                            <th>Status</th>
                                            {{-- <th>Diksha</th>
                                            <th>Game</th> --}}
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($requested_data as $data)
                                            <tr>
                                                <td>{{ $i++ }}</td>


                                                <td>
                                                    @if ($data->classroom_id == 1)
                                                        Nursary
                                                    @elseif($data->classroom_id == 2)
                                                        Class 2
                                                    @elseif($data->classroom_id == 3)
                                                        Class 3
                                                    @elseif($data->classroom_id == 4)
                                                        Class 4
                                                    @elseif($data->classroom_id == 5)
                                                        Class 5
                                                    @elseif($data->classroom_id == 6)
                                                        Class 6
                                                    @elseif($data->classroom_id == 7)
                                                        Class 7
                                                    @elseif($data->classroom_id == 8)
                                                        Class 8
                                                    @elseif($data->classroom_id == 9)
                                                        Class 9
                                                    @elseif($data->classroom_id == 10)
                                                        Class 10
                                                    @else
                                                        Next 10 class
                                                    @endif

                                                </td>


                                                <td>
                                                    @php
                                                        $dataa = DB::table('subjects')
                                                            ->where('subject_code', $data->subject_code)
                                                            ->first();
                                                    @endphp
                                                    {{ $dataa->name ?? '-' }}
                                                </td>

                                                {{-- <td class="py-1">{{ $data->course_title }}</td> --}}
                                                <td>{{ $teacher_details[$data->teacher_id]['name'] }}</td>
                                                {{-- <td>
                                                    @if ($data->courses_type == 'PDF')
                                                        <i class="fa-solid fa-file-pdf coursetype"></i>
                                                    @else
                                                        <i class="fa-solid fa-circle-play coursetype"></i>
                                                    @endif
                                                </td> --}}

                                                {{-- <td class="course_link">
                                                    @php
                                                        $extension = pathinfo($data->video, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($extension === 'mp4' || $extension === 'webm' || $extension === 'ogg')
                                                        <video width="150" height="200" controls>
                                                            <source src="{{ asset('videos/' . $data->video) }}"
                                                                type="video/{{ $extension }}">
                                                        </video>
                                                    @else
                                                        <a href="{{ asset('videos/' . $data->video) }}" target="_black">
                                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                                                width="100" height="100" viewBox="0 0 48 48">
                                                                <path fill="#90CAF9" d="M40 45L8 45 8 3 30 3 40 13z"></path>
                                                                <path fill="#E1F5FE" d="M38.5 14L29 14 29 4.5z"></path>
                                                                <path fill="#1976D2"
                                                                    d="M16 21H33V23H16zM16 25H29V27H16zM16 29H33V31H16zM16 33H29V35H16z">
                                                                </path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </td> --}}

                                                {{-- <td class="course_link">
                                                    <video width="150" height="200" controls>
                                                        <source src="{{ asset('videos/' . $data->video) }}" type="video/mp4">
                                                    </video>
                                                </td> --}}
                                                {{-- {{ dd($data->table_name) }} --}}
                                                {{-- 
                                                <td>
                                                    @if ($data->status == 'Pending')
                                                        <a href="{{ url('courses/status/' . $data->id) }}">
                                                            <button type="submit" class="btn btn-primary"
                                                                style="background-color:red ">Pending</button>
                                                        </a>
                                                    @else
                                                        <a href="{{ url('courses/status/' . $data->id) }}">
                                                            <button type="submit" class="btn btn-primary">Approve</button>
                                                        </a>
                                                    @endif
                                                </td> --}}

                                                <td>{{ $data->url ?? '-' }}</td>

                                                <td>
                                                    <form action="{{ url('courses/update-status') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                                        <input type="hidden" name="table_name"
                                                            value="{{ $data->table_name }}">
                                                        @if ($data->status == 'Pending')
                                                            <button type="submit" class="btn btn-primary"
                                                                style="background-color:red">Pending</button>
                                                        @else
                                                            <button type="submit" class="btn btn-primary">Approve</button>
                                                        @endif
                                                    </form>
                                                </td>


                                                {{-- <td>
                                                    <a href="{{ $data->diksh }}" target="_blank">Diksha</a>
                                                </td>
                                                <td>
                                                    <a href="{{ $data->games }}" target="_blank">Game</a>
                                                </td> --}}
                                                <td>
                                                    <a href="{{ url('courses/video_delete/' . $data->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-trash3-fill"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $requested_data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
