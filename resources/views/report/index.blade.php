@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-6">
                    <form action="{{ url('/classroom/report') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by content name, subject, or teacher..."
                                value="{{ request()->query('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" style="margin-left: 10px;">Search</button>
                                <button class="btn btn-secondary" type="button"
                                    onclick="window.location.href='{{ url('/classroom/report') }}'"
                                    style="margin-left: 10px;">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 d-flex justify-content-end">
                    <a href="{{ route('report.export', ['search' => request()->query('search')]) }}"
                        class="btn btn-success">Download</a>
                </div>
            </div>

            <!-- Report Details Table -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Report Details</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Content Name</th>
                                            <th>Teacher</th>
                                            <th>Classroom</th>
                                            <th>Subject</th>
                                            <th>Content</th>
                                            <th>Open Time</th>
                                            <th>Close Time</th>
                                            <th>Total Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportLogs as $log)
                                            @php
                                                $openTime = new DateTime($log->open_time);
                                                $closeTime = new DateTime($log->close_time);
                                                $interval = $openTime->diff($closeTime);
                                                $formattedInterval = $interval->format('%h hours %i minutes');
                                            @endphp
                                            <tr>
                                                <td>{{ $log->id }}</td>
                                                <td>{{ $log->course_title }}</td>
                                                <td>{{ $log->fullname }}</td>
                                                <td>{{ $log->classroom_name }}</td>
                                                <td>{{ $log->subject_name }}</td>
                                                <td>
                                                    <a href="{{ asset('videos/' . $log->video) }}" target="_blank">View
                                                        Content</a>
                                                </td>
                                                <td>{{ $log->open_time }}</td>
                                                <td>{{ $log->close_time }}</td>
                                                <td>{{ $formattedInterval }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                <!-- Pagination if needed -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
@endsection
