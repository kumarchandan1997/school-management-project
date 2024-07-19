@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/teacher/manage-subtopic') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by subtopic classroom , subjet,topic,sub topic...">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/teacher/manage-subtopic') }}'"
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
                            <h4 class="card-title">Manage Sub Topic</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            {{-- <th>Topic Title</th> --}}
                                            <th>Classroom</th>
                                            <th>Subject</th>
                                            <th>Topic</th>
                                            <th> Sub Topic</th>
                                            {{-- <th>Url</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($subtopics as $topic)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $topic->classroom_name }}</td>
                                                <td>{{ $topic->subject_name }}</td>
                                                <td>{{ $topic->topic_name }}</td>
                                                <td>{{ $topic->sub_topic_name }}</td>
                                                {{-- <td><a href="{{ $topic->url }}" target="_blank">{{ $topic->url }}</a></td> --}}
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="/teacher/subtopic-edit/{{ $topic->id }}"
                                                            method="get">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-dark ti-pencil-alt btn-rounded">
                                                                Edit</button>
                                                        </form>
                                                        <form action="/teacher/subtopic-delete/{{ $topic->id }}"
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
                                {!! $subtopics->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
