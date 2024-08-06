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

            .video-container-course-Material {
                position: relative;
                width: 100%;
                max-width: 640px;
                margin: auto;
            }

            .video-container-course-Material video {
                width: 100%;
                height: auto;
            }

            .full-screen-icon {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: rgba(0, 0, 0, 0.5);
                color: white;
                padding: 5px;
                cursor: pointer;
                border-radius: 3px;
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
                                @if ($item->course_type === 'Video')
                                    @if ($item->status === 'admin')
                                        <div class="video-container-course-Material">
                                            <video controls>
                                                <source src="{{ asset($item->content_link) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="full-screen-icon" onclick="toggleFullScreen(this)">🔍</div>
                                        </div>
                                    @else
                                        <div class="video-container-course-Material">
                                            <video controls>
                                                <source src="{{ asset('videos/' . $item->content_link) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div class="full-screen-icon" onclick="toggleFullScreen(this)">🔍</div>
                                        </div>
                                    @endif
                                @elseif ($item->course_type === 'PDF')
                                    <button class="content-button"
                                        data-content-link="{{ asset('videos/' . $item->content_link) }}"
                                        onclick="openContentInNewTab('{{ asset('videos/' . $item->content_link) }}')">
                                        Click to view PDF
                                    </button>
                                @endif
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

        function toggleFullScreen(element) {
            const videoContainer = element.parentElement;
            if (videoContainer.requestFullscreen) {
                videoContainer.requestFullscreen();
            } else if (videoContainer.mozRequestFullScreen) { // Firefox
                videoContainer.mozRequestFullScreen();
            } else if (videoContainer.webkitRequestFullscreen) { // Chrome, Safari and Opera
                videoContainer.webkitRequestFullscreen();
            } else if (videoContainer.msRequestFullscreen) { // IE/Edge
                videoContainer.msRequestFullscreen();
            }
        }

        $(document).ready(function() {
            $('#gamesTable').DataTable();
        });
    </script>
@endsection
