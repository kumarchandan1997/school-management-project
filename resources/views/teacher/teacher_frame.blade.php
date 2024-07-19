@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0">
                                <a href="/teacher/teacher_dashboard" style="text-decoration:none;color:black;">Class >  </a>
                                <a href="/teacher/subject?id={{$pageMenu['classroom_id']}}" style="text-decoration:none;color:black;">{{$pageMenu['className']}} > </a>
                                <a href="/teacher/courses?subject_code={{$pageMenu['subject_code']}}" style="text-decoration:none;color:black;">{{$pageMenu['subjectName']}} </a> > Content
                            </h4>
                       </div>
                   </div>
              </div>
              @foreach($course_detail as $course)
            <div class="row">
                    <div class="col-md-9 mb-3 " style="font-size:15px;">
                      Course Title :  {{ $course->course_title }}
                    </div>
                    <div class="col-md-3 mb-3 course">
                       Subject Code : {{ $course->subject_code }}
                    </div> 
            </div>
            <div class="row">
           
            <div class="col-md-12 mb-3" style="font-size:15px;">
                    {{$course->description}}
            </div>
             </div>
             
            <div class="row">
                 @if ($course->courses_type === 'PDF')
                <!-- Add a condition to enable full-screen button for PDFs -->
                <button id="pdf-fullscreen-button">View on Fullscreen</button>
                @endif
                
                <iframe src="{{$course->url}}" width="100%" height="800" style="border:1px solid black;" allowfullscreen>
                </iframe>
                </div>    
            </div>
            @endforeach
        </div>
    </div>
    <script>
            // JavaScript to enable full-screen toggle for PDFs
            const pdfIframe = document.querySelector('iframe[src$=".pdf"]');
            const pdfFullscreenButton = document.getElementById('pdf-fullscreen-button');
            if (pdfIframe) {
                pdfFullscreenButton.addEventListener('click', togglePdfFullscreen);
                function togglePdfFullscreen() {
                    if (!document.fullscreenElement) {
                        pdfIframe.requestFullscreen();
                    } else {
                        document.exitFullscreen();
                    }
                }
            }
        </script>

@endsection
