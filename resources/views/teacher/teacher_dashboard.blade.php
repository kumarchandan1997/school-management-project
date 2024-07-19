@extends('layouts.app_view');
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0"><a href="#" style="text-decoration:none; color:black;">Class</a></h4> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($classroom_details as $class)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/teacher/subject?id={{$class->id}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="heading5">{{$class->name}}</h5>  
                                </div>
                                 <div class="col-md-12">
                                     <P class="total">Subject:{{$total_subjects[$class->id]}}</P>
                                </div>
                            </div>
                            <div class="media">
                                <br>
                                <p style="font-size:15px;"></p>
                                <div class="media-body">
                                    <p class="card-text">
                                        {{$class->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>    
                </div>
               @endforeach     
            </div>
           <div class="card">
            <div class="card-body">
                <div class="row">
                    <a href="{{ url('https://diksha.gov.in/ncert/exploren/1?id=ncert_k-12&selectedTab=textbook') }}" target="_blank">
                <img src="{{ asset('student/images/download.jpg') }}" width="250px" height="350px" alt="">
            </a>
            </div>
            </div>
        </div>
{{--  Todo: chart and statistics--}}
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
