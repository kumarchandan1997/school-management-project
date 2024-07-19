@extends('stu_compo.main')
@section('main-container')
    <div class="container">
        <title>Course Material</title>
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
            <h2>Course Material</h2>
            <table id="gamesTable" class="display">
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
                    @foreach ($myContentShares as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->content_title ?? '-' }}</td>
                            <td>{{ $item->classroom_name ?? '-' }}</td>
                            <td>{{ $item->subject_name ?? '-' }}</td>
                            <td>{{ $item->topic_name ?? '-' }}</td>
                            <td>{{ $item->subtopic_name ?? '-' }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            <td>
                                <button class="content-button"
                                    data-content-link="{{ asset('videos/' . $item->content_link) }}"
                                    data-course-type="{{ $item->course_type }}"
                                    onclick="openContentInNewTab('{{ asset('videos/' . $item->content_link) }}')">
                                    Click to view content
                                </button>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
    <script>
        function openContentInNewTab(contentLink) {
            var win = window.open(contentLink, '_blank');
            win.focus();
        }
    </script>
@endsection
