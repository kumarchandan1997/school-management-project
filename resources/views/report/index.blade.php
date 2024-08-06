@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- Search Form -->
            <div class="row mb-3">
                <div class="col-lg-10">
                    <form action="{{ url('/classroom/report') }}" method="GET" style="display: flex; align-items: flex-end;">
                        <div class="form-group" style="margin-right: 10px;">
                            <label for="search">Search</label>
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Search by content name, subject, or teacher..."
                                value="{{ request()->query('search') }}">
                        </div>
                        <div class="form-group" style="margin-right: 10px;">
                            <label for="start_date">From Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                placeholder="From Date" value="{{ request()->query('start_date') }}">
                        </div>
                        <div class="form-group" style="margin-right: 10px;">
                            <label for="end_date">To Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="To Date"
                                value="{{ request()->query('end_date') }}">
                        </div>
                        <div class="form-group" style="margin-right: 10px;">
                            <button class="btn btn-primary" type="submit" style="margin-top: 32px;">Search</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-secondary" type="button"
                                onclick="window.location.href='{{ url('/classroom/report') }}'"
                                style="margin-top: 32px;">Reset</button>
                        </div>
                    </form>
                </div>


                <div class="col-lg-2 d-flex justify-content-end">
                    <a href="{{ route('report.export', ['search' => request()->query('search')]) }}" class="btn btn-success"
                        style="padding: 11px;
    margin: 43px;">Download</a>
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
                                                if ($log->content_table_name == 'videos') {
                                                    $closeTime = new DateTime($log->close_time);
                                                    $interval = $openTime->diff($closeTime);
                                                    $formattedInterval = $interval->format('%h hours %i minutes');
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $log->id }}</td>
                                                <td>{{ $log->content_name }}</td>
                                                <td>{{ $log->fullname }}</td>
                                                <td>{{ $log->classroom_name }}</td>
                                                <td>{{ $log->subject_name }}</td>
                                                @if ($log->content_table_name == 'videos')
                                                    <td>
                                                        <a href="{{ asset('videos/' . $log->content) }}"
                                                            target="_blank">View
                                                            Content</a>
                                                    </td>
                                                @else
                                                    <td><a href="{{ $log->content }}" target="_blank">View
                                                            Content</a></td>
                                                @endif
                                                <td>{{ $log->open_time }}</td>
                                                @if ($log->content_table_name == 'videos')
                                                    <td>{{ $log->close_time }}</td>
                                                    <td>{{ $formattedInterval }}</td>
                                                @else
                                                    <td>-</td>
                                                    <td>-</td>
                                                @endif
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
    </div>
@endsection
