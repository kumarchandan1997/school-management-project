@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0"><a class="page_link" href="/teacher/teacher_dashboard">Class > </a>{{$classroomName}}</h4> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($subject_data as $subject)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/teacher/courses?subject_code={{$subject->subject_code}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="heading5">{{$subject->name}}</h5>
                                </div>
                                 <div class="col-md-12">
                                     <P class="total" >Course:{{$course_counts[$subject->subject_code]}}</P>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12" style="font-size:14px;">
                                       Subject Code:{{$subject->subject_code}}
                                    </div>
                                  </div>
                            <div class="media">
                                <br>
                                <p style="font-size:15px;"></p>
                                <div class="media-body">
                                    <p class="card-text">
                                        {{$subject->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>    
                </div>
               @endforeach     
            </div>
{{--            Todo: chart and statistics--}}
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
