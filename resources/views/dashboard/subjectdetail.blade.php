@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                             <h4 class="font-weight-bold mb-0">
                                <a href="/dashboard" style="text-decoration:none;color:black;">Class >  </a>
                                <a href="/dashboard/class_subject?class={{$pageMenu['classroom_id']}}" style="text-decoration:none;color:black;">{{$pageMenu['className']}} > </a>
                                <a href="/dashboard/course_data?subject_code={{$pageMenu['subject_code']}}" style="text-decoration:none;color:black;">{{$pageMenu['subjectName']}} </a> > Content
                            </h4>
                           
                    </div>
                </div>
            </div>
            <div class="row">
              @if(count($courses_data) > 0)
                @foreach($courses_data as $courses)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/dashboard/Video_frame?id={{$courses->id}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <h5 style="font-weight: bold;">{{$courses->course_title}}</h5>  
                                </div>
                                <div class="col-md-3 col-sm-3">
                                        @if($courses->courses_type == 'Video')
                                            <i class="fa-solid fa-circle-play"></i>
                                        @else
                                           <i class="fa-solid fa-file-pdf"></i>
                                        @endif
                                </div>
                            </div>
                            <div class="row">
                                 <div class="col-md-12" style="font-size:14px;">
                                    Subject Code: {{$courses->subject_code}}
                                    </div>
                            </div>
                            <div class="media">
                                <br>
                               
                                <div class="media-body">
                                     <p style="font-size:15px;">{{$courses->description}}</p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>    
                </div>
                @endforeach
                @else
                 <p style="font-size:20px; text-align:center;">No Courses Available</p>
                @endif
               
            </div>
{{--            Todo: chart and statistics--}}
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
