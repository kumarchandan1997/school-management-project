@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @foreach($classroom_name as $name)
                            <h4 class="font-weight-bold mb-0"><a href="/dashboard" style="text-decoration:none; color:black;">Class > </a>{{$name->name}}</h4>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 @foreach($subject_detail as $subject)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/dashboard/course_data?subject_code={{$subject->subject_code}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 style="font-weight: bold;">{{$subject->name}}</h5>
                                    <div class="col-md-12" style="font-size:14px;">
                                        Subject code: {{$subject->subject_code}}
                                    </div>  
                                </div>
                                 <div class="col-md-12">
                                     <P class="heading4">Courses: {{$course_details[$subject->subject_code]}}</P>
                                </div>
                            </div>
                            <div class="media">
                                <br>
                                <div class="media-body">
                                   <p style="font-size:15px;">{{$subject->description}}</p>
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
