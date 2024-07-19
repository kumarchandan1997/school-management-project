@extends('layouts.app_view');

@section('content')

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-10 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{isset($subject)? 'Edit': 'Add New'}} Requested Content {{isset($subject)? 'with The Number: '.$subject->subject_code: ''}}</h4>
                            <p class="card-description">
                            </p>
                            <form class="forms-sample" action="{{route('store')}}" method="post">
{{--                                This @csrf is for more secure form requests.--}}
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-3 col-form-label">Course Title</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="course_title" id="course_title" autofocus
                                                       placeholder="Course Title" value="" style="border-radius:5px;" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="classroom" class="col-sm-3 col-form-label">Classroom</label>
                                            <div class="col-sm-9">
                                                <select id="classroom" name="classroom" class="form-control form-control-sm" data-dependent = 'subject' required>
                                                    <option value="0">Select a Classroom</option>
                                                    @if(isset($subject))
                                                        @foreach($classrooms as $classroom)
                                                            <option value="{{$classroom->id}}"
                                                                {{($subject->classroom->id== $classroom->id)? 'selected': ''}}>
                                                                {{$classroom->name}}
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        @foreach($classrooms as $classroom)
                                                            <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                              <label for="semester" class="col-sm-3 col-form-label">Subject</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="subject_name" value="subject_name" hidden>
                                                <select id="selectedData" name="subject" class="form-control form-control-sm" required>
                                                        <option value="subject_Code">select subject</option>
                                                        <!-- <option value="1">Second</option> -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label for="teacher" class="col-sm-3 col-form-label">Courses Type</label>
                                            <div class="col-sm-9">
                                                <select id="coursetype" name="coursetype" class="form-control form-control-sm" required>
                                                    <option value="">Select a courses type</option>
                                                     <option value="PDF" id="option1" >PDF</option>
                                                     <option value="Video" id="option1" >Video</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    {{ csrf_field() }}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="myTextarea" class="col-sm-2 col-form-label">URL</label>
                                            <div class="col-sm-10">
                                                <input type="text" style="resize: vertical;" rows="3" class="form-control" name="url"
                                                          id="url" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label for="myTextarea" class="col-sm-2 col-form-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" style="resize: vertical;" rows="3" class="form-control" name="description"
                                                          id="myTextarea" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Save</button>
                                <a class="btn btn-light" href="/subject">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

var selected=document.getElementById('selectedData');

selected.disabled = true;

$(document).ready(function() {
     $("#classroom").change(function() {
      selected.innerHTML = '';
        
    
         var selectedClassroomId = $(this).val();
           selected.disabled = false;
           
           
        $.ajax({
            url: "{{env('APP_URL')}}"+"/api/test", 
            method: "POST",
            data: {'classroom_id' : selectedClassroomId},
            dataType: "json", 
            success: function(data) {
                console.log(data);
                allOptions = '';
                    data.forEach(function(item) {
                    console.log(item.name);
                    let newOption = document.createElement('option');
                    newOption.innerText = item.name;
                    newOption.value = item.subject_code;
                    console.log(newOption.value)
                    //console.log(newOption);
                    selected.appendChild(newOption);
                 });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
     });
});
</script>
 
@endsection
