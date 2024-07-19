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

            <h2>Live Class</h2>

            <table id="gameTable" class="display">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Topic</th>
                        <th>Sub Topic</th>
                        <th>Description</th>
                        <th>Live Class Link</th>
                        <th>Live Class Time</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($liveclassshares as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->topic_name }}</td>
                            <td>{{ $item->subtopic_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td><a href="{{ $item->meeting_link }}">{{ $item->meeting_link }}</a></td>
                            <td>{{ $item->meeting_time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#gameTable').DataTable();
        });
    </script>
@endsection
