@extends('layouts.app_view');

@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="font-weight-bold mb-0"><a href="#" style="text-decoration:none; color:black;">Class</a></h4>
<!-- <p>{{ session()->get('role_id')}}</p> -->

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($classrooms as $class)
                <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                    <div class="card">
                        <a href="/dashboard/class_subject?class={{$class->id}}" style="text-decoration:none; color:black;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <h4 class="heading5">{{$class->name}}</h4>
                                </div>
                                 <div class="col-md-12">
                                     <h4 class="heading4">Subject: {{ isset($subjectCounts[$class->id]) ? $subjectCounts[$class->id] :  0 }}</h4>
                                </div>
                            </div>
                            <div class="media">
                                <br>
                                <!-- <p style="font-size:15px;">{{$class->description}} </p> -->
                                <div class="media-body">
                                      <p style="font-size:15px;">{{$class->description}} </p>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
           
                </div>
                @endforeach
                
            </div>
{{--            Todo: chart and statistics--}}
{{--            <div class="row">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title text-md-center text-xl-left">Sales</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">34040</h3>
                                <i class="ti-calendar icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                            </div>
                            <p class="mb-0 mt-2 text-danger">0.12% <span class="text-black ms-1"><small>(30 days)</small></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title text-md-center text-xl-left">Revenue</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">47033</h3>
                                <i class="ti-user icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                            </div>
                            <p class="mb-0 mt-2 text-danger">0.47% <span class="text-black ms-1"><small>(30 days)</small></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title text-md-center text-xl-left">Downloads</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">40016</h3>
                                <i class="ti-agenda icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                            </div>
                            <p class="mb-0 mt-2 text-success">64.00%<span class="text-black ms-1"><small>(30 days)</small></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title text-md-center text-xl-left">Returns</p>
                            <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">61344</h3>
                                <i class="ti-layers-alt icon-md text-muted mb-0 mb-md-3 mb-xl-0"></i>
                            </div>
                            <p class="mb-0 mt-2 text-success">23.00%<span class="text-black ms-1"><small>(30 days)</small></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-1 col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Bar chart</h4>
                            <canvas id="barChart" height="280" width="600"></canvas>
                        </div>
                    </div>
                </div>
            </div>--}}
        </div>
        <!-- content-wrapper ends -->
    </div>

@endsection
