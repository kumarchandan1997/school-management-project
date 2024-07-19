@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/manage-topic') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by topic name,classroom & subjet...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/manage-topic') }}'"
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
                            <h4 class="card-title">Manage Topic</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Topic Title</th>
                                            <th>Classroom</th>
                                            <th>Subject</th>
                                            {{-- <th>Url</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topics as $topic)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $topic->course_title }}</td>
                                                <td>{{ $topic->classroom_name }}</td>
                                                <td>{{ $topic->subject_name }}</td>
                                                {{-- <td><a href="{{ $topic->url }}" target="_blank">{{ $topic->url }}</a></td> --}}
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="/teacher/topic-edit/{{ $topic->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/teacher/topic-delete/{{ $topic->id }}"
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
                                                <td colspan="6" class="text-center">No topics found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $topics->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
