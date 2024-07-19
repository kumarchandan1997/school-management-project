@extends('layouts.app_view');

@section('content')


    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Content Table</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Courses Title</th>
                                        <th>Teacher Name</th>
                                        <th>Subject Name</th>
                                        <!-- <th>Subject Code</th> -->
                                        <th>Classroom</th>
                                        <th>Courses Type</th>
                                        <th>Url</th>
                                        <!-- <th>Teacher</th> -->
                                        <!-- <th>Actions</th> -->
                                        <th>View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($requested_data as $key => $data)
                                        <tr>
                                            <td class="py-1">
                                              {{$data->course_title}} 
                                            </td>
                                            <td>
                                                {{ $teacher_details[$data->teacher_id]['name'] }}
                                            </td>
                                            <td>
                                                {{ $subject_details[$data->subject_code]['name'] }}
                                            </td>
                                            <td>
                                              {{ $classroom_details[$data->classroom_id]['name'] }}
                                            </td>
                                            @if($data->courses_type=="PDF")
                                             <td>
                                                <!-- {{$data->courses_type}} -->
                                                  <i class="fa-solid fa-file-pdf coursetype" ></i>
                                               
                                            </td>
                                            @else
                                             <td>
                                                <!-- {{$data->courses_type}} -->
                                                 <i class="fa-solid fa-circle-play coursetype" ></i>
                                               
                                            </td>
                                            @endif
                                           
                                            <td  class="course_link" >
                                               <a href="{{$data->url}}"  class="link_achar"> {{$data->url}}</a>
                                            </td>
                                            <td>
                                               <div class="btn-group">
                                                    @if($data->status == "Approved")
                                                        <a href="/courses/course_frame?course_id={{$data->id}}">
                                                            <button type="button" class="btn btn-success btn-rounded">View Details</button>
                                                        </a>
                                                    @else
                                                        <a href="/courses/course_frame?course_id={{$data->id}}">
                                                            <button type="button" class="btn btn-danger btn-rounded">View Demo</button>
                                                        </a>
                                                    @endif
                                                    
                                                </div>

                                            </td>
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                
                               {!! $requested_data->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    

@endsection
