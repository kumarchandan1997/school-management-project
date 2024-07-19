@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0">
                                <a class="page_link" href="/teacher/teacher_dashboard" >Class > </a>
                                <a  class="page_link" href="/teacher/subject?id={{$new_data['classroom_id']}}"> {{$new_data['class_name']}} ></a>
                                 <a class="page_link" href="/teacher/courses?subject_code={{$new_data['subject_code']}}"> {{$new_data['subjectName']}}</a>
                                 > Content</h4> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(count($courses_detail)>0)
                @foreach($courses_detail as $course)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/teacher/frame?id={{$course->id}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <h5 class="heading5">{{$course->course_title}}</h5> 
                                </div>
                                 <div class="col-md-3 ">
                                        @if($course->courses_type == 'Video')
                                            <i class="fa-solid fa-circle-play"></i>
                                        @else
                                           <i class="fa-solid fa-file-pdf"></i>
                                        @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-size:14px;">
                                    Subject Code:{{$course->subject_code}}
                                </div>
                             </div>
                            <div class="media">
                                <br>
                                <p style="font-size:15px;"></p>
                                <div class="media-body">
                                    <p class="card-text">
                                        {{$course->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>    
                </div>
               @endforeach  
               @else
               <p style="font-size:20px; text-align:center;">No Content Available</p>
               @endif   
            </div>
{{--            Todo: chart and statistics--}}
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
