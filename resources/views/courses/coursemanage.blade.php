@extends('layouts.app_view');

@section('content')
    <!-- @php
        var_dump($courses_detail[0]);
    @endphp -->

    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/courses/manage') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by courses title,subject name ,code & classroom...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/courses/manage') }}'"
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
                            <h4 class="card-title">Content Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Content Title</th>
                                            <!-- <th>Subject Code</th> -->
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>
                                            <th>Classroom</th>
                                            <th>Content Type</th>
                                            <th>Url</th>
                                            <!-- <th>description</th> -->
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($courses_detail as $key => $course)
                                            <tr>
                                                <td class="py-1">
                                                    {{ $course->course_title }}
                                                </td>
                                                <td>
                                                    {{ $subject_names[$key] }}
                                                </td>
                                                <td>

                                                    {{ $course->subject_code }}
                                                </td>
                                                <td>

                                                    {{ $classroom_names[$key] }}
                                                </td>
                                                @if ($course->courses_type == 'PDF')
                                                    <td>
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    </td>
                                                @else
                                                    <td>
                                                        <i class="fa-solid fa-circle-play"></i>

                                                    </td>
                                                @endif

                                                <td class="course_link">
                                                    <a class="link_achar" href="{{ $course->url }}">
                                                        {{ $course->url }}</a>
                                                </td>
                                                <!-- <td style="max-width: 180px; white-space: wrap;">
                                                                            {{ $course->description }}
                                                                            
                                                                        </td> -->
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="/courses/edit_course/{{ $course->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/courses/delete/{{ $course->id }}" method="post">
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $courses_detail->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
