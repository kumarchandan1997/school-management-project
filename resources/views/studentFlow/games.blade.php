@extends('stu_compo.main')
@section('main-container')
    <div class="container">
        <title>Games in Bangladesh</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
            }
        </style>
        </head>

        <body>

            <h2>Educational Games</h2>

            <table id="example">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Class</th>
                        <th>Subject</th>
                        {{-- <th>Topic</th> --}}
                        {{-- <th>Sub Topic</th> --}}
                        <th>Description</th>
                        <th>Live Game Link</th>
                        {{-- <th>Live Class Time</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($educationGamesShares as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->classroom_name }}</td>
                            <td>{{ $item->subject_name ?? '-' }}</td>
                            {{-- <td>{{ $item->topic_name ?? '-' }}</td> --}}
                            {{-- <td>{{ $item->subtopic_name ?? '-' }}</td> --}}
                            <td>{{ $item->description ?? '-' }}</td>
                            <td><a href="{{ $item->game_link }}">{{ $item->game_link }}</a></td>
                            {{-- <td>{{ $item->meeting_time }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
            <script>
                new DataTable('#example');
            </script>


    </div>
@endsection()
