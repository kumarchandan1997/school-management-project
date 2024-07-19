@extends('stu_compo.main')
@section('main-container')
    <div class="container">
        <title>Homeworks</title>
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
                    @foreach ($homeWorksShares as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->homework_title ?? '-' }}</td>
                            <td>{{ $item->classroom_name ?? '-' }}</td>
                            <td>{{ $item->subject_name ?? '-' }}</td>
                            <td>{{ $item->topic_name ?? '-' }}</td>
                            <td>{{ $item->subtopic_name ?? '-' }}</td>
                            <td>{{ $item->description ?? '-' }}</td>
                            {{-- <td><a href="{{ $item->homework_link }}">{{ $item->homework_link }}</a></td> --}}
                            <td>
                                <button class="content-button"
                                    onclick="showContent('{{ url('storage/homeworks/' . $item->homework_link) }}')">
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
        function showContent(contentLink) {
            // Find the iframe or create one if it doesn't exist
            let iframe = document.getElementById('pdf-iframe');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'pdf-iframe';
                iframe.width = '100%';
                iframe.height = '600px';
                iframe.style.border = 'none';
                document.body.appendChild(iframe);
            }

            // Set the source of the iframe to the content link
            iframe.src = contentLink;
            iframe.style.display = 'block';
        }
    </script>
@endsection
