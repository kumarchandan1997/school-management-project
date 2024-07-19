@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/manage-live-class') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by LiveClass classroom,topic,sub topic...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/manage-live-class') }}'"
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
                            <h4 class="card-title">Manage LiveClass</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Classroom</th>
                                            {{-- <th>Subject</th> --}}
                                            <th>Subject</th>
                                            <th>Topic</th>
                                            <th>Meeting Link</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($meetingLinks as $meeting)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $meeting->classroom_name }}</td>
                                                <td>{{ $meeting->subject_name }}</td>
                                                <td>{{ $meeting->topic_name }}</td>
                                                <td>{{ $meeting->class }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        {{-- <form action="/teacher/edit_homework/{{ $meeting->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form> --}}
                                                        <form action="/teacher/homework-delete/{{ $meeting->id }}"
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
                                {!! $meetingLinks->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
