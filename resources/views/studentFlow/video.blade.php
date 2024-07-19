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

            <h2>Video Link</h2>

            <table>
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Title</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Topic</th>
                        <th>Sub Topic</th>
                        <th>Description</th>
                        <th>Topic Link</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($videoUrlShares as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->course_title ?? '-' }}</td>
                            <td>{{ $item->classroom_name ?? '-' }}</td>
                            <td>{{ $item->subject_name ?? '-' }}</td>
                            <td>{{ $item->topic_name ?? '-' }}</td>
                            <td>{{ $item->subtopic_name ?? '-' }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td><a href="{{ $item->course_link }}">{{ $item->course_link }}</a></td>
                            {{-- <td>{{ $item->meeting_time }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
@endsection()
